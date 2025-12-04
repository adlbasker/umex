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
        Schema::create('products_lang', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('slug');
            $table->string('title');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->decimal('price', 44, 2);
            $table->decimal('price_total', 44, 2);
            $table->text('description');
            $table->text('characteristic')->nullable();
            $table->char('lang', 4);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_lang');
    }
};
