<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id('CoursID'); // Clé primaire
            $table->integer('NombreHeuresGlobal');
            $table->unsignedBigInteger('SemestreID');
            $table->unsignedBigInteger('ProfesseurID');
            $table->unsignedBigInteger('ModuleID');
            $table->unsignedBigInteger('ClasseID');
            $table->integer('QuotaHoraire');
            $table->timestamps();

            $table->foreign('SemestreID')->references('SemestreID')->on('semestre');
            $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeur');
            $table->foreign('ModuleID')->references('ModuleID')->on('module');
            $table->foreign('ClasseID')->references('ClasseID')->on('classe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cours');
    }
}
