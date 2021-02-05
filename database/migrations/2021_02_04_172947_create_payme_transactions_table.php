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
            $table->integer("perform_time")->nullable();
            $table->integer("create_time");
            $table->integer("cancel_time")->nullable();
            $table->decimal("amount");
            $table->integer("reason")->nullable();
            $table->integer("tin");
            $table->text("description")->nullable();
            $table->integer('state')->default(1);
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
