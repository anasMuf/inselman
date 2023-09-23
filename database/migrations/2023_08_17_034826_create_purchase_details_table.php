<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_quantity');
            $table->decimal('purchase_price_per_unit', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->foreignId('purchase_id')->constrained('purchases')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')
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
        Schema::dropIfExists('purchase_details');
    }
}
