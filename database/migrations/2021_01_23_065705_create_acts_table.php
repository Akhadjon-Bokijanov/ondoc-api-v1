<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->id();

            $table->string("actNo");
            $table->dateTime('actDate');
            $table->string("actId")->index();
            $table->text('actText');
            $table->string('contractNo');
            $table->dateTime('contractDate');
            $table->integer('sellerTin');
            $table->string('sellerName');
            $table->integer('buyerTin');
            $table->string('buyerName');
            $table->integer('status')->default(1);
            $table->text('notes');

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
        Schema::dropIfExists('acts');
    }
}
