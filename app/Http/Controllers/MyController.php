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
            $data = array_slice(Request::post(), 1, count(Request::post()) - 1);
            $col_index = array();
            for ($i = 0; $i < count($data); $i++) {
                $col_index[] = $data['col_'.$i];
            }
            // use this logic to dynamically binding the columns to the model

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
                $x = 0;
                $emails[] = [
                    $col_index[count($data) - count($data)] => $data[$i][$x],
                    $col_index[count($data) - (count($data) - 1)] => $data[$i][count($data) - (count($data) - 1)],
                    $col_index[$x + 2] => $data[$i][$x + 2],
                ];
            }

//            SendEmail::dispatch($emails, $message);
            return Response::json($emails);
        }
    }
