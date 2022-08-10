<?php

    namespace App\Jobs;

    use App\Models\JobSchedule;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldBeUnique;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\Jobs\Job;
    use Illuminate\Queue\SerializesModels;


    class MailQueue implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private array $data;
        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct(array $data)
        {
            $this->data = $data;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            $job = new JobSchedule($this->data);
            $job->save();
        }
    }
