<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\validaFinan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ctrlFinanService;

class ctrlFinanController extends Controller
{
    private $service;

    public function __construct(ctrlFinanService $service)
    {
        $this->service = $service;
    }
    public function getAll($month, $user)
    {
        try {
            return response()->json($this->service->getAll($month, $user), Response::HTTP_OK);
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
        $validator = Validator::make($arrDados, validaFinan::RULE_CRTL_FIAN);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try{
             return response()->json($this->service->create($arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function Update($id, Request $request)
    {
        $arrDados = $request->all();
        $validator = Validator::make($arrDados, validaFinan::RULE_CRTL_FIAN);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try{
             return response()->json($this->service->Update($id,$arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Delete($id)
    {
        try {
            return response()->json($this->service->Delete($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
