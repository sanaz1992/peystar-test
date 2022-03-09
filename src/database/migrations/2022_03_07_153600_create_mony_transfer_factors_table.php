<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mony_transfer_factors', function (Blueprint $table) {
            $table->id();
            $table->string('track_id');
            $table->integer('amount');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('to_user_id');
            $table->string('destination_number');
            $table->integer('payment_number');
            $table->string('reason_description')->nullable();
            $table->integer('deposit');
            $table->unsignedBigInteger('from_user_id');
            $table->integer('inquiry_date')->nullable();
            $table->integer('inquiry_time')->nullable();
            $table->text('message')->nullable();
            $table->integer('ref_code')->nullable();
            $table->integer('source_number')->nullable();
            $table->enum('type', ['internal', 'paya'])->nullable();
            $table->enum('status', ['done', 'failed'])->nullable();
            $table->string('error')->nullable();
            $table->timestamps();

            $table->foreign('to_user_id')->references('id')->on('users');
            $table->foreign('from_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mony_transfer_factors');
    }
};
