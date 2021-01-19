<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_products', function (Blueprint $table) {
            $table->id();

            $table->string('facturaProductId')->index();
            $table->integer('ordNo');
            $table->text('committentName')->nullable();
            $table->string('committentTin', 10)->nullable();
            $table->string('vatRegCode', 15)->nullable();
            $table->text('name');
            $table->string('catalogCode');
            $table->string('catalogName');
            $table->string('barCode')->nullable();
            $table->string('productType')->nullable();
            $table->string('serial')->nullable();
            $table->integer('measureId');
            $table->decimal('baseSumma', 15, 2)->default(0);
            $table->decimal('profitRate', 5, 2)->default(0);
            $table->integer('count');
            $table->decimal('summa', 15,2);
            $table->decimal('exciseRate', 15, 2)->default(0);
            $table->decimal('exciseSum', 15,2)->default(0);
            $table->decimal('deliverySum', 15, 2);
            $table->decimal('vatRate', 15,2);
            $table->decimal('deliverySumWithVat', 15,2);
            $table->boolean('withoutVat')->default(false);

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
        Schema::dropIfExists('factura_products');
    }
}
