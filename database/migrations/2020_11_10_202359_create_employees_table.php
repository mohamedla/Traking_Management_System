<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('pass');
            $table->string('img')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('address');
            $table->integer('phone')->unique();
            $table->foreignId('depart')->constrained('departs');
            $table->string('status')->default('left');
            $table->tinyInteger('groubID')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
