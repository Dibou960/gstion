<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnneeScolaireIdToClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classe', function (Blueprint $table) {
            $table->unsignedBigInteger('AnnéeScolaire_ID');
            $table->foreign('AnnéeScolaireID')->references('AnnéeScolaireID')->on('anneescolaire');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classe', function (Blueprint $table) {
            $table->dropForeign(['AnnéeScolaireID']);
            $table->dropColumn('AnnéeScolaireID');
        });
    }
}
