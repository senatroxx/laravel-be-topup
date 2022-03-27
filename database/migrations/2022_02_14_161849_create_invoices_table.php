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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id');
            $table->string('invoice_id');
            $table->text('invoice_url');
            $table->string('status', 64);
            $table->text('payment_method')->nullable();
            $table->integer('amount');
            $table->foreignId('balance_history_id')->constrained()->cascadeOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expiry_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
