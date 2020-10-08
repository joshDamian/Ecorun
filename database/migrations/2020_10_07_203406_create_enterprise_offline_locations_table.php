<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseOfflineLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_offline_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')
                ->index()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('address_line');
            $table->string('state');
            $table->string('city');
            $table->string('label');
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
        Schema::dropIfExists('enterprise_offline_locations');
    }
}
