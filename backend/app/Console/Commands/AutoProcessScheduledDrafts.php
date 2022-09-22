<?php

    namespace App\Console\Commands;

    use Carbon\Carbon;
    use Exception;
    use Illuminate\Console\Command;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;


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
         * @return void
         */
        public function handle()
        {
            $drafts_with_active_schedule = DB::table('drafts')
                ->where('is_scheduled', "=", true)
                ->where('is_schedule_active', '=', true)
                ->get();
            Log::info("Drafts Scheduled: " . json_encode($drafts_with_active_schedule));
            $date_now = date_format(now(), "Y-m-d H:i");
            foreach ($drafts_with_active_schedule as $draft) {
                if ($draft->is_scheduled && $draft->is_schedule_active) {
                    $record_date = date_format(new Carbon($draft->scheduled_at), 'Y-m-d H:i');
                    if (Carbon::parse($date_now)->eq(Carbon::parse($record_date))) {
                        $request = Request::create('/api/sendmail', 'POST', [
                            'file_path' => url('/')."/".$draft->file_path,
                            'template' => $draft->template,
                            'reply_to' => $draft->reply_to,
                            'subject' => $draft->subject,
                            'from' => $draft->from,
                            'sender_name' => $draft->sender_name,
                            'draft_id' => $draft->id,
                        ]);
                        try {
                            $response = app()->handle($request);
                            if ($response->isOk()) {
                                DB::table('drafts')->where('id', $draft->id)
                                    ->update(['is_schedule_active' => false]);
                                logger("Success: ".__FILE__." - ".__LINE__." - ".$response->getStatusCode());
                                Log::info("Success: ".__FILE__." - ".__LINE__." - ".$response->getContent());
                            } else {
                                logger("Failed: ".__FILE__." - ".__LINE__." - ".$response->getStatusCode());
                            }
                        } catch (Exception $e) {
                            Log::error("Exception : ".__FILE__." ".__LINE__." ".__METHOD__." ".$e->getMessage());
                        }
                    }
                }
            }
        }
    }
