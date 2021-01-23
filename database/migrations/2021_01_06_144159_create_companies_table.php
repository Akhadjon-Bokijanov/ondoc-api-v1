<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *THIS IS FOR COMPANY MODEL, LEGAL ENTITY
     * https://my.soliq.uz/services/np1/bytin/factura?lang=uz&tin=200523221
     *
     * SOME COMPANIES CAN BE BRANCHES OF OTHER
     * https://my.soliq.uz/services/yur-branchs/getdatabytin?tin=200523221
     *
     * TO GET BRANCHES OF COMPANY BY DIRECTOR TIN
     * https://my.soliq.uz/services/yur-branchs/getbydirectorTin?directorTin=504359034
     *
     * TO GET REG_CODE
     * https://my.soliq.uz/services/nds/reference?tin=305741277
     * @return void
     */
    public function up()
    {
        //STRUCTURE FOR COMPANY
        //https://my.soliq.uz/services/np1/bytin/factura?lang=uz&amp;tin=200523221
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('tin')->index();
            $table->integer('parentTin')->nullable();
            $table->integer('ns10Code')->nullable();
            $table->integer('ns11Code')->nullable();
            $table->string('name', 1000); //THIS CAN BE BRANCH NAME ALSO
            $table->string('branchNum')->nullable(); //THIS IS BRANCH NUM
            $table->text('address')->nullable();
            $table->integer('oked')->nullable();
            $table->integer('tariffId')->default(1);
            $table->integer('directorTin')->nullable();
            $table->string('directorName', 500)->nullable(); //THIS can be director or directorName
            $table->string('accountant', 500)->nullable();
            $table->text('account')->nullable();
            $table->integer('regCode')->nullable();
            $table->string('mfo')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type')->nullable();
            $table->boolean('isAferta')->default(0);
            $table->dateTime('lastLoginAt')->nullable();
            $table->string("password", 1000);
            $table->string('auth_key', 1000)->nullable();
            $table->integer('aferta_id')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
