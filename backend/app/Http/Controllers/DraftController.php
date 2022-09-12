<?php

    namespace App\Http\Controllers;

    use App\Models\Drafts;
    use Carbon\Carbon;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseAlias;

    class DraftController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return JsonResponse
         */
        public function index()
        {
            //   POST /api/create-job
            $draft_id = "DRAFT_ID_".uniqid();

            $draft = new Drafts();
            $draft->draft_id = $draft_id;
            $inserted = $draft->save();
            if ($inserted) {
                return \response()->json([
                    "status_code" => ResponseAlias::HTTP_OK,
                    "id" => $draft->id,
                    "draft_id" => $draft->draft_id,
                    "created_at" => Carbon::now(),
                ]);
            } else {
                return \response()->json([
                    "status_code" => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Failed to insert.",
                    "created_at" => Carbon::now(),
                ], 500);
            }
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            // POST /api/create-job
            // on the request to the endpoint
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
         * @param  int  $id
         * @return Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function edit($id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request  $request
         * @param  int  $id
         * @return JsonResponse
         */
        public function update(Request $request, $id)
        {
            $data = $request->request->all();
            $draft = Drafts::find($id);
            $draft->from = $data['from'];
            $draft->subject = $data['subject'];
            $draft->template = $data['template'];
            $draft->status = $data['status'];
            $draft->save();

            $d = Drafts::find($id);
            return \response()->json([
                "status_code" => ResponseAlias::HTTP_OK,
                "id" => $d->id,
                "draft_id" => $d->draft_id,
                "from" => $d->from,
                "subject" => $d->subject,
                "template" => $d->template,
                "status" => $d->status,
            ]);

            return \response()->json([
                "id" => $id,
                "data" => $data,
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy($id)
        {
            //
        }
    }
