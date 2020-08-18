<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        if (!$token) {
            return response()->json([
                'error' => 'Token requirido'
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        }catch(ExpiredException $e){
            return response()->json([
                'error' => 'Token Expirado',
                'exception' => $e
            ], Response::HTTP_BAD_REQUEST);
        }catch(Exception $e){
            return response()->json([
                'error' => 'Ocorreu um erro na decodificaçao',
                'exception' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = app('db')->select("SELECT * FROM user u WHERE u.id_user ='{$credentials->sub}';");

        $request->auth = $user;
        return $next($request);
    }
}
