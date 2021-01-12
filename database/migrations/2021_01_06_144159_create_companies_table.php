<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('parentId')->nullable();
            $table->integer('tin')->index();
            $table->integer('ns10Code')->nullable();
            $table->integer('ns11Code')->nullable();
            $table->integer('districtId')->nullable();
            $table->string('companyName', 1000);
            $table->string('address', 1500)->nullable();
            $table->integer('oked')->nullable();
            $table->integer('tariffId')->default(1);
            $table->integer('directorTin')->nullable();
            $table->string('directorName', 500)->nullable();
            $table->string('accountant', 500)->nullable();
            $table->integer('regCode')->nullable();
            $table->string('mfo')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type');
            $table->boolean('isAferta')->default(1);
            $table->boolean('isOnline')->default(1);
            $table->integer('countLogin')->default(0);
            $table->dateTime('lastLoginAt')->nullable();
            $table->string("password", 1000);
            $table->string('auth_key', 1000)->nullable();
            $table->longText('afertaText')->nullable();
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
