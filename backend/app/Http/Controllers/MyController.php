<?php

    namespace App\Http\Controllers;

    use App\Jobs\SendEmail;
    use Exception;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Response;
    use Illuminate\Support\Facades\Validator;
    use League\Csv\Reader;
    use Psy\Readline\Hoa\FileException;

    class MyController extends Controller
    {
        private $filepath;

        public function __construct()
        {
            $this->filepath = 'storage/data.csv';
        }

        public function view_form()
        {
            return view('form');
        }


        public function index()
        {
            $validated = Validator::make(Request::all(), [
                'file' => 'required|file|mimes:csv,txt',
//                'files' => 'file',
                'subject' => 'required|string',
                'template' => 'required|string',
                'reply_to' => 'email',
                'from' => 'required|email',
                'sender_name' => 'required|string',
            ]);

            if (count($validated->errors()) > 0) {
                return $validated->errors();
            }


            $file = Request::file('file');
//            $files = Request::file('files');
            $template = Request::post('template');
            $reply_to = Request::post('reply_to') ?? "demo@demo.com";
            $subject = Request::post('subject') ?? "Demo";
            $from = Request::post('from') ?? "admin@vvm.org.in";
            $sender_name = Request::post('sender_name') ?? "VVM Official Handle";

            try {
                $this->filepath = $file->move('storage/data/', $this->get_unique_filename($file));
            } catch (Exception $e) {
                return Response::json(['error' => $e->getMessage()]);
            }

            $csv = Reader::createFromPath($this->filepath);
            $records = $csv->getRecords();
            $data = [];
            foreach ($records as $record) {
                $data[] = $record;
            }
            $messages = array();

            for ($i = 0; $i < count($data); $i++) {
                $messages[] = array(
                    "message" => $this->format($template, $data[$i]),
                    "email" => $data[$i][count($data[0]) - 1],
                );
            }
            // dispatching the job to the queue
            SendEmail::dispatch($messages, $subject, $reply_to, $from, $sender_name);

            return Response::json(
                [
                    'success' => 'Email sent successfully',
                    'status_code' => 200
                ]
            );
        }

        /**
         * This method accepts file object and generate a unique filename.
         * It consists of uniquedata with timestamp and original filename.
         * @param $file
         * @return string
         */
        private function get_unique_filename($file): string
        {
            $original_name = $file->getClientOriginalName();

            return uniqid()."_".date("Y-m-d-H-i-s", time())."_".$original_name;
        }

        /**
         * This method acts as a template engine.
         * It accepts a template and a data array and replaces the placeholders with values.
         * It works exactly like the Python string.format() method.
         * @param $msg
         * @param $vars
         * @return array|string
         * @see https://www.php.net/manual/en/function.sprintf.php
         * @see https://www.php.net/manual/en/function.str-replace.php
         * @see https://docs.python.org/3/library/stdtypes.html?highlight=str%20format#str.format
         */
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
