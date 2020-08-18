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
use App\Services\UserService;
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
            'sub' => $user[0]->id_user,
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

        $user = app('db')->select("SELECT * FROM user u WHERE u.email ='{$data['email']}' LIMIT 1;");

        if (!$user) {
            return response()->json([
                'error' => 'E-mail não cadastrado!'
            ], Response::HTTP_BAD_REQUEST);
        }
        $password = $this->coreSerive->encrypt($data['password']);

        if ($user[0]->password == $password) {
            return response()->json([
                'token' => $this->jwt($user)
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'E-mail ou senha inválidos'
            ], Response::HTTP_BAD_REQUEST);
        }


        // try {
        //     return response()->json($this->service->login($request), Response::HTTP_OK);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e, $e->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }
}
