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
        Schema::table('job_lists', function (Blueprint $table) {

            $table->integer('draft_id')->foreign('draft_id')->references('id')->on('drafts')->onDelete('cascade')
            ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_lists', function (Blueprint $table) {
            $table->dropForeign(['job_lists_draft_id_foreign']);
            $table->dropIndex('lists_user_id_index');
            $table->dropColumn('draft_id');
        });
    }
};
