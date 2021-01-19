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

            $table->string('facturaId')->unique()->index();
            $table->integer('version')->default(0);
            $table->boolean('singleSidedType')->default(false);
            $table->string('facturaNo', 1000);
            $table->dateTime('facturaDate');
            $table->string('oldFacturaId')->nullable();
            $table->string('oldFacturaNo')->nullable();
            $table->dateTime('oldFacturaDate')->nullable();
            $table->string('facturaProductId')->index();
            $table->text('notes')->nullable();
            $table->integer('facturaType');
            $table->integer('currentStateid')->default(\App\Http\Controllers\FacturaController::STATE_SAVED);
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
            $table->text('agentFio')->nullable();
            $table->integer('agentTin')->nullable();
            $table->string('agentFacturaId', 100)->nullable();

            $table->text('itemReleasedFio')->nullable();
            $table->string("itemReleaseTin")->nullable();
            $table->string('itemReleasePinf1')->nullable();

            $table->integer('sellerTin')->index();
            $table->integer('buyerTin')->nullable()->index();

            $table->string('sellerAccount', 1000)->nullable();
            $table->string('sellerBankId', 10)->nullable();
            $table->text('sellerName');
            $table->text('sellerAddress')->nullable();
            $table->string('sellerMobilePhone', 20)->nullable();
            $table->string('sellerWorkPhone', 20)->nullable();
            $table->string('sellerOked', 20)->nullable();
            $table->string('sellerDistrictId', 20)->nullable();
            $table->text('sellerDirector')->nullable();
            $table->text('sellerAccountant')->nullable();
            $table->string('sellerVatRegCode', 15)->nullable();
            $table->text('sellerBranchName')->nullable();
            $table->text("sellerMfo")->nullable();
            $table->string('sellerBranchCode', 15)->nullable();

            $table->string('buyerAccount', 1000)->nullable();
            $table->string('buyerBankId', 10)->nullable();
            $table->text('buyerName');
            $table->text('buyerAddress')->nullable();
            $table->string('buyerMobilePhone', 20)->nullable();
            $table->string('buyerWorkPhone', 20)->nullable();
            $table->string('buyerOked', 20)->nullable();
            $table->string('buyerDistrictId', 20)->nullable();
            $table->text('buyerDirector')->nullable();
            $table->text('buyerAccountant')->nullable();
            $table->text('buyerMfo')->nullable();
            $table->string('buyerVatRegCode', 15)->nullable();
            $table->text('buyerBranchName')->nullable();
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
