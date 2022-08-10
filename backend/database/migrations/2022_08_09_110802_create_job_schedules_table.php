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
        Schema::create('job_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('job_name');
            $table->string('recipient');
            $table->string('messageId')->unique();
            $table->string('subject');
            $table->string('message');
            $table->string('from');
            $table->string('reply_to')->nullable();
            $table->string('sender_name')->nullable();


            $table->string("webhook_id")->nullable();
            $table->string('webhook_server_timestamp')->nullable();
            $table->string('ts')->nullable();
            $table->string('ts_event')->nullable();
            $table->string('event')->nullable();
            $table->string('date')->nullable();
            $table->string('sending_ip')->nullable();


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
        Schema::dropIfExists('job_schedules');
    }
};
