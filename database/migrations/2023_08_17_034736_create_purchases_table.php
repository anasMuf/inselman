<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_reff');
            $table->date('purchase_date');
            $table->foreignId('warehouse_id')->constrained('warehouses')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->decimal('total_payment', 10, 2);
            $table->string('payment');
            $table->string('status');

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
        Schema::dropIfExists('purchases');
    }
}
