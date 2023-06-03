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
                $table->id();
                $table->unsignedBigInteger('reseller_product_id')->nullable();
                $table->string('name')->nullable();
                $table->string('description')->nullable();
                $table->string('brand')->nullable();
                $table->longText('sizes')->nullable();
                $table->string('sku')->nullable();
                $table->string('product_tag')->nullable();
                $table->string('slug')->nullable();
                $table->tinyInteger('hasStock')->default(0);
                $table->integer('profit_margin')->default(0);
                $table->float('price',12,2)->default(0);
                $table->integer('discount')->default(0);
                $table->float('discount_price',12,2)->default(0);
                $table->double('resaler_price')->default(0);
                $table->tinyInteger('stock')->default(0);
                $table->unsignedBigInteger('category_id')->nullable();

                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('reseller_product_id')->references('id')->on('reseller_products');
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
