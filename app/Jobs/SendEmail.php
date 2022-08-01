<?php

    namespace App\Jobs;

    use Carbon\Carbon;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Mail;
    use function logger;

    class SendEmail implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private $data;
        private string $message;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($data, string $message)
        {
            $this->data = $data;
            $this->message = $message;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public
        function handle()
        {
            for ($i = 0; $i < count($this->data); $i++) {
                $email = $this->data[$i]['email'];
                $name = $this->data[$i]['name'];
                logger()->info('Message for '.$name.' ('.$email.')');
                usleep(100);
                $msg = sprintf($this->message, $name, Carbon::now()->toDateString());
                Mail::html($msg, function ($message) use ($name, $email) {
                    $message->to($email, $name)->subject('Test email');
                });
            }
        }
    }
