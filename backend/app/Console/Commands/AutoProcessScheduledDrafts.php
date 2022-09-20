<?php

    namespace App\Console\Commands;

    use App\Models\Drafts;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\DB;

    class AutoProcessScheduledDrafts extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'auto:process-scheduled-drafts';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'This command will automatically process scheduled drafts. \
    Which are scheduled to be published at a specific time.';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle()
        {
           logger('AutoProcessScheduledDrafts command is running');
        }
    }
