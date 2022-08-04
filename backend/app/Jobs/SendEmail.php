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

        private array $message;
        private string $subject;
        private string $reply_to;
        private string $from;
        private string $sender_name;

        /**
         * Create a new job instance.
         * @param  array  $message  this is array of email address and messages
         * @param  string  $subject  common subject for all emails
         * @param  string  $reply_to  reply to email address
         * @param  string  $from  from email address
         * @return void
         *
         */
        public function __construct(array $message, string $subject, string $reply_to, string $from, $sender_name)
        {
            $this->message = $message;
            $this->subject = $subject;
            $this->reply_to = $reply_to ?? "admin@vvm.org.in";
            $this->from = $from ?? "admin@vvm.org.in";
            $this->sender_name = $sender_name ?? "VVM Official Handle";
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
                    $message->to($this->message[$i]['email'])->subject($this->subject)->from($this->from,
                        $this->sender_name)->replyTo($this->reply_to);
                });


            }
        }
    }
