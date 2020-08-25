<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CategoryService
{

    public function getAll($auth)
    {
        return DB::table('category')
            ->where('id_user', $auth[0]->id_user)
            ->get();
    }

    public function get($id, $auth)
    {
        return DB::table('category')
            ->where([
                ['id_user', $auth[0]->id_user],
                ['id_category', $id]
            ])
            ->get();
    }


    public function create($data)
    {
        return DB::table('category')->insert(
            [
                'id_user' => $data['id_user'],
                'description' => $data['description'],
                'color' => $data['color']
            ],
        );
    }

    public function update($data)
    {
        return DB::table('category')->updateOrInsert(
            [
                'id_user' => $data['id_user'],
                'id_category' => $data['id_category']
            ],
            [
                'description' => $data['description'],
                'color' => $data['color']
            ]
        );
    }

    public function Delete($id, $auth)
    {
        $valida = $exist = DB::table('category')->where([['id_user', $auth[0]->id_user], ['id_category', $id]])->get();
        if (count($valida)) {
            $exist = DB::table('cash_flow')->where([['id_user', $auth[0]->id_user], ['id_category', $id]])->get();
            if (count($exist)) {
                throw new Exception('Está categoria está Relacionada à outros registros', Response::HTTP_BAD_REQUEST);
            } else {
                return DB::table('category')
                    ->where([
                        ['id_category', $id],
                        ['id_user', $auth[0]->id_user]

                    ])
                    ->delete();
            }
        } else {
            throw new Exception('Registro não encontrado', Response::HTTP_BAD_REQUEST);
        }
    }
}
