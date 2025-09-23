<?php

namespace App\Http\Controllers;

use App\Models\Xls_OceanShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OceanShipmentsController extends Controller
{
    /**
     * Display a listing of all ocean shipments
     */
    public function index()
    {
        try {
            // Get all ocean shipments ordered by created_at descending
            $oceanShipments = Xls_OceanShipment::orderBy('created_at', 'desc')->get();
            
            return view('ocean-shipments', compact('oceanShipments'));
            
        } catch (\Exception $e) {
            Log::error("Error fetching ocean shipments: " . $e->getMessage());
            
            return view('ocean-shipments')->with('error', 'Failed to load ocean shipments data.');
        }
    }

    /**
     * Search ocean shipments
     */
    public function search(Request $request)
    {
        try {
            $query = Xls_OceanShipment::query();
            
            // Search by booking number
            if ($request->filled('booking_number')) {
                $query->where('booking_number', 'like', '%' . $request->booking_number . '%');
            }
            
            // Search by shipper
            if ($request->filled('shipper')) {
                $query->where('shipper', 'like', '%' . $request->shipper . '%');
            }
            
            // Search by shipper
            if ($request->filled('shipment_reference')) {
                $query->where('shipment_reference', 'like', '%' . $request->shipment_reference . '%');
            }
            
            // Search by consignee
            if ($request->filled('consignee')) {
                $query->where('consignee', 'like', '%' . $request->consignee . '%');
            }
            
            // Search by ocean line
            if ($request->filled('ocean_line')) {
                $query->where('ocean_line', 'like', '%' . $request->ocean_line . '%');
            }
            
            // Search by MBL number
            if ($request->filled('mbl_number')) {
                $query->where('mbl_number', 'like', '%' . $request->mbl_number . '%');
            }
            
            // Search by HBL number
            if ($request->filled('hbl_number')) {
                $query->where('hbl_number', 'like', '%' . $request->hbl_number . '%');
            }
            
            $oceanShipments = $query->orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $oceanShipments,
                'count' => $oceanShipments->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error searching ocean shipments: " . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search ocean shipments.'
            ], 500);
        }
    }
}