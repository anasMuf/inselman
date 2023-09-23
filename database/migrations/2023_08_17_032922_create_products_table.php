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
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock');
            $table->string('sku')->unique();
            $table->foreignId('product_category_id')->constrained('product_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
