<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'profiles',
            function (Blueprint $table) {
                $table->id();
                $table->string('profileable_type');
                $table->integer('profileable_id');
                $table->string('name')->nullable();
                $table->string('tag')->unique()->nullable();
                $table->uuid('auto_tag')->unique();
                $table->text('profile_photo_path')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
