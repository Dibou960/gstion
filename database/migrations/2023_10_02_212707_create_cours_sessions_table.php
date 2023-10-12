<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('CoursID');
            $table->unsignedBigInteger('SessionCoursID');
            $table->timestamps();

            $table->primary(['CoursID', 'SessionCoursID']);
            $table->foreign('CoursID')->references('CoursID')->on('cours');
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
        Schema::dropIfExists('cours_sessions');
    }
}
