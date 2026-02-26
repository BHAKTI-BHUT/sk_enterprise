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
            $table->string('name')->index();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('gst_percentage', 5, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock_alert')->default(0);
            $table->string('image')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['status', 'brand_id', 'category_id']);
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
