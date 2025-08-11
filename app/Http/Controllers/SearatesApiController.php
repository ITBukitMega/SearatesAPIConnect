<?php

namespace App\Http\Controllers;

use App\Models\API_Container;
use App\Models\API_Events;
use App\Models\API_Locations;
use App\Models\API_Route;
use App\Models\API_Vessel;
use App\Models\DtlContainer;
use App\Models\DtlEvents;
use App\Models\DtlLocation;
use App\Models\DtlRoute;
use App\Models\DtlVessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MstTracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SearatesApiController extends Controller
{
    public function index()
    {
        $apiKey = "K-C4091E4C-BB10-4D78-8011-AEB295B2BC82";
        // MRKU8340485 SSLLCBLWCAA0379 ASC0447790 ASC0447792 CNB0280539 PGUCB25000883 PGUCB25000885 SSLKUSRGCAA0479 COAU7258683330
        $number = "SSLKUJKTCAA2311";

        $response = Http::get("https://tracking.searates.com/tracking", [
            'api_key' => $apiKey,
            'number' => $number
        ]);

        if ($response->successful()) {
            $json = $response->json();
            $data = $json['data'] ?? null;

            if (!$data || !isset($data['metadata'])) {
                return response()->json(['error' => 'Invalid API response structure', 'raw' => $json], 500);
            }

            $blNumber = $data['metadata']['number'];

            // Menggunakan transaction untuk memastikan consistency
            DB::transaction(function () use ($data, $blNumber) {

                // Hapus data lama untuk BL Number ini
                MstTracking::where('blnumber', $blNumber)->delete();
                API_Container::where('blnumber', $blNumber)->delete();
                API_Events::where('blnumber', $blNumber)->delete();
                API_Locations::where('blnumber', $blNumber)->delete();
                API_Route::where('blnumber', $blNumber)->delete();
                API_Vessel::where('blnumber', $blNumber)->delete();

                // Simpan ke database
                MstTracking::create([
                    'blnumber' => $blNumber,
                    'type' => $data['metadata']['type'] ?? null,
                    'sealine' => $data['metadata']['sealine'] ?? null,
                    'sealine_name' => $data['metadata']['sealine_name'] ?? null,
                    'status' => $data['metadata']['status'] ?? null,
                    'syncTime' => Carbon::now('Asia/Jakarta'),
                ]);

                //Simpan Detail Location
                foreach ($data['locations'] as $location) {
                    API_Locations::create([
                        'api_id' => $location['id'],
                        'blnumber' => $blNumber,
                        'locode' => $location['locode'] ?? null,
                        'name' => $location['name'] ?? null,
                        'state' => $location['state'] ?? null,
                        'country' => $location['country'] ?? null,
                        'country_code' => $location['country_code'] ?? null,
                        'lat' => $location['lat'] ?? null,
                        'lng' => $location['lng'] ?? null,
                        'timezone' => $location['timezone'] ?? null,
                        'syncTime' => Carbon::now('Asia/Jakarta'),
                    ]);
                }

                //Simpan Detail Vessel
                foreach ($data['vessels'] as $vessel) {
                    API_Vessel::create([
                        'blnumber' => $blNumber,
                        'api_id' => $vessel['id'] ?? null,
                        'name' => $vessel['name'] ?? null,
                        'imo' => $vessel['imo'] ?? null,
                        'call_sign' => $vessel['call_sign'] ?? null,
                        'mmsi' => $vessel['mmsi'] ?? null,
                        'flag' => $vessel['flag'] ?? null,
                        'syncTime' => Carbon::now('Asia/Jakarta'),
                    ]);
                }

                //Simpan Detail Container & Eventsnya
                foreach ($data['containers'] as $container) {
                    API_Container::create([
                        'blnumber' => $blNumber,
                        'number' => $container['number'],
                        'iso_code' => $container['iso_code'],
                        'size_type' => $container['size_type'],
                        'status' => $container['status'],
                        'syncTime' => Carbon::now('Asia/Jakarta'),
                    ]);

                    foreach ($container['events'] ?? [] as $event) {
                        API_Events::create([
                            'blnumber' => $blNumber,
                            'no_container' => $container['number'],
                            'order_id' => $event['order_id'],
                            'location' => $event['location'],
                            'facility' => $event['facility'], // Keep as is, bisa null
                            'description' => $event['description'],
                            'event_type' => $event['event_type'],
                            'event_code' => $event['event_code'],
                            'status' => $event['status'],
                            'date' => $event['date'],
                            'actual' => $event['actual'] ? '1' : '0', // Convert boolean to string
                            'is_date_from_sealine' => $event['is_date_from_sealine'] ? '1' : '0', // Convert boolean to string
                            'is_additional_event' => $event['is_additional_event'] ? '1' : '0', // Convert boolean to string
                            'type' => $event['type'],
                            'transport_type' => $event['transport_type'],
                            'vessel' => $event['vessel'], // Keep as is, bisa null
                            'voyage' => $event['voyage'],
                        ]);
                    }
                }

                //Simpan ke Dtl Route
                $routeTypes = [
                    'prepol' => 'prepol',
                    'pol' => 'pol',
                    'pod' => 'pod',
                    'postpod' => 'postpod',
                ];

                foreach ($routeTypes as $type => $key) {
                    if (isset($data['route'][$key])) {
                        API_Route::create([
                            'blnumber' => $blNumber,
                            'route_type' => $type,
                            'location' => $data['route'][$key]['location'],
                            'date' => $data['route'][$key]['date'],
                            'actual' => $data['route'][$key]['actual'] ? '1' : '0',
                            'predictive_eta' => isset($data['route'][$key]['predictive_eta']) ? $data['route'][$key]['predictive_eta'] : null,
                        ]);
                    }
                }

                //Simpan Facilities ke temporary storage (bisa ditambahkan tabel DtlFacility jika diperlukan)
                // Untuk sementara, facilities disimpan dalam format yang bisa di-retrieve
                // Atau bisa diabaikan jika tidak ada tabel facility
            });

            return view("searates", ['trackingData' => $data]);
        } else {
            return response()->json(['error' => 'Failed to fetch tracking data'], 500);
        }
    }
}
