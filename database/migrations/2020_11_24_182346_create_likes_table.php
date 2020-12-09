<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up() {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Profile::class)
            ->index('profile_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('likeable_type');
            $table->integer('likeable_id');
            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down() {
        Schema::dropIfExists('likes');
    }
}