<?php

    namespace App\Jobs;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Mail;

    class SendEmail implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//        private $email;
        private array $message;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct(array $message)
        {
            $this->message = $message;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            for ($i = 0; $i < count($this->message); $i++) {
                Mail::html($this->message[$i]['message'], function ($message) use ($i) {
                    logger($this->message[$i]['message'].'Sending email to '.$this->message[$i]['email']." at ".date('Y-m-d H:i:s'));
                    $message->to($this->message[$i]['email']);
                });


            }
        }
    }
