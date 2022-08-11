<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    class CheckRequiredHeader
    {
        /**
         * Handle an incoming request.
         *
         * @param  Request  $request
         * @param  Closure(Request): (Response|RedirectResponse)  $next
         * @return Response|RedirectResponse
         */
        public function handle(Request $request, Closure $next)
        {
            $request->header('Accept', 'application/json');
            if ($request->header('User-Agent') == 'SendinBlue Webhook') {
                return $next($request);
            }

            return response('Unauthorized.', 401);
        }
    }
