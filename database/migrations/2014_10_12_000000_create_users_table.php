<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();

            $table->string('nick_name')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            
            $table->string('locality')->nullable();
            $table->string('administrative_area_level_1')->nullable();
            $table->string('administrative_area_level_2')->nullable();
            $table->string('country')->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
