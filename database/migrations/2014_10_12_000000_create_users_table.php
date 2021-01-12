<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fio', 500);
            $table->dateTime('dateOfBirth')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('phone')->nullable();
            $table->string('lang')->default('uz');
            $table->integer('tin')->index();
            $table->integer('roleId')->default(1);
            $table->string('auth_key', 1000);
            $table->integer('status')->default(1);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 1000)->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
