<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence', function (Blueprint $table) {
            $table->id('AbsenceID'); // Clé primaire
            $table->date('Date');
            $table->string('Motif');
            $table->unsignedBigInteger('EtudiantID');
            $table->unsignedBigInteger('SessionCoursID');
            $table->timestamps();

            $table->foreign('EtudiantID')->references('EtudiantID')->on('etudiant');
            $table->foreign('SessionCoursID')->references('SessionCoursID')->on('sessioncours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absence');
    }
}
