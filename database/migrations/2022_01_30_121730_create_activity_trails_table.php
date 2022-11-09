<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wagonjwa_id')->nullable()->references('id')->on('wagonjwas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->string('lab_no')->nullable();
            $table->string('event')->nullable();
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
        Schema::dropIfExists('activity_trails');
    }
}
