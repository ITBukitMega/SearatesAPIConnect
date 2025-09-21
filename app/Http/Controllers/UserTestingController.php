<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UpdateUserTestingRequest;
use App\Models\Xls_OceanShipment;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class UserTestingController extends Controller
{ 
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
       return view('excel-import');
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(HttpRequest $request)
   {
       $request->validate([
           'file' => 'required|file|mimes:xls,xlsx,csv|max:10240'
       ], [
           'file.required' => "File harus dipilih",
           'file.mimes' => 'File harus berformat Excel (.xls, .xlsx) atau CSV.',
           'file.max' => 'Ukuran file maksimal 10MB.'
       ]);

       try {
           $file = $request->file('file');
           DB::beginTransaction();

           // Get booking numbers that existed before import
           $existingBookingNumbers = Xls_OceanShipment::pluck('booking_number')->toArray();

           // Import data
           Excel::import(new UsersImport, $file);

           // Get newly imported booking numbers
           $newBookingNumbers = Xls_OceanShipment::whereNotIn('booking_number', $existingBookingNumbers)
                                                ->pluck('booking_number')
                                                ->toArray();

           DB::commit();

           // Update tracking data synchronous
           $updateResults = [];
           if (!empty($newBookingNumbers)) {
               Log::info("Starting immediate tracking update for booking numbers: " . implode(', ', $newBookingNumbers));
               $updateResults = $this->updateTrackingDataImmediate($newBookingNumbers);
           }

           $importedCount = count($newBookingNumbers);
           $successMessage = "Data Excel berhasil di Import kedalam Database! Total {$importedCount} shipment baru berhasil diimport.";
           
           if (!empty($updateResults['updated'])) {
               $successMessage .= " " . count($updateResults['updated']) . " shipment berhasil diupdate dengan data tracking dari API.";
           }
           
           if (!empty($updateResults['failed'])) {
               $successMessage .= " " . count($updateResults['failed']) . " shipment gagal diupdate dari API (akan dicoba lagi nanti).";
               Log::warning("Failed to update tracking for: " . implode(', ', $updateResults['failed']));
           }

           return back()->with('success', $successMessage);
           
       } catch (ValidationException $e) {
           DB::rollBack();
           return back()->withErrors($e->errors())->withInput();
           
       } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
           DB::rollBack();
           return back()->withErrors(['file' => 'File Excel tidak dapat dibaca. Pastikan file tidak corrupt.']);
           
       } catch (\Exception $e) {
           DB::rollBack();
           Log::error("Import error: " . $e->getMessage());
           return back()->withErrors(['file' => 'Error: ' . $e->getMessage()]);
       }
   }

   /**
    * Update tracking data immediately (synchronous) for better debugging
    */
   private function updateTrackingDataImmediate(array $bookingNumbers)
   {
       $results = [
           'updated' => [],
           'failed' => []
       ];

       $apiKey = 'K-C4091E4C-BB10-4D78-8011-AEB295B2BC82';
       $baseUrl = 'https://tracking.searates.com/tracking';

       foreach ($bookingNumbers as $bookingNumber) {
           try {
               Log::info("Processing tracking for BL: {$bookingNumber}");

               // Add delay untuk setiap hit api agar tidak crash
               if (count($results['updated']) + count($results['failed']) > 0) {
                   sleep(2); // 2 detik delay per req
               }

               $response = Http::timeout(60)->get($baseUrl, [
                   'api_key' => $apiKey,
                   'number' => $bookingNumber
               ]);

               Log::info("API Response for {$bookingNumber}: " . $response->status() . " - " . $response->body());

               if ($response->successful()) {
                   $data = $response->json();
                   
                   // Full Log for Debugging
                   Log::info("Full API response structure for {$bookingNumber}:", $data);
                   
                   if ($this->updateShipmentFromApiData($bookingNumber, $data)) {
                       $results['updated'][] = $bookingNumber;
                   } else {
                       $results['failed'][] = $bookingNumber;
                   }
               } else {
                   $results['failed'][] = $bookingNumber;
                   Log::warning("API tracking failed for BL: {$bookingNumber}", [
                       'status' => $response->status(),
                       'response' => $response->body()
                   ]);
               }

           } catch (\Exception $e) {
               $results['failed'][] = $bookingNumber;
               Log::error("Error updating tracking for BL: {$bookingNumber}", [
                   'error' => $e->getMessage(),
                   'trace' => $e->getTraceAsString()
               ]);
           }
       }

       return $results;
   }

private function updateShipmentFromApiData(string $bookingNumber, array $apiData)
{
    try {
        Log::info("Processing API data for BL: {$bookingNumber}");
        
        // Log the structure we're looking for
        Log::info("API Data structure check for {$bookingNumber}:", [
            'has_data' => isset($apiData['data']),
            'has_route' => isset($apiData['data']['route']),
            'data_keys' => isset($apiData['data']) ? array_keys($apiData['data']) : [],
            'full_structure' => $apiData
        ]);

        $updateData = [];
        $hasUpdates = false;

        // Try different possible API response structures
        $routeData = null;
        
        // Check route dalam data
        if (isset($apiData['data']['route'])) {
            $routeData = $apiData['data']['route'];
            Log::info("Found route data method 1 for {$bookingNumber}");
        }
        // Check route langsung
        elseif (isset($apiData['route'])) {
            $routeData = $apiData['route'];
            Log::info("Found route data method 2 for {$bookingNumber}");
        }
        // check events array (alternative)
        elseif (isset($apiData['data']['events'])) {
            $events = $apiData['data']['events'];
            Log::info("Found events data for {$bookingNumber}, count: " . count($events));
            
            // Liat Departure dan Arrival Events
            foreach ($events as $event) {
                if (isset($event['type']) && isset($event['date'])) {
                    // update Promised_Eta dari POL
                    if (in_array(strtolower($event['type']), ['departure', 'loaded', 'etd', 'pol'])) {
                        $updateData['promised_eta'] = Carbon::parse($event['date'])->format('Y-m-d');
                        $hasUpdates = true;
                        Log::info("Found POL date for promised_eta from events for {$bookingNumber}: " . $event['date']);
                    }
                    // update Promised_Etd dari POD
                    if (in_array(strtolower($event['type']), ['arrival', 'discharged', 'eta', 'pod'])) {
                        $updateData['promised_etd'] = Carbon::parse($event['date'])->format('Y-m-d');
                        $hasUpdates = true;
                        Log::info("Found POD date for promised_etd from events for {$bookingNumber}: " . $event['date']);
                    }
                }
            }
        }

        // Process route data jika ditemukan
        if ($routeData) {
            Log::info("Route data structure for {$bookingNumber}:", $routeData);
            
            // Extract POL date data ke Promised_Eta
            $polDate = null;
            if (isset($routeData['pol']['date']) && !empty($routeData['pol']['date'])) {
                $polDate = $routeData['pol']['date'];
            } elseif (isset($routeData['departure_date'])) {
                $polDate = $routeData['departure_date'];
            } elseif (isset($routeData['etd'])) {
                $polDate = $routeData['etd'];
            }

            if ($polDate) {
                $updateData['promised_eta'] = Carbon::parse($polDate)->format('Y-m-d');
                $hasUpdates = true;
                Log::info("Found POL date for promised_eta for {$bookingNumber}: {$polDate}");
            }

            // Extract POD date data ke Promised_Etd
            $podDate = null;
            if (isset($routeData['pod']['date']) && !empty($routeData['pod']['date'])) {
                $podDate = $routeData['pod']['date'];
            } elseif (isset($routeData['arrival_date'])) {
                $podDate = $routeData['arrival_date'];
            } elseif (isset($routeData['eta'])) {
                $podDate = $routeData['eta'];
            }

            if ($podDate) {
                $updateData['promised_etd'] = Carbon::parse($podDate)->format('Y-m-d');
                $hasUpdates = true;
                Log::info("Found POD date for promised_etd for {$bookingNumber}: {$podDate}");
            }
        }

        // Update additional tracking info jika available
        if (isset($apiData['data']['metadata']['sealine_name'])) {
            $updateData['ocean_line'] = $apiData['data']['metadata']['sealine_name'];
            $hasUpdates = true;
        } elseif (isset($apiData['sealine_name'])) {
            $updateData['ocean_line'] = $apiData['sealine_name'];
            $hasUpdates = true;
        }

        // Add tracking status as shipment tag
        if (isset($apiData['data']['metadata']['status'])) {
            $status = $apiData['data']['metadata']['status'];
            $updateData['shipment_tags'] = $status;
            $hasUpdates = true;
        } elseif (isset($apiData['status'])) {
            $status = $apiData['status'];
            $updateData['shipment_tags'] = $status;
            $hasUpdates = true;
        }

        // Hanya Update jika ada data yang bisa di update
        if ($hasUpdates && !empty($updateData)) {
            $updated = DB::table('Xls_OceanShipment')
                ->where('booking_number', $bookingNumber)
                ->update(array_merge($updateData, [
                    'updated_at' => Carbon::now()
                ]));

            if ($updated) {
                Log::info("Successfully updated tracking data for BL: {$bookingNumber}", $updateData);
                return true;
            } else {
                Log::warning("No rows updated for BL: {$bookingNumber}");
                return false;
            }
        } else {
            Log::info("No useful tracking data found for BL: {$bookingNumber}");
            return false;
        }

    } catch (\Exception $e) {
        Log::error("Error processing API data for BL: {$bookingNumber}", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'api_data' => $apiData
        ]);
        return false;
    }
}

   public function updateTrackingData($bookingNumbers = null)
   {
       if ($bookingNumbers === null) {
           // Get all BL numbers that need updating (e.g., recent imports or null dates)
           $bookingNumbers = Xls_OceanShipment::where(function ($query) {
               $query->whereNull('promised_eta')
                     ->orWhereNull('promised_etd')
                     ->orWhere('updated_at', '>', Carbon::now()->subHours(24));
           })->pluck('booking_number')->toArray();
       }

       if (!is_array($bookingNumbers)) {
           $bookingNumbers = [$bookingNumbers];
       }

       $results = $this->updateTrackingDataImmediate($bookingNumbers);

       return response()->json([
           'success' => true,
           'message' => 'Tracking update completed',
           'updated' => $results['updated'],
           'failed' => $results['failed'],
           'total_processed' => count($bookingNumbers)
       ]);
   }
   
   public function show(Xls_OceanShipment $userTesting)
   {
       //
   }

   public function edit(Xls_OceanShipment $userTesting)
   {
       //
   }

   public function update(UpdateUserTestingRequest $request, Xls_OceanShipment $userTesting)
   {
       //
   }

   public function destroy(Xls_OceanShipment $userTesting)
   {
       //
   }

   public function import(){
       try {
           DB::beginTransaction();
           Excel::import(new UsersImport, storage_path('app/123.xlsx'));
           DB::commit();
           return redirect('/dashboard-db')->with('success', 'All good!');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect('/dashboard-db')->withErrors(['error' => $e->getMessage()]);
       }
   }

   public function downloadTemplate()
   {
       $filePath = storage_path('app/123.xlsx');
       
       if (!file_exists($filePath)) {
           return back()->withErrors(['error' => 'Template file not found.']);
       }
       
       return response()->download($filePath, 'Shipment_Import_Template.xlsx', [
           'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
       ]);
   }
}