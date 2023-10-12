<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessioncoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessioncours', function (Blueprint $table) {
            $table->id('SessionCoursID'); // Clé primaire
            $table->date('Date');
            $table->time('HeureDebut');
            $table->time('HeureFin');
            $table->integer('NombreHeures');
            $table->unsignedBigInteger('CoursID');
            $table->unsignedBigInteger('SalleID');
            $table->timestamps();

            $table->foreign('CoursID')->references('CoursID')->on('cours');
            $table->foreign('SalleID')->references('SalleID')->on('salle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessioncours');
    }
}
