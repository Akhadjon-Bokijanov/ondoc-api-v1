<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act_products', function (Blueprint $table) {
            $table->id();
            $table->string('actId')->index();
            $table->integer('ordNo');
            $table->text('name');
            $table->integer('measureId');
            $table->integer('count');
            $table->decimal('summa', 15,2);

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
        Schema::dropIfExists('act_products');
    }
}
