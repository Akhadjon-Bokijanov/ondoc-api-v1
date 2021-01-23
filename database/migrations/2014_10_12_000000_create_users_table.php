<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *This is for User model "Person"
     * TO GET INFO FOR THEM
     * https://my.soliq.uz/services/np1/phisbytin/factura?lang=uz&tin=504359034
     *
     * TO GET FACTURAS
     * https://my.soliq.uz/services/np1/bytin/factura-all?tin={TIN}
     *
     * TO GET REGISTERED LEGAL ENTITIES OF USER AS DIRECTOR
     * https://my.soliq.uz/services/np1/by-directortin/factura?lang={LANGUAGE}&tin={TIN}
     * @return void
     */
    public function up()
    {
        //https://my.soliq.uz/services/np1/phisbytin/factura?lang=uz&amp;tin=504359034
        //structure for person

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName', 500);
            $table->dateTime('dateOfBirth')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('phone')->nullable();
            $table->string('lang')->default('uz');
            $table->integer('tin')->index();
            $table->string('auth_key', 1000);
            $table->integer('status')->default(1);
            $table->string('password', 1000)->nullable();
            $table->text('passSeries')->nullable();
            $table->text('passNumber')->nullable();
            $table->text('passOrg')->nullable();
            $table->text('address')->nullable();
            $table->boolean('isItd')->default(false);
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
