<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Connect\Profile\Profile::class, 'initiator_id');
            $table->foreignIdFor(\App\Models\Connect\Profile\Profile::class, 'joined_id');
            $table->uuid('secret_key')->unique();
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
        Schema::dropIfExists('direct_conversations');
    }
}
