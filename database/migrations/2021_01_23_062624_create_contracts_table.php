<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            //CONTRACT MODEL
            $table->string('contractId', 30)->index();
            $table->boolean('hasVat')->default(false);
            $table->string("contractName");
            $table->string("contractNo");
            $table->dateTime('contractDate');
            $table->dateTime('contractExpireDate')->nullable();
            $table->text('contractPlace')->nullable();
            $table->integer('status')->default(1);

            //SELLER AND BUYER || seller AND buyer
            $table->integer('buyerTin')->index();
            $table->integer('sellerTin')->nullable()->index();

            $table->string('buyerAccount', 1000)->nullable();
            $table->string('buyerName', 1000);
            $table->text('buyerAddress')->nullable();
            $table->text('buyerMobilePhone')->nullable();
            $table->text('buyerWorkPhone')->nullable();
            $table->text('buyerOked')->nullable();
            $table->text('buyerDirector')->nullable();
            $table->integer('buyerDirectorTin')->nullable();
            $table->text('buyerBranchName')->nullable();
            $table->string('buyerBranchCode', 15)->nullable();

            $table->string('sellerAccount', 1000)->nullable();
            $table->string('sellerName', 1000);
            $table->text('sellerAddress')->nullable();
            $table->text('sellerMobilePhone')->nullable();
            $table->text('sellerWorkPhone')->nullable();
            $table->text('sellerOked')->nullable();
            $table->text('sellerDirector')->nullable();
            $table->integer('sellerDirectorTin')->nullable();




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
        Schema::dropIfExists('contracts');
    }
}
