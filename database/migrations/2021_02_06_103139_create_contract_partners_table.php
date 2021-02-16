<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_partners', function (Blueprint $table) {
            $table->id();
            $table->string("contract_id", 30)->index();
            $table->string('account', 1000)->nullable();
            $table->string('name', 1000);
            $table->integer("tin");
            $table->text('address')->nullable();
            $table->text('mobilePhone')->nullable();
            $table->text('workPhone')->nullable();
            $table->text('oked')->nullable();
            $table->text('director')->nullable();
            $table->integer('directorTin')->nullable();
            $table->text('branchName')->nullable();
            $table->text('fizFio')->nullable();
            $table->integer('fizTin')->nullable();
            $table->string('branchCode', 15)->nullable();

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
        Schema::dropIfExists('contract_partners');
    }
}
