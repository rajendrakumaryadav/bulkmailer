<?php

    namespace App\Console\Commands;

    use App\Models\Drafts;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\DB;
    use function MongoDB\BSON\toJSON;

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
           $drafts_with_active_schedule = DB::table('drafts')
               ->where('is_scheduled', "=",true)
               ->where('is_schedule_active', '=', true)
               ->get();
              foreach ($drafts_with_active_schedule as $draft) {
                    if ($draft->is_scheduled && $draft->is_schedule_active) {
                        if ($draft->scheduled_at <= now()) {
                            Drafts::find($draft->id)->update([
                               'is_schedule_active' => false
                            ]);
                            logger("Draft with details " . $drafts_with_active_schedule . " is being published");
                        }
                    }
              }
        }
    }
