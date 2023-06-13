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
        Schema::create('momoLogs', function (Blueprint $table) {
            $table->id();
            $table->string('userId')->nullable()->comment('Dối tác');
            $table->string('email')->nullable()->comment('Email đối tác');
            $table->string('userName')->nullable()->comment('Ten đối tác');
            $table->string('partnerCode')->nullable()->comment('Mã đối tác');
            $table->string('orderId')->nullable()->comment('Mã đặt hàng');
            $table->string('requestId')->nullable()->comment('mã yêu cầu');
            $table->integer('amount')->nullable()->comment('Tiền thanh toán');
            $table->string('orderInfo')->nullable()->comment('Thông tin đặt hàng');
            $table->string('orderType')->nullable()->comment('Kiểu đơn hàng');
            $table->string('transId')->nullable()->comment('Thông tin chuyển đổi');
            $table->string('resultCode')->nullable()->comment('Mã kết quả');
            $table->string('message')->nullable()->comment('Tin nhắn kết quả');
            $table->string('payType')->nullable()->comment('Loại lương');
            $table->string('responseTime')->nullable()->comment('Thời gian đáp ứng');
            $table->string('signature')->nullable()->comment('Chữ ký');
            $table->string('extraData')->nullable()->comment('extraData');
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
        Schema::dropIfExists('momoLogs');
    }
};
