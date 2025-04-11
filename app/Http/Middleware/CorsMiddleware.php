<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Xử lý preflight request (OPTIONS)
        if ($request->getMethod() === "OPTIONS") {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }

        // Thêm các header CORS cần thiết
        $response->headers->set('Access-Control-Allow-Origin', '*'); // hoặc '*' nếu bạn muốn cho phép mọi domain trong dev
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With');
        // Nếu FE của bạn cần gửi credentials (cookie hay auth header) thì bật dòng sau và cập nhật allowed origin
        // $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
