<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Services\coreService;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\validaUser;


class AuthController extends Controller
{

    private $coreSerive;

    public function __construct(coreService $coreSerive)
    {
        $this->coreSerive = $coreSerive;
    }

    protected function jwt($user)
    {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $user->id_user,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function login(Request $data)
    {
        $this->validate($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::table('user')->where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'error' => 'E-mail não cadastrado!'
            ], Response::HTTP_BAD_REQUEST);
        }
        $password = $this->coreSerive->encrypt($data['password']);

        if ($user->password == $password) {
            return response()->json([
                'token' => $this->jwt($user)
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'E-mail ou senha inválidos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
