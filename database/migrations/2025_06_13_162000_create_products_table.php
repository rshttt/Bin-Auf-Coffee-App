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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('image_path')->unique()->nullable();

            $table->string('name')->unique();

            $table->string('description');

            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->string('code', 5)->primary();

            $table->unsignedInteger('delivery_cost')->default(0);

            $table->unsignedInteger('total_cost')->default(0);

            $table->enum('status', ['ready', 'received', 'paid', 'served', 'delivered', 'done'])->default('ready');
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('image_path')->unique()->nullable();

            $table->string('name')->unique();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->unsignedInteger('stock');

            $table->unsignedInteger('price');

            $table->string('description');

            $table->timestamps();
        });

        Schema::create('invoice_products', function (Blueprint $table) {
            $table->string('invoice_code')->index();
            $table->foreign('invoice_code')->references('code')->on('invoices')->onDelete('cascade');

            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->unsignedInteger('quantity');

            $table->unsignedInteger('cost')->default(0);

            $table->timestamps();

            $table->primary(['invoice_code', 'product_id']);
        });

        Schema::create('product_favorites', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();

            $table->primary(['user_id', 'product_id']);
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('rate');

            $table->string('review');

            $table->timestamps();

            $table->primary(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('product_favorites');
        Schema::dropIfExists('invoice_products');
        Schema::dropIfExists('products');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('categories');
    }
};
