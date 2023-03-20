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
        Schema::create('user_informations', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registration')->unique();
            $table->string('nomor_krk')->unique();
            $table->string('nomor_hak')->unique();
            $table->string('submitter');
            $table->text('address');
            $table->text('location_address');
            $table->string('land_area');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('kbli_activity_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('sub_district_id');
            $table->unsignedBigInteger('land_status_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('user_informations');
    }
};
