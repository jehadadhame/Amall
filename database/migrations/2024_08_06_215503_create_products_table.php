<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->decimal('price', 10, 2);
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('website_id')->constrained('websites');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('cover');
            $table->boolean('is_new')->default(false);
            $table->boolean('is_special')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('images');
        Schema::dropIfExists('products');
    }
};
