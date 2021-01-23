<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Http\Controllers\FacturaController;

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
            $table->string('facturaProductId')->index();
            $table->text('notes')->nullable();
            $table->string('facturaNo', 1000);
            $table->dateTime('facturaDate');
            $table->integer('version')->default(1);
            $table->integer('currentStateid')->default(FacturaController::STATE_SAVED);
            $table->string('contractNo', 1000);
            $table->dateTime('contractDate');

            //THIS IS NEEDED WHEN SINGLE_SIDED_FACTURA_TYPE = 3
            $table->string('foreignCompanyName')->nullable();
            $table->string('foreignCompanyCountryId')->nullable();
            $table->text('foreignCompanyAccount')->nullable();
            $table->text('foreignCompanyAddress')->nullable();

            //FACTURA SINGLE SIDED TYPES
            //1. На физ. лицо,
            //2. На экспорт,
            //3. На импорт,
            //4. Реализация, связанная с
            //гос. секретом,
            //5. Финансовые услуги
            $table->integer('singleSidedType')->nullable();

            //THIS OLD FACTURA IS NEED WHEN FACTURA TYPE = 1 OR 4
            $table->string('oldFacturaId')->nullable();
            $table->string('oldFacturaNo')->nullable();
            $table->dateTime('oldFacturaDate')->nullable();

            //FACTURA TYPES
            //0. Стандартный,
            //1. Дополнительный,
            //2. Возмещение расходов,
            //3. Без оплаты,
            //4. Исправленный.
            $table->integer('facturaType');

            $table->string('lotId')->nullable();
            $table->integer('inCallBack')->default(0);

            $table->boolean('hasMarking')->default(false);
            $table->boolean('hasMedical')->default(false);

            //EMPOWERMENT IS NOT REQUIRED
            //
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
            $table->string('sellerName', 1000);
            $table->text('sellerAddress')->nullable();
            $table->text('sellerMobilePhone')->nullable();
            $table->text('sellerWorkPhone')->nullable();
            $table->text('sellerOked')->nullable();
            $table->string('sellerDistrictId', 20)->nullable();
            $table->text('sellerDirector')->nullable();
            $table->text('sellerAccountant')->nullable();
            $table->text('sellerVatRegCode')->nullable();
            $table->text('sellerBranchName')->nullable();
            $table->text("sellerMfo")->nullable();
            $table->string('sellerBranchCode', 15)->nullable();

            $table->string('buyerAccount', 1000)->nullable();
            $table->string('buyerBankId', 10)->nullable();
            $table->string('buyerName', 1000)->nullable();
            $table->text('buyerAddress')->nullable();
            $table->text('buyerMobilePhone')->nullable();
            $table->text('buyerWorkPhone')->nullable();
            $table->text('buyerOked')->nullable();
            $table->string('buyerDistrictId', 20)->nullable();
            $table->text('buyerDirector')->nullable();
            $table->text('buyerAccountant')->nullable();
            $table->text('buyerMfo')->nullable();
            $table->text('buyerVatRegCode')->nullable();
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
