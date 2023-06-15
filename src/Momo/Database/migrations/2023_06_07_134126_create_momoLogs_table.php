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
            $table->text('extraData')->nullable()->comment('extraData');
            $table->integer('amount')->nullable()->comment('Tiền thanh toán');
            $table->string('transId')->nullable()->comment('Thông tin chuyển đổi');
            $table->string('payType')->nullable()->comment('Loại lương');
            $table->string('resultCode')->nullable()->comment('Mã kết quả');
            $table->string('refundTrans')->nullable()->comment('hoàn trả');
            $table->string('message')->nullable()->comment('Tin nhắn kết quả');
            $table->string('responseTime')->nullable()->comment('Kiểu đơn hàng');
            $table->string('lastUpdated')->nullable()->comment('Thời gian đáp ứng');
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
