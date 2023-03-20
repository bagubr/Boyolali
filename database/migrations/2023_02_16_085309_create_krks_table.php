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
        Schema::create('krks', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('kbg');
            $table->string('kdb');
            $table->string('klb');
            $table->string('kdh');
            $table->string('psu');
            $table->string('jaringan_utilitas');
            $table->string('prasarana_jalan');
            $table->string('sungai_bertanggul');
            $table->string('sungai_tidak_bertanggul');
            $table->string('mata_air');
            $table->string('waduk');
            $table->string('tol');
            $table->string('ktb');
            $table->unsignedBigInteger('building_function_id');
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
        Schema::dropIfExists('krks');
    }
};
