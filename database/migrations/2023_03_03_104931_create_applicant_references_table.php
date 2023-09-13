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
        Schema::create('applicant_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reference_type_id');
            $table->unsignedBigInteger('user_information_id');
            $table->string('file');
            $table->string('status')->default('PROSES');
            $table->boolean('is_upload');
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
        Schema::dropIfExists('applicant_references');
    }
};
