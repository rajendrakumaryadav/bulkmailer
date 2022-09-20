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
        Schema::table('drafts', function (Blueprint $table) {
//            $table->boolean('is_scheduled')->default(false);
//            $table->foreignId('schedule_id')->nullable()
//                ->constrained('schedules')->cascadeOnDelete();
            $table->dateTime('scheduled_at')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drafts', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
            $table->dropColumn('is_active');
        });
    }
};
