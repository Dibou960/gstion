<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptioncoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptioncours', function (Blueprint $table) {
            $table->unsignedBigInteger('EtudiantID');
            $table->unsignedBigInteger('CoursID');
            $table->timestamps();

            $table->primary(['EtudiantID', 'CoursID']);
            $table->foreign('EtudiantID')->references('EtudiantID')->on('etudiant');
            $table->foreign('CoursID')->references('CoursID')->on('cours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptioncours');
    }
}
