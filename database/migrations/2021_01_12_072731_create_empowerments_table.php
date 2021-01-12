<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpowermentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empowerments', function (Blueprint $table) {
            $table->id();

            $table->string('empowermentId', 30)->index();
            $table->string('empowermentProductId', 30)->index();
            $table->string('empowermentNo', 20);
            $table->dateTime('empowermentDateOfIssue');
            $table->dateTime('empowermentDateOfExpire');

            $table->integer('buyerTin');
            $table->text('buyerName');
            $table->integer('buyerAccount')->nullable();
            $table->integer('buyerBankId');
            $table->text('buyerAddress')->nullable();
            $table->text('buyerMobile')->nullable();
            $table->text('buyerWorkPhone')->nullable();
            $table->integer('buyerOked')->nullable();
            $table->integer('buyerRegionId')->nullable();
            $table->integer('buyerDistrictId')->nullable();
            $table->string('buyerDirector', 1000)->nullable();
            $table->text('buyerAccountant')->nullable();
            $table->string('buyerVatRegCode')->nullable();
            $table->string('buyerBranchCode')->nullable();
            $table->text('buyerBranchName')->nullable();

            $table->text('agentFio')->nullable();
            $table->text('agentJobTittle')->nullable();
            $table->string('agentPassportNumber')->nullable();
            $table->text('agentPassportIssuedBy')->nullable();
            $table->text('agentPassportDateOfIssue')->nullable();
            $table->integer('agentTin')->nullable();
            $table->string('agentEmpowermentId', 30)->nullable();

            $table->integer('sellerTin');
            $table->integer('sellerName');
            $table->integer('sellerAccount')->nullable();
            $table->integer('sellerBankId')->nullable();
            $table->text('sellerAddress')->nullable();
            $table->integer('sellerMobile')->nullable();
            $table->integer('sellerWorkPhone')->nullable();
            $table->integer('sellerOked')->nullable();
            $table->integer('sellerRegion')->nullable();
            $table->integer('sellerDistrictId')->nullable();
            $table->string('sellerDirector', 1000)->nullable();
            $table->text('sellerAccountant')->nullable();
            $table->string('sellerVatRegCode')->nullable();
            $table->string('sellerBranchCode')->nullable();
            $table->text('sellerBranchName')->nullable();

            $table->string('contractNo');
            $table->dateTime('contractDate');

            $table->text('note')->nullable();
            $table->string('currentStateId')->default(1);


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
        Schema::dropIfExists('empowerments');
    }
}
