<?php

    namespace App\Http\Controllers;

    use App\Jobs\SendEmail;
    use App\Models\Drafts;
    use App\Models\JobLists;
    use Exception;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Response;
    use Illuminate\Support\Facades\Validator;
    use League\Csv\Reader;

    class MyController extends Controller
    {
        private string|null $filepath = null;

        public function __construct()
        {
        }

        public function view_form()
        {
            return view('form');
        }


        public function index()
        {
            $validated = Validator::make(Request::all(), [
                'file' => 'required_without:file_path|file|mimes:csv,txt',
                'file_path' => 'required_without:file|url|active_url', 'subject' => 'required|string',
                'template' => 'required|string', 'reply_to' => 'email', 'from' => 'required|email',
                'sender_name' => 'required|string', 'draft_id' => 'integer',    // optional direct messages can be sent.
            ]);

            if ($validated->fails()) {
                return Response::json([
                    "status_code" => 400, "message" => $validated->errors(),
                    "created_at" => now(),
                ], 400);
            }
            $file = Request::file('file') ?? null;
            $file_url = Request::post('file_path') ?? null;
            $template = Request::post('template');
            $reply_to = Request::post('reply_to') ?? Request::post('from');
            $subject = Request::post('subject') ?? 'No Subject';
            $from = Request::post('from');
            $sender_name = Request::post('sender_name') ?? "Official Email";
            $draft_id = Request::post('draft_id') ?? null;
            try {
                // file path have url them return true
                if ($file_url != null) {
                    $draft_file_path = $this->extract_file_path_from_url($file_url);
                    Log::info( __FILE__. " ". __LINE__ ." ". __METHOD__ ." ".public_path($draft_file_path));
                    Log::info(__FILE__. " ". __LINE__ ." ". __METHOD__ ." ".file_exists(public_path($draft_file_path)));
                    if (file_exists(public_path($draft_file_path))) {
                        $this->filepath = public_path($draft_file_path);
                    }
                } else {
                    $this->filepath = $file->move('storage/data/', $this->get_unique_filename($file));
                }
            } catch (Exception $e) {
                return Response::json(['error' => "Error to Read file."]);
            }
            Log::notice(__FILE__ . " " . __LINE__ . " " . __METHOD__ . " " . $this->filepath);
            if ($this->filepath == null) {
                return Response::json(['error' => "File not found."], 400);
            }
            try {
                $csv = Reader::createFromPath($this->filepath);
            } catch (Exception $e) {
                return Response::json([
                    'error' => 'File not found or file is not readable',
                ]);
            }
            $records = $csv->getRecords();
            $data = [];
            foreach ($records as $record) {
                $data[] = $record;
            }

            $messages = array();
            for ($i = 0; $i < count($data); $i++) {
                $messages[] = array(
                    "message" => $this->format($template, $data[$i]), "email" => $data[$i][count($data[0]) - 1],
                );
            }
            $job_id = "JOB_".uniqid();
            $data = array(
                "job_name" => $job_id, "subject" => $subject, "message" => $template, "reply_to" => $reply_to,
                "from" => $from, "sender_name" => $sender_name, "draft_id" => $draft_id,
            );
            $job_list_id = JobLists::create($data)->id;
            Drafts::where('id', $draft_id)->update(['status' => 1]);
            // dispatching the job to the queue
            SendEmail::dispatch($messages, $subject, $reply_to, $from, $sender_name, $job_list_id);
            Drafts::where('id', $draft_id)->update(['status' => 2]);

            return Response::json([
                'success' => 'Email sent successfully', 'status_code' => 200,
            ]);
        }

        /**
         * @param $url
         * @return string
         */
        public function extract_file_path_from_url($url): string
        {
            $url = explode(env('APP_URL').'/', $url);

            return $url[1];
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

            $msg = preg_replace_callback('#{ }#', function () {
                static $i = 0;

                return '{#'.($i++).'#}';
            }, $msg);

            return str_replace(array_map(function ($k) {
                return '{#'.$k.'#}';
            }, array_keys($vars)), array_values($vars), $msg);
        }
    }
