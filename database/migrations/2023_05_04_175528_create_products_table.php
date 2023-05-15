<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('brand')->nullable();
            $table->longText('sizes')->nullable();
            $table->double('price')->default(0);
            $table->string('sku')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('hasStock')->default(0);
            $table->double('discount')->default(0);
            $table->double('resaler_price')->default(0);
            $table->tinyInteger('stock')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
};
