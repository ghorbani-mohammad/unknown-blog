<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJUserViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('JUserView', function (Blueprint $table) {
            $table->integer('user_id');
            $table->text('VIEWSTATE');
            $table->text('VIEWSTATEGENERATOR');
            $table->text('EVENTVALIDATION');
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
        Schema::dropIfExists('JUserView');
    }
}
