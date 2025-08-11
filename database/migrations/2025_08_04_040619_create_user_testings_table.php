<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_testings', function (Blueprint $table) {
            $table->id();
            $table->string("booking_number")->nullable();
            $table->string("ocean_line")->nullable();
            $table->string("shipment_reference")->nullable();
            $table->string("mbl_number")->nullable();
            $table->string("hbl_number")->nullable();
            $table->string("shipper")->nullable();
            $table->string("consignee")->nullable();
            $table->string("promised_eta")->nullable();
            $table->string("promised_etd")->nullable();
            $table->string("incoterm")->nullable();
            $table->string("po_number")->nullable();
            $table->string("invoice_number")->nullable();
            $table->string("order_date")->nullable();
            $table->string("product_number")->nullable();
            $table->string("product_description")->nullable();
            $table->string("hs_code")->nullable();
            $table->string("product_quantity")->nullable();
            $table->string("quantity_uom")->nullable();
            $table->string("unit_price")->nullable();
            $table->string("price_currency")->nullable();
            $table->string("lot_number")->nullable();
            $table->string("production_date")->nullable();
            $table->string("expiration_date")->nullable();
            $table->string("shipment_tags")->nullable();
            $table->string("partner_org_numbers")->nullable();
            $table->string("origin_demurrage_medium")->nullable();
            $table->string("origin_demurrage_high")->nullable();
            $table->string("destination_demurrage_medium")->nullable();
            $table->string("destination_demurrage_high")->nullable();
            $table->string("origin_demurrage_free_days")->nullable();
            $table->string("origin_detention_free_days")->nullable();
            $table->string("destination_demurrage_free_days")->nullable();
            $table->string("destination_detention_free_days")->nullable();
            $table->string("visible_to")->nullable();
            $table->string("team_names")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_testings');
    }
};
