<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('user_id');
            $table->integer('admin_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('birth_year');
            $table->string('club');
            $table->string('country');
            $table->string('category');
            $table->string('deadline');
            $table->boolean('rented');
            $table->string('si_chip');
            $table->string('stages');
            $table->boolean('payed');
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
        Schema::drop('event_registrations');
    }
}
