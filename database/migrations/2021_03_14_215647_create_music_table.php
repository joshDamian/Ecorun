<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type')->nullable();
            $table->integer('attachable_id')->nullable();
            $table->string('artiste');
            $table->foreignId('eco_artist')->nullable();
            $table->string('cover_art')->nullable();
            $table->string('title');
            $table->json('associated_acts')->nullable();
            $table->string('lyrics')->nullable();
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
        Schema::dropIfExists('music');
    }
}
