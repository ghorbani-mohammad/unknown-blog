<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Juser', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('fname');
            $table->string('lname');
            $table->string('username');
            $table->string('jusername')->nullable();
            $table->string('jpassword')->nullable();
            $table->string('jflname')->nullable();
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
        //
        Schema::dropIfExists('Juser');
    }
}
