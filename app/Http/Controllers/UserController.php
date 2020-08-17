<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Models\validaUser;


class userController extends Controller
{
    private $service;

    public function __construct(userService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        try {
            return response()->json($this->service->login($request), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e, $e->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(Request $request)
    {
        $arrDados = $request->all();
        $validator = Validator::make($arrDados, validaUser::RULE_USER);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try {
            return response()->json($this->service->createUser($arrDados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
