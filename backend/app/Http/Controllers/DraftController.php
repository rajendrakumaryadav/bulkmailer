<?php

    namespace App\Http\Controllers;

    use App\Models\Drafts;
    use App\Models\Schedules;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Log\Logger;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    use Symfony\Component\HttpFoundation\Response;
    use function response;

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
                return response()->json([
                    "status_code" => Response::HTTP_OK, "id" => $draft->id, "draft_id" => $draft->draft_id,
                    "status" => 0, "created_at" => Carbon::now(),
                ]);
            } else {
                return response()->json([
                    "status_code" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "Failed to insert.",
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
            // GET /api/get-draft/{id}
            try {
                $draft = Drafts::findOrFail($id);
                $draft->file_path = url($draft->file_path);

                return response()->json([
                    "status_code" => Response::HTTP_OK, "data" => $draft, "created_at" => $draft->created_at,
                ]);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "status_code" => Response::HTTP_NOT_FOUND, "message" => "Draft not found.",
                    "created_at" => Carbon::now(),
                ], 404);
            }
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @return JsonResponse
         */
        public function modify(int $id): JsonResponse
        {
            // POST /api/add_to_draft/{id}
            $validator = Validator::make(request()->all(), [
                'file' => 'required_without:file_path|mimes:csv,txt',
                'file_path' => 'required_without:file|url',
                'from' => 'email',
                'reply_to' => 'email',
                'sender_name' => 'string',
                'subject' => 'string',
                'template' => 'string',
                'is_scheduled' => 'in:0,1',
            ]);
            if (count($validator->errors())) {
                return response()->json([
                    "status_code" => Response::HTTP_BAD_REQUEST, "message" => $validator->errors(),
                    "created_at" => Carbon::now(),
                ], 400);
            }

            $draft = Drafts::find($id);
            if (!$draft) {
                return response()->json([
                    "status_code" => Response::HTTP_NOT_FOUND, "message" => "Draft not found.",
                    "created_at" => Carbon::now(),
                ], 404);
            }
            if (\request()->file('file')) {
                $file = \request()->file('file');
                try {
                    $draft->file_path = $file->move('storage/draft/',
                        $this->get_unique_filename($id, $file)) ?? $draft->file_path;
                } catch (Exception $e) {
                    return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
                }
            }
            $draft->subject = \request()->input('subject') ?? $draft->subject;
            $draft->template = \request()->input('template') ?? $draft->template;
            $draft->from = \request()->input('from') ?? $draft->from;
            $draft->sender_name = \request()->input('sender_name') ?? $draft->sender_name;
            $draft->status = 0;
            $draft->reply_to = \request()->input('reply_to') ?? $draft->reply_to;
            $draft->is_scheduled = \request()->input('is_scheduled') ?? $draft->is_scheduled;
            if ($draft->is_scheduled) {
                $validator = Validator::make(request()->all(), [
                    'file' => 'required_without:file_path|mimes:csv,txt',
                    'file_path' => 'required_without:file|url', 'from' => 'required|email', 'reply_to' => 'email',
                    'sender_name' => 'required|string', 'subject' => 'required', 'template' => 'required',
                    'is_scheduled' => 'required|in:0,1',
                    'schedule_datetime' => 'required|date|date_format:Y-m-d H:i:s|after:now',
                ]);
                if (count($validator->errors())) {
                    return response()->json([
                        "status_code" => Response::HTTP_BAD_REQUEST,
                        "message" => $validator->errors(),
                        "created_at" => Carbon::now(),
                    ], 400);
                }
                $draft->scheduled_at = \request()->input('schedule_datetime');
                $draft->is_schedule_active = 1;
            }
            dd($draft->file_path);
            if ($draft->save()) {
                $draft->file_path = url($draft->file_path);

                return response()->json([
                    "status_code" => Response::HTTP_OK, "message" => "Draft updated successfully.", "data" => $draft,
                    "created_at" => Carbon::now(),
                ]);
            } else {
                return response()->json([
                    "status_code" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "Failed to update draft.",
                    "created_at" => Carbon::now(),
                ], 500);
            }
        }

        /**
         * This method accepts file object and generate a unique filename.
         * It consists of uniquedata with timestamp and original filename.
         * @param $file
         * @return string
         */
        private function get_unique_filename($draft_id, $file): string
        {
            $original_name = $file->getClientOriginalName();

            return $draft_id.'_'.uniqid()."_".date("Y-m-d-H-i-s", time())."_".$original_name;
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
                    return response()->json([
                        "status_code" => Response::HTTP_OK, "message" => "Draft deleted successfully.",
                    ]);
                } else {
                    return response()->json([
                        "status_code" => Response::HTTP_NOT_FOUND, "message" => "Draft does not exists.",
                    ], 404);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "status_code" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "Unknown error occurred.",
                ], 500);
            }
        }

        public function getDrafts()
        {
            $drafts = DB::table('drafts')->where('status', '=', '0')->get();

            return response()->json([
                "status_code" => Response::HTTP_OK, "data" => $drafts,
            ]);
        }
    }
