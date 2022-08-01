<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Response;
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
            $header_status = Request::post('is_header');
            $message = "Dear <strong>%s</strong>,<br> This is a <em>test email</em> sent at %s.<br>Thanks & Regards<br/>";
            $csv = Reader::createFromPath($this->filepath);
            if ($header_status === 1) {
                $csv->setHeaderOffset(0);
            }
            $records = $csv->getRecords();
            $data = [];
            foreach ($records as $record) {
                $data[] = $record;
            }
//            return count($data[0]);
            $emails = array();
            for ($i = 0; $i < count($data); $i++) {
                $emails[] = [
                    'name' => $data[$i][0],
                    'email' => $data[$i][1],
                    'date' => $data[$i][2],
                ];
            }

//            SendEmail::dispatch($emails, $message);
            return Response::json($emails);
        }
    }
