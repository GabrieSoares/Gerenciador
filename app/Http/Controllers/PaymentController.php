<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\validaPayment;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    private $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
        $this->Middleware('jwt.auth');
    }
    public function getAll(Request $request)
    {
        try {
            return response()->json($this->service->getAll($request->auth), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get($id, Request $request)
    {
        try {
            return response()->json($this->service->get($id, $request->auth), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        $arrDados = $request->all();
        $arrDados['id_user'] = $request->auth[0]->id_user;
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
    public function update(Request $request)
    {
        $arrDados = $request->all();
        $arrDados['id_user'] = $request->auth[0]->id_user;
        $validator = Validator::make($arrDados, validaPayment::RULE_PAYMENT);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try {
            return response()->json($this->service->update($arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id, Request $request)
    {
        try {
            return response()->json($this->service->delete($id, $request->auth), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
