<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gsbs', function (Blueprint $table) {
            $table->id();
            $table->string('jap');
            $table->string('jkp');
            $table->string('jks');
            $table->string('jlp');
            $table->string('jls');
            $table->string('jling');
            $table->unsignedBigInteger('krk_id');
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
        Schema::dropIfExists('gsbs');
    }
};
