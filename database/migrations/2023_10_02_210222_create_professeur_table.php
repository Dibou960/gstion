<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesseurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeur', function (Blueprint $table) {
            $table->id('ProfesseurID'); // Clé primaire
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Specialite');
            $table->string('Grade');
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
        Schema::dropIfExists('professeur');
    }
}
