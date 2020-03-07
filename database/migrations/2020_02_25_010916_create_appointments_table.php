<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // para almanecenar las Citas
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('type');
           
            // fk specialty, doctor , patient
            //doctor
            $table->unsignedInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');

            // specialty
            $table->unsignedInteger('specialty_id');
            $table->foreign('specialty_id')->references('id')->on('specialties');

            //patients
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

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
        Schema::dropIfExists('appointments');
    }
}
