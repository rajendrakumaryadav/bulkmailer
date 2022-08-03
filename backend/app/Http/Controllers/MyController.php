<?php

    namespace App\Http\Controllers;

    use App\Jobs\SendEmail;
    use Illuminate\Support\Facades\Request;
    use League\Csv\Reader;

    class MyController extends Controller
    {
        private $filepath;

        public function __construct()
        {
            $this->filepath = 'storage/data.csv';
        }

        public function index()
        {
            $message = <<<EOF
                Dear <strong>{#0#}</strong>,<br >
                Welcome to <em>{#1#}</em> at address <em>{#2#}</em>.<br > Thanks for your participation in the <em>{#1#}</em>.

                <em>Thanks & Regards,</em><br>
                <strong><em>{#0#}</em></strong>
            EOF;

            $csv = Reader::createFromPath($this->filepath);
            $records = $csv->getRecords();
            $data = [];
            foreach ($records as $record) {
                $data[] = $record;
            }
            $messages = array();
            for ($i = 0; $i < count($data); $i++) {
                $messages[] = array(
                    "message" => $this->format($message, $data[$i]),
                    "email" => $data[$i][count($data[0]) - 1],
                );
            }
            SendEmail::dispatch($messages);
            return $messages;
        }


        private function format($msg, $vars): array|string
        {
            $vars = (array) $vars;

            $msg = preg_replace_callback('#{}#', function () {
                static $i = 0;

                return '{#'.($i++).'#}';
            }, $msg);

            return str_replace(array_map(function ($k) {
                return '{#'.$k.'#}';
            }, array_keys($vars)), array_values($vars), $msg);
        }

    }
