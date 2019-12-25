<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoleGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hole_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id')->unsigned()->index();
            $table->string('group_name')->nullable()->default('NA');
            $table->string('teebox');
            $table->string('number_of_holes');
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
        Schema::dropIfExists('hole_groups');
    }
}
