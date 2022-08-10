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
            Schema::create('job_lists', function (Blueprint $table) {
                $table->id();
                $table->string('job_name')->unique();
                $table->string('subject');
                $table->string('from');
                $table->string('reply_to')->nullable();
                $table->string('sender_name');
                $table->string('message');
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
            Schema::dropIfExists('job_lists');
        }
    };
