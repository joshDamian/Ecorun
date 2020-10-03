<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'products',
            function (Blueprint $table) {
                $table->id();
                $table->string('category_title')->nullable();
                $table->json('attributes');
                $table->string('name');
                $table->integer('price');
                $table->text('description');
                $table->foreign('category_title')
                    ->references('title')
                    ->on('categories');

                $table->foreignId('enterprise_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
}
