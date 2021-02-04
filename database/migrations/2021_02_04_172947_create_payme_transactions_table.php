<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payme_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('paycom_transaction_id');
            $table->string("paycom_tim")->default("0");
            $table->dateTime("paycom_time_datetime");
            $table->dateTime("perform_time")->nullable();
            $table->dateTime("cancel_time")->nullable();
            $table->decimal("amount");
            $table->integer("reason")->nullable();
            $table->integer("tin");
            $table->text("description")->nullable();

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
        Schema::dropIfExists('payme_transactions');
    }
}
