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
            $table->string('contractId', 30);
            $table->boolean('hasVat')->default(false);
            $table->string("contractName");
            $table->string("contractNo");
            $table->dateTime('contractDate');
            $table->dateTime('contractExpireDate')->nullable();
            $table->text('contractPlace')->nullable();
            $table->integer('status')->default(1);

            //SELLER AND BUYER || OWNER AND CLIENT
            $table->integer('clientTin')->index();
            $table->integer('buyerTin')->nullable()->index();

            $table->string('clientAccount', 1000)->nullable();
            $table->string('clientName', 1000);
            $table->text('clientAddress')->nullable();
            $table->text('clientMobilePhone')->nullable();
            $table->text('clientWorkPhone')->nullable();
            $table->text('clientOked')->nullable();
            $table->text('clientDirector')->nullable();
            $table->integer('clientDirectorTin')->nullable();
            $table->text('clientBranchName')->nullable();
            $table->string('clientBranchCode', 15)->nullable();

            $table->string('ownerAccount', 1000)->nullable();
            $table->string('ownerName', 1000);
            $table->text('ownerAddress')->nullable();
            $table->text('ownerMobilePhone')->nullable();
            $table->text('ownerWorkPhone')->nullable();
            $table->text('ownerOked')->nullable();
            $table->text('ownerDirector')->nullable();
            $table->integer('ownerDirectorTin')->nullable();




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
