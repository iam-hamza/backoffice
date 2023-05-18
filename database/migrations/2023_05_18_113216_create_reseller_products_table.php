<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_products', function (Blueprint $table) {
            $table->id();
            $table->string('categories')->nullable();
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->text('displayImages')->nullable();
            $table->boolean('hasStock')->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('name')->nullable();
            $table->text('sizes')->nullable();
            $table->string('sku')->nullable();
            $table->string('slug')->nullable();
            $table->string('currency')->nullable();
            $table->integer('status')->default(0);
            $table->string('website')->nullable();
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
        Schema::dropIfExists('reseller_products');
    }
}
