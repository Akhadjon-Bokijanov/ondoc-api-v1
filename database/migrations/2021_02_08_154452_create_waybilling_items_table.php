<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaybillingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybilling_items', function (Blueprint $table) {
            $table->id();

            $table->string("waybilling_id")->index();
            $table->text("name");
            $table->integer("measureId")->index();
            $table->decimal("price", 15, 2)->default(0);
            $table->integer("count");
            $table->decimal("deliveryCost", 15, 2);
            $table->string("docs")->nullable();
            $table->string("weightMeasureMethod")->nullable();
            $table->text("itemClass")->nullable();
            $table->decimal("weightBrut",20, 2)->nullable();
            $table->decimal("weightNet", 20, 2)->nullable();

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
        Schema::dropIfExists('waybilling_items');
    }
}
