<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender')->constrained('employees');
            $table->foreignId('receiver')->constrained('employees');
            $table->string('msg');
            $table->dateTime('time');
            $table->string('status')->default('send');
            $table->string('msg_type')->default('txt');
            $table->string('msg_esten')->default('txt');
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
        Schema::dropIfExists('messages');
    }
}
