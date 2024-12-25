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
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('regular_price', 8, 2)->nullable();
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->string('sku')->nullable();
            $table->enum('stock_status', ['instock', 'outofstock'])->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedBigInteger('quantity')->default(10)->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();

            $table->foreign('category_id')->references('id')->on('categories') 
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('brand_id')->references('id')->on('brands')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
