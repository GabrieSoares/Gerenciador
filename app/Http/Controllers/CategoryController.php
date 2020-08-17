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
    public function Update($id, $user, Request $request)
    {
        $arrDados = $request->all();
        $validator = Validator::make($arrDados, validaCategory::RULE_CATEGORY);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        try{
             return response()->json($this->service->Update($id, $user, $arrDados), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Delete($id, $user)
    {
        try {
            return response()->json($this->service->Delete($id, $user), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
