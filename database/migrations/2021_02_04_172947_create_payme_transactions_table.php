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

            $table->string('transaction_id');
            $table->string("perform_time")->nullable();
            $table->string('transaction_create_time')->nullable();
            $table->string("create_time");
            $table->string("cancel_time")->nullable();
            $table->decimal("amount");
            $table->integer("reason")->nullable();
            $table->integer("tin");
            $table->text("description")->nullable();
            $table->integer('state')->default(1);

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
