<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\validaPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    private $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }
    public function getAll($user)
    {
        try {
            return response()->json($this->service->getAll($user), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get($id, $user)
    {
        try {
            return response()->json($this->service->get($id, $user), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        $arrDados = $request->all();
        $validator = Validator::make($arrDados, validaPayment::RULE_PAYMENT);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try {
            return response()->json($this->service->create($arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update($id, $user, Request $request)
    {
        $arrDados = $request->all();
        $validator = Validator::make($arrDados, validaPayment::RULE_PAYMENT);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try {
            return response()->json($this->service->update($id, $user, $arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id, $user)
    {
        try {
            return response()->json($this->service->delete($id, $user), Response::HTTP_OK);
        } catch (\Exception $e) {
            $code = $e->getCode();
            if ($code = 23000) {
                return response()->json("Esta forma de pagemento esta relacionada com outros registros", Response::HTTP_OK);
            } else {
                return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
