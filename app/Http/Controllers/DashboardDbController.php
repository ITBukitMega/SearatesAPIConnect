<?php

namespace App\Http\Controllers;

use App\Models\API_Container;
use App\Models\API_Events;
use App\Models\API_Locations;
use App\Models\API_Route;
use App\Models\API_Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MstTracking;
use App\Models\DtlContainer;
use App\Models\DtlEvents;
use App\Models\DtlLocation;
use App\Models\DtlRoute;
use App\Models\DtlVessel;

class DashboardDbController extends Controller
{
    public function index()
    {
        return view('dashboard-db', ['trackingData' => null]);
    }

    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'bl_number' => 'required|string|max:50'
        ]);

        $blNumber = strtoupper(trim($request->input('bl_number')));

        try {
            // Cari data di MstTracking
            $masterTracking = MstTracking::where('blnumber', $blNumber)->first();

            if (!$masterTracking) {
                return response()->json([
                    'status' => 'error',
                    'error' => "BL Number '{$blNumber}' not found in the system."
                ], 404);
            }

            // Ambil semua data terkait
            $containers = API_Container::where('blnumber', $blNumber)->get();
            $events = API_Events::where('blnumber', $blNumber)->orderBy('order_id')->get();
            $locations = API_Locations::where('blnumber', $blNumber)->get();
            $vessels = API_Vessel::where('blnumber', $blNumber)->get();
            $routes = API_Route::where('blnumber', $blNumber)->get();

            // Format data EXACT seperti API response Searates
            $response = [
                'status' => 'success',
                'message' => 'OK',
                'data' => [
                    'metadata' => [
                        'type' => $masterTracking->type,
                        'number' => $masterTracking->blnumber,
                        'sealine' => $masterTracking->sealine,
                        'sealine_name' => $masterTracking->sealine_name,
                        'status' => $masterTracking->status,
                        'is_status_from_sealine' => false,
                        'from_cache' => true,
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                        'cache_expires' => now()->addHours(12)->format('Y-m-d H:i:s'),
                        'api_calls' => [
                            'total' => null,
                            'used' => null,
                            'remaining' => null
                        ],
                        'unique_shipments' => [
                            'total' => 0,
                            'used' => 0,
                            'remaining' => 0
                        ]
                    ],
                    'locations' => [],
                    'facilities' => [], // Empty array since we don't have facilities table
                    'route' => null,
                    'vessels' => [],
                    'containers' => []
                ]
            ];

            // Format locations - gunakan api_id sebagai id
            foreach ($locations as $location) {
                $response['data']['locations'][] = [
                    'id' => (int)$location->api_id,
                    'name' => $location->name,
                    'state' => $location->state,
                    'country' => $location->country,
                    'country_code' => $location->country_code,
                    'locode' => $location->locode,
                    'lat' => (float)$location->lat,
                    'lng' => (float)$location->lng,
                    'timezone' => $location->timezone
                ];
            }

            // Format vessels - gunakan api_id sebagai id
            foreach ($vessels as $vessel) {
                $response['data']['vessels'][] = [
                    'id' => (int)$vessel->api_id,
                    'name' => $vessel->name,
                    'imo' => (int)$vessel->imo,
                    'call_sign' => $vessel->call_sign,
                    'mmsi' => (int)$vessel->mmsi,
                    'flag' => $vessel->flag
                ];
            }

            // Format containers with events - EXACT format seperti API
            foreach ($containers as $container) {
                $containerEvents = $events->where('no_container', $container->number)->sortBy('order_id')->values();

                $formattedEvents = [];
                foreach ($containerEvents as $event) {
                    $formattedEvents[] = [
                        'order_id' => (int)$event->order_id,
                        'location' => (int)$event->location,
                        'facility' => $event->facility ? (int)$event->facility : null,
                        'description' => $event->description,
                        'event_type' => $event->event_type,
                        'event_code' => $event->event_code,
                        'status' => $event->status,
                        'date' => $event->date,
                        'actual' => $event->actual == '1' ? true : false,
                        'is_date_from_sealine' => $event->is_date_from_sealine == '1' ? true : false,
                        'is_additional_event' => $event->is_additional_event == '1' ? true : false,
                        'type' => $event->type,
                        'transport_type' => $event->transport_type,
                        'vessel' => $event->vessel ? (int)$event->vessel : null,
                        'voyage' => $event->voyage
                    ];
                }

                $response['data']['containers'][] = [
                    'number' => $container->number,
                    'iso_code' => $container->iso_code,
                    'size_type' => $container->size_type,
                    'status' => $container->status,
                    'is_status_from_sealine' => false,
                    'charges' => [
                        'storage' => [
                            'free_days' => null,
                            'days_in_charge' => null
                        ],
                        'demurrage' => [
                            'free_days' => null,
                            'days_in_charge' => null
                        ],
                        'detention' => [
                            'free_days' => null,
                            'days_in_charge' => null
                        ]
                    ],
                    'events' => $formattedEvents
                ];
            }

            // Format route data dari DtlRoute table - EXACT format seperti API
            $routeData = [];
            foreach ($routes as $route) {
                $routeData[$route->route_type] = [
                    'location' => (int)$route->location,
                    'date' => $route->date,
                    'actual' => $route->actual == '1' ? true : false
                ];

                // Add predictive_eta untuk POD jika ada
                if ($route->route_type === 'pod' && isset($route->predictive_eta)) {
                    $routeData[$route->route_type]['predictive_eta'] = $route->predictive_eta;
                } else if ($route->route_type === 'pod') {
                    $routeData[$route->route_type]['predictive_eta'] = null;
                }
            }

            // Set route ke response
            if (!empty($routeData)) {
                $response['data']['route'] = $routeData;
            }

            Log::info("Database tracking search successful for BL: {$blNumber}");
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error("Database error for BL {$blNumber}: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'error' => 'An error occurred while fetching tracking data from database. Please try again.'
            ], 500);
        }
    }
}
