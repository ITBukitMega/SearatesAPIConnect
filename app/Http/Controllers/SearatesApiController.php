<?php

namespace App\Http\Controllers;

use App\Models\DtlContainer;
use App\Models\DtlEvents;
use App\Models\DtlLocation;
use App\Models\DtlVessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MstTracking;
use Carbon\Carbon;

class SearatesApiController extends Controller
{
    public function index()
    {
        $apiKey = env("API_KEY");
        // MRKU8340485 SSLLCBLWCAA0379 ASC0447790 ASC0447792 CNB0280539 PGUCB25000883 PGUCB25000885 SSLKUSRGCAA0479 COAU7258683330
        $number = "EGLV050500317973";

        $response = Http::get("https://tracking.searates.com/tracking", [
            'api_key' => $apiKey,
            'number' => $number 
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];

            // Simpan ke database
            MstTracking::updateOrCreate(
                ['blnumber' => $data['metadata']['number']],
                [
                    'type' => $data['metadata']['type'] ?? null,
                    'sealine' => $data['metadata']['sealine'] ?? null,
                    'sealine_name' => $data['metadata']['sealine_name'] ?? null,
                    'status' => $data['metadata']['status'] ?? null,
                    'syncTime' => Carbon::now('Asia/Jakarta'),
                ]
            );

            //Simpan Detail Location
            foreach ($data['locations'] as $location) {
                DtlLocation::create([
                    'api_id' => $location['id'],
                    'blnumber' => $data['metadata']['number'],
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
                DtlVessel::create([
                    'blnumber' => $data['metadata']['number'],
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
                DtlContainer::create([
                    'blnumber' => $data['metadata']['number'],
                    'number' => $container['number'],
                    'iso_code' => $container['iso_code'],
                    'size_type' => $container['size_type'],
                    'status' => $container['status'],
                    'syncTime' => Carbon::now('Asia/Jakarta'),
                ]);

                foreach ($container['events'] ?? [] as $event) {
                    DtlEvents::create([
                        'blnumber' => $data['metadata']['number'],
                        'no_container' => $container['number'],
                        'order_id' => $event['order_id'],
                        'location' => $event['location'],
                        'facility' => $event['facility'],
                        'description' => $event['description'],
                        'event_type' => $event['event_type'],
                        'event_code' => $event['event_code'],
                        'status' => $event['status'],
                        'date' => $event['date'],
                        'actual' => $event['actual'],
                        'is_date_from_sealine' => $event['is_date_from_sealine'],
                        'is_additional_event' => $event['is_additional_event'],
                        'type' => $event['type'],
                        'transport_type' => $event['transport_type'],
                        'vessel' => $event['vessel'],
                        'voyage' => $event['voyage'],
                        'syncTime' => Carbon::now('Asia/Jakarta'),
                    ]);
                }
            }



            return view("searates", ['trackingData' => $data]);
        } else {
            return response()->json(['error' => 'Failed to fetch tracking data'], 500);
        }
    }
}
