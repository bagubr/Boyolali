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
            $table->string('kbg')->nullable();
            $table->string('kdb')->nullable();
            $table->string('klb')->nullable();
            $table->string('kdh')->nullable();
            $table->string('psu')->nullable();
            $table->string('jaringan_utilitas')->nullable();
            $table->string('prasarana_jalan')->nullable();
            $table->string('sungai_bertanggul')->nullable();
            $table->string('sungai_tidak_bertanggul')->nullable();
            $table->string('mata_air')->nullable();
            $table->string('waduk')->nullable();
            $table->string('tol')->nullable();
            $table->string('ktb')->nullable();
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
