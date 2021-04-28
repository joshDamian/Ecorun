<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Connect\Profile\Profile::class)
                ->index('profile_id')
                ->onUpdate('cascade')
                ->onDelete('cascade')->nullable();

            $table->string('feedbackable_type')->nullable();
            $table->integer('feedbackable_id')->nullable();
            $table->string('title')->nullable();
            $table->text('content');
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
        Schema::dropIfExists('feedback');
    }
}
