<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTesting extends Model
{
    use HasFactory;

    protected $fillable = [
        "booking_number",
        "ocean_line",
        "shipment_reference",
        "mbl_number",
        "hbl_number",
        "shipper",
        "consignee",
        "promised_eta",
        "promised_etd",
        "incoterm",
        "po_number",
        "invoice_number",
        "order_date",
        "product_number",
        "product_description",
        "hs_code",
        "product_quantity",
        "quantity_uom",
        "unit_price",
        "price_currency",
        "lot_number",
        "production_date",
        "expiration_date",
        "shipment_tags",
        "partner_org_numbers",
        "origin_demurrage_medium",
        "origin_demurrage_high",
        "destination_demurrage_medium",
        "destination_demurrage_high",
        "origin_demurrage_free_days",
        "origin_detention_free_days",
        "destination_demurrage_free_days",
        "destination_detention_free_days",
        "visible_to",
        "team_names",
    ];
}
