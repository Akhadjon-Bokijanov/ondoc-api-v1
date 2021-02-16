<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->text("body_uz")->nullable();
            $table->text("body_ru")->nullable();
            $table->text("body_en")->nullable();
            $table->text("title_uz")->nullable();
            $table->text("title_ru")->nullable();
            $table->text("title_en")->nullable();
            $table->boolean("isActive")->default(true);
            $table->integer("importance")->default(1);

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
        Schema::dropIfExists('notifications');
    }
}
