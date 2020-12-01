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
                $table->softDeletes();
                $table->string('category_title')
                    ->index()
                    ->nullable();
                $table->string('name');
                $table->integer('price');
                $table->text('description');
                $table->foreign('category_title')
                    ->references('title')
                    ->on('categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->boolean('is_published')->default(false);
                $table->foreignId('business_id')
                    ->nullable()
                    ->index()
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
