<?php

    namespace App\Jobs;

    use Exception;
    use GuzzleHttp\Client;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Log;
    use SendinBlue\Client\Api\TransactionalEmailsApi;
    use SendinBlue\Client\Configuration;
    use SendinBlue\Client\Model\SendSmtpEmail;

    class SendEmail implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private array $message;
        private string $subject;
        private string $reply_to;
        private string $from;
        private string $sender_name;
        private string $job_id;
        private $config, $messageId;

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
            $this->job_id = "JOB_".uniqid();
            $this->config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('SENDINBLUE_API_KEY'));
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            $apiInstance = new TransactionalEmailsApi(new Client(), $this->config);
            for ($i = 0; $i < count($this->message); $i++) {

                $sendSmtpEmail = new SendSmtpEmail();


                $sendSmtpEmail['subject'] = $this->subject;
                $sendSmtpEmail['htmlContent'] = $this->message[$i]['message'] ?? "";
                $sendSmtpEmail['sender'] = array('name' => $this->sender_name ?? "", 'email' => $this->from);
                $sendSmtpEmail['to'] = array(
                    array('email' => $this->message[$i]['email'], 'name' => 'User'),
                );
                if (isset($this->reply_to)) {
                    $sendSmtpEmail['replyTo'] = array('email' => $this->reply_to ?? "", 'name' => 'User');
                }
//                $sendSmtpEmail['headers'] = array('Some-Custom-Name' => 'unique-id-1234');
//                $sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');

                try {
                    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                    $this->messageId = $result['messageId'];
                    Log::info("Message sent successfully with message id: ".$this->messageId);
                } catch (Exception $exception) {
                    Log::error("========================  ERROR START ===============");
                    Log::error("Error while sending email to ".$this->message[$i]['email']." with message ".$this->message[$i]['message']);
                    Log::error("-------------------------------- ERR MESSAGE START --------------------");
                    Log::error($exception->getMessage());
                    Log::error("-------------------------------- ERR MESSAGE END --------------------");
                    Log::error("======================== ERROR  END ===============");
                }
//                Mail::html($this->message[$i]['message'], function ($message) use ($i) {
//                    Log::channel('Mailer')->info("Date: ".Carbon::now()." From: ".$this->from." To: ".$this->message[$i]['email']." Subject: ".$this->subject);
//                    $message->to($this->message[$i]['email'])->subject($this->subject)->from("admin@vvm.org.in",
//                        $this->sender_name)->replyTo($this->reply_to);
//                });

                $data = array(
                    "job_name" => $this->job_id, "messageId" => $this->messageId,
                    "recipient" => $this->message[$i]['email'], "subject" => $this->subject,
                    "message" => $this->message[$i]['message'], "reply_to" => $this->reply_to, "from" => $this->from,
                    "sender_name" => $this->sender_name,
                );
                MailQueue::dispatch($data);
            }
        }
    }
