<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_transaction', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('Invoice');
            $table->string('user_id');
            $table->double('total');
            $table->string('status_order');
            $table->timestamp('payment_at');
            $table->string('photo_receipt');
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
        Schema::dropIfExists('m_transaction');
    }
}
