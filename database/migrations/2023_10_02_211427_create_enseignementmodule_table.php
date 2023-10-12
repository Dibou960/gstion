<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignementmoduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignementmodule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ProfesseurID');
            $table->unsignedBigInteger('ModuleID');
            $table->timestamps();

            $table->primary(['ProfesseurID', 'ModuleID']);
            $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeur');
            $table->foreign('ModuleID')->references('ModuleID')->on('module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignementmodule');
    }
}
