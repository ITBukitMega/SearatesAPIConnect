<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\API_Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function getEvents(Request $request)
    {
        try {
            // Ambil tanggal start dan end dari FullCalendar
            $start = $request->input('start');
            $end = $request->input('end');
            
            // Query simple - ambil semua data dulu
            $routeData = API_Route::select('route_type', 'date', 'blnumber')
                ->whereNotNull('date')
                ->when($start, function ($query, $start) {
                    return $query->whereDate('date', '>=', $start);
                })
                ->when($end, function ($query, $end) {
                    return $query->whereDate('date', '<=', $end);
                })
                ->whereIn('route_type', ['pol', 'pod'])
                ->get();

            $events = [];
            
            // Group manual menggunakan Laravel Collections
            $grouped = $routeData->groupBy(function($item) {
                // Format date ke YYYY-MM-DD saja
                return date('Y-m-d', strtotime($item->date));
            });
            
            foreach ($grouped as $date => $dateRecords) {
                // Group by route_type
                $typeGroups = $dateRecords->groupBy('route_type');
                
                // Handle departures (pol)
                if (isset($typeGroups['pol'])) {
                    $departures = $typeGroups['pol'];
                    $departureCount = $departures->count();
                    $blNumbers = $departures->pluck('blnumber')->join(', ');
                    
                    $events[] = [
                        'id' => 'dep_' . $date,
                        'title' => $departureCount . ' Departure' . ($departureCount > 1 ? 's' : ''),
                        'start' => $date,
                        'backgroundColor' => '#ef4444',
                        'borderColor' => '#dc2626',
                        'textColor' => '#ffffff',
                        'classNames' => ['departure-event'],
                        'extendedProps' => [
                            'type' => 'departure',
                            'count' => $departureCount,
                            'bl_numbers' => $blNumbers,
                            'route_type' => 'pol'
                        ]
                    ];
                }
                
                // Handle arrivals (pod)
                if (isset($typeGroups['pod'])) {
                    $arrivals = $typeGroups['pod'];
                    $arrivalCount = $arrivals->count();
                    $blNumbers = $arrivals->pluck('blnumber')->join(', ');
                    
                    $events[] = [
                        'id' => 'arr_' . $date,
                        'title' => $arrivalCount . ' Arrival' . ($arrivalCount > 1 ? 's' : ''),
                        'start' => $date,
                        'backgroundColor' => '#10b981',
                        'borderColor' => '#059669',
                        'textColor' => '#ffffff',
                        'classNames' => ['arrival-event'],
                        'extendedProps' => [
                            'type' => 'arrival',
                            'count' => $arrivalCount,
                            'bl_numbers' => $blNumbers,
                            'route_type' => 'pod'
                        ]
                    ];
                }
            }

            // Debug: Log jumlah events
            Log::info('Calendar events generated: ' . count($events));
            Log::info('Raw events: ' . json_encode($events));

            return response()->json($events);
            
        } catch (\Exception $e) {
            Log::error('Calendar events error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return empty array instead of error to prevent frontend crash
            return response()->json([]);
        }
    }

    public function getEventDetails(Request $request)
    {
        try {
            $date = $request->input('date');
            $type = $request->input('type'); // 'pol' or 'pod'
            
            $routes = API_Route::select('blnumber', 'date', 'location', 'actual')
                ->whereDate('date', $date)
                ->where('route_type', $type)
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $routes,
                'type' => $type === 'pol' ? 'Departures' : 'Arrivals',
                'date' => Carbon::parse($date)->format('d M Y')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch event details'
            ], 500);
        }
    }
}