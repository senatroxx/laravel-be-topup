<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name');
            $table->text('description');
            $table->string('seller_name');
            $table->string('sku_code');
            $table->integer('price');
            $table->integer('margin');
            $table->boolean('status');
            $table->boolean('seller_status');
            $table->boolean('unlimited_stock');
            $table->integer('stock');
            $table->boolean('multi');
            $table->time('start_cut_off');
            $table->time('end_cut_off');
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
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
};
