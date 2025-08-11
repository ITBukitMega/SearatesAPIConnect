<?php

namespace App\Imports;

use App\Models\UserTesting;
use App\Models\Xls_OceanShipment;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow() : int {
        return 2;
    }

    public function model(array $row)
    {

        //Skip baris kosong kalo ada
        if(empty($row[0])){
            return null;
        }

        //Cek satu2 kalau ada yang sama aja booking number nya maka data gabisa masuk ke db semua
        $booking_number = (string)$row[0];
        if(Xls_OceanShipment::where('booking_number', $booking_number)->exists()) {
            throw ValidationException::withMessages([
                'file' => ["Booking Number {$booking_number} sudah ada di database"]
            ]);
        }

        $parseDateTime = function($dateValue) {
            if (empty($dateValue)) return null;

            try {
                if(is_numeric($dateValue)) {
                    return Carbon::createFromDate(1900, 1,1)
                    ->addDays($dateValue - 2)
                    ->format('Y-m-d');
                }

                return Carbon::parse($dateValue)->format('Y-m-d');

            } catch(\Exception $e){
                return null;
            }
        };
        return new Xls_OceanShipment([
            'booking_number' => $row[0],
            'ocean_line' => $row[1],
            'shipment_reference' => $row[2],
            'shipper' => $row[3],
            'promised_eta' => $parseDateTime($row[4]),
            'promised_etd' => $parseDateTime($row[5]),
            'po_number' => $row[6],
            'product_number' => $row[7],
            'product_description' => $row[8],
            'product_quantity' => $row[9],
            'quantity_uom' => $row[10],
            'shipment_tags' => $row[11],
            'visible_to' => $row[12],
            'team_names'  =>$row[13],
        ]);
    }
}