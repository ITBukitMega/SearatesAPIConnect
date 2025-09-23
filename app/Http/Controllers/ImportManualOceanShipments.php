<?php

namespace App\Http\Controllers;

use App\Models\Xls_OceanShipment;
use Illuminate\Http\Request;

class ImportManualOceanShipments extends Controller
{
    public function index() {
        return view("excel-import-manual");
    }

    public function store(Request $request) {
        $request->validate([
            'booking_number' => 'required|unique:Xls_OceanShipment,booking_number',
            'ocean_line' => 'required',
            'shipment_reference' => 'required',
            'shipper' => 'required',
            'promised_eta' => 'required',
            'promised_etd' => 'required',
            'po_number' => 'required',
            'product_number' => 'required',
            'product_description' => 'required',
            'product_quantity' => 'required',
            'quantity_uom' => 'required',
            'shipment_tags' => 'required',
            'visible_to' => 'required',
            'team_names' => 'required'
        ]);

        Xls_OceanShipment::create($request->all());

        return redirect()->back()->with('success', 'Import data manually Successfully');
    }
}
