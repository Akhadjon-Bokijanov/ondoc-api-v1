<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id')->index();

            $table->integer('ordNo');
            $table->text('name');
            $table->string('catalogCode');
            $table->string('catalogName');
            $table->string('barCode')->nullable();
            $table->integer('measureId');
            $table->integer('count');
            $table->decimal('summa', 15,2);
            $table->decimal('vatRate', 15,2);
            $table->decimal('vatSum', 15,2);
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
        Schema::dropIfExists('contract_products');
    }
}
