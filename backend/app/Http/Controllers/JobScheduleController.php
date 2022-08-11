<?php

    namespace App\Http\Controllers;

    use App\Models\JobDetails;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Symfony\Component\HttpFoundation\Response as ResponseAlias;

    class JobScheduleController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
            //
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request  $request
         * @return Response
         */
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param  JobDetails  $jobSchedule
         * @return Response
         */
        public function show(JobDetails $jobSchedule)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  JobDetails  $jobSchedule
         * @return Response
         */
        public function edit(JobDetails $jobSchedule)
        {
            //
        }

        public function addWebhook()
        {
            if (!\request()->isMethod('POST')) {
                return Response::$statusTexts[ResponseAlias::HTTP_NOT_FOUND];
            }

            $data = \request()->post();

            Log::info($data);

            DB::table('job_details')->where('messageId', $data['message-id'])->update([
                'webhook_id' => $data['id'] ?? null, 'webhook_server_timestamp' => $data['date'] ?? null,
                'ts' => $data['ts'] ?? null, 'ts_event' => $data['ts_event'] ?? null,
                'event' => $data['event'] ?? null, 'date' => $data['date'] ?? null,
                'sending_ip' => $data['sending_ip'] ?? null,
            ]);

            return Response::$statusTexts[ResponseAlias::HTTP_NO_CONTENT];

        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request  $request
         * @param  JobDetails  $jobSchedule
         * @return Response
         */
        public function update(Request $request, JobDetails $jobSchedule)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  JobDetails  $jobSchedule
         * @return Response
         */
        public function destroy(JobDetails $jobSchedule)
        {
            //
        }
    }
