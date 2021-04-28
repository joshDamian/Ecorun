<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupConversationMemberPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_conversation_member', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Connect\Profile\Profile::class, 'member_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignIdFor(App\Models\Connect\Conversation\GroupConversation::class, 'group_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('group_conversation_member');
    }
}
