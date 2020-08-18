<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\validaCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $service;

    public function __construct(CategoryService $service)
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
        $validator = Validator::make($arrDados, validaCategory::RULE_CATEGORY);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try{
             return response()->json($this->service->create($arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function Update(Request $request)
    {
        $arrDados = $request->all();
        $arrDados['id_user'] = $request->auth[0]->id_user;
        $validator = Validator::make($arrDados, validaCategory::RULE_CATEGORY);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try{
             return response()->json($this->service->Update($arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Delete($id, Request $request)
    {
        try {
            return response()->json($this->service->Delete($id, $request->auth), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
