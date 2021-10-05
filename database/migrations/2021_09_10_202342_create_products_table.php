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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translation_lang');
            $table->integer('translation_of');
            $table->string('name')->unique();
            $table->string('description')->unique();
            $table->string('slug')->unique();
            $table->decimal('price', 18, 4)->unsigned();
            $table->boolean('active');
//            $table->integer('sub_category_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
