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
        Schema::create('interrogation_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_information_id');
            $table->string('building_condition');
            $table->json('street_name');
            $table->string('allocation');
            $table->text('note');
            $table->json('employee');
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
        Schema::dropIfExists('interrogation_reports');
    }
};
