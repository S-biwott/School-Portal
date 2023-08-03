<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->string('regNo')->index();
            $table->foreign('regNo')->references('regNo')->on('students')->onDelete('cascade');
            $table->string('unit_id')->index();
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade');
            $table->string('cat1')->nullable();
            $table->string('cat2')->nullable();
            $table->string('exam')->nullable();
            $table->string('total_marks')->nullable();
            $table->string('grade')->nullable();
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
        Schema::dropIfExists('marks');
    }
}
