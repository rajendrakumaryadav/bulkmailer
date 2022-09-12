<?php

    namespace App\Http\Controllers;

    use App\Models\Drafts;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
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
                    "status" => 0,
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
         * @return mixed
         */
        public function update(Request $request, $id)
        {
            $request = Validator::make($request->all(), [
                'file' => 'file|mimes:csv',
                'subject' => 'string|max:255',
                'template' => 'string',
                'from' => 'string',
                "reply_to" => 'string',
            ]);

            if (count($request->errors()) > 0) {
                return $request->errors();
            }

            return $request;

            $data = $request;
            $draft = Drafts::find($id);
            $draft->from = $data['from'];
            $draft->reply_to = $data['reply_to'];
            $draft->file_path = $data['file_path'];
            $draft->subject = $data['subject'];
            $draft->template = $data['template'];
            $draft->status = $data['status'];
            $draft->save();

            $d = Drafts::find($id);

            return \response()->json([
                "status_code" => ResponseAlias::HTTP_OK,
                "data" => $d,
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return JsonResponse
         */
        public function destroy($id)
        {
            try {
                $drafts = DB::table('drafts')->where('id', $id);
                if ($drafts->delete() > 0) {
                    return \response()->json([
                        "status_code" => ResponseAlias::HTTP_OK,
                        "message" => "Draft deleted successfully.",
                    ]);
                } else {
                    return \response()->json([
                        "status_code" => ResponseAlias::HTTP_NOT_FOUND,
                        "message" => "Draft does not exists.",
                    ], 404);
                }
            } catch (ModelNotFoundException $e) {
                return \response()->json([
                    "status_code" => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Unknown error occurred.",
                ], 500);
            }
        }

        public function getDrafts()
        {
            $drafts = DB::table('drafts')->where('status', '=', '0')->get();

            return \response()->json([
                "status_code" => ResponseAlias::HTTP_OK,
                "data" => $drafts,
            ]);
        }
    }
