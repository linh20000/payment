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
        Schema::create('vnpayLogs', function (Blueprint $table) {
            $table->id();
            $table->string('userName')->nullable();
            $table->string('email')->nullable();
            $table->integer('vnp_Amount')->nullable();
            $table->string('vnp_BankCode')->nullable();
            $table->string('vnp_BankTranNo')->nullable();
            $table->string('vnp_CardType')->nullable();
            $table->string('vnp_OrderInfo')->nullable();
            $table->string('vnp_PayDate')->nullable();
            $table->string('vnp_ResponseCode')->nullable();
            $table->string('vnp_TmnCode')->nullable();
            $table->string('vnp_TransactionNo')->nullable();
            $table->string('vnp_TransactionStatus')->nullable();
            $table->string('vnp_TxnRef')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('vnpayLogs');
    }
};
