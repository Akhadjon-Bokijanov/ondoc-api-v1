<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('facturaId')->primary()->unique();
            $table->integer('version')->default(0);
            $table->integer('facturaType');
            $table->boolean('singleSidedType')->default(false);
            $table->string('facturaNo', 1000);
            $table->dateTime('facturaDate');
            $table->string('oldFacturaId')->nullable();
            $table->string('oldFacturaNo')->nullable();
            $table->dateTime('oldFacturaDate')->nullable();
            $table->string('facturaProductId');
            $table->longText('notes')->nullable();
            $table->integer('facturaType');
            $table->integer('currentStateid');
            $table->string('lotId')->nullable();
            $table->integer('inCallBack')->default(0);

            $table->boolean('hasVat')->default(false);
            $table->boolean('hasExcise')->default(false);
            $table->boolean('hasMarking')->default(false);
            $table->boolean('hasMedical')->default(false);

            $table->string('contractNo', 1000);
            $table->dateTime('contractDate');

            $table->string('empowermentNo', 1000)->nullable();
            $table->dateTime('empowermentDateOfIssue')->nullable();
            $table->string('agentFio', 1000)->nullable();
            $table->integer('agentTin')->nullable();
            $table->string('agentFacturaId', 100)->nullable();

            $table->string('itemReleasedFio', 1000)->nullable();
            $table->string("itemReleaseTin")->nullable();
            $table->string('itemReleasePinf1')->nullable();

            $table->integer('sellerTin');
            $table->integer('buyerTin')->nullable();

            $table->string('sellerAccount', 1000)->nullable();
            $table->string('sellerBankId', 10)->nullable();
            $table->string('sellerName', 1000);
            $table->string('sellerAddress', 1000)->nullable();
            $table->string('sellerMobilePhone', 20)->nullable();
            $table->string('sellerWorkPhone', 20)->nullable();
            $table->string('sellerOked', 20)->nullable();
            $table->string('sellerDistrictId', 20)->nullable();
            $table->string('sellerDirector', 1000)->nullable();
            $table->string('sellerAccountant', 1000)->nullable();
            $table->string('sellerVatRegCode', 15)->nullable();
            $table->string('sellerBranchName', 1000)->nullable();
            $table->string('sellerBranchCode', 15)->nullable();

            $table->string('buyerAccount', 1000)->nullable();
            $table->string('buyerBankId', 10)->nullable();
            $table->string('buyerName', 1000);
            $table->string('buyerAddress', 1000)->nullable();
            $table->string('buyerMobilePhone', 20)->nullable();
            $table->string('buyerWorkPhone', 20)->nullable();
            $table->string('buyerOked', 20)->nullable();
            $table->string('buyerDistrictId', 20)->nullable();
            $table->string('buyerDirector', 1000)->nullable();
            $table->string('buyerAccountant', 1000)->nullable();
            $table->string('buyerVatRegCode', 15)->nullable();
            $table->string('buyerBranchName', 1000)->nullable();
            $table->string('buyerBranchCode', 15)->nullable();

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
        Schema::dropIfExists('facturas');
    }
}
