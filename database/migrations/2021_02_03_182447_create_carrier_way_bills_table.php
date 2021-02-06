<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierWayBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_way_bills', function (Blueprint $table) {
            $table->id();

            $table->string("wayBillId")->index();
            $table->string("wayBillProductId")->index();
            $table->integer("status")->default(1);
            $table->text("notes")->nullable();
            $table->integer("carrierTin")->nullable();
            $table->text("carrierName")->nullable();
            $table->integer("customerTin")->nullable();
            $table->text("customerName")->nullable();

            $table->string("wayBillNo");
            $table->dateTime("wayBillDate");

            $table->integer("deliveryType");

            $table->string("contractNo");
            $table->dateTime("contractDate");

            $table->string("tripTicketNo")->nullable();
            $table->dateTime("tripTicketDate")->nullable();

            $table->string("truckRegNo")->nullable();
            $table->string("truckModel")->nullable();

            $table->integer("trailerType")->nullable();
            $table->string("trailerRegNo")->nullable();
            $table->string("trailerModel")->nullable();

            $table->text("driverFio")->nullable();

            $table->integer("sellerTin");
            $table->text("sellerName");

            $table->integer("buyerTin");
            $table->text("buyerName");

            $table->text("pointOfLoading")->nullable();
            $table->text("pointOfUnloading")->nullable();

            $table->text("pointOfRedirectName")->nullable();
            $table->text("pointOfRedirectAddress")->nullable();

            $table->text("specialNotes")->nullable();

            $table->text("giverFio")->nullable();
            $table->text("giverDriverFio")->nullable();
            $table->text("takerDriverFio")->nullable();
            $table->text("tekerFio")->nullable();

            $table->decimal("deliveryDistance", 20, 2)->nullable();
            $table->decimal("deliveryDistanceInCity", 20, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrier_way_bills');
    }
}
