<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class CategoryService
{

    public function getAll($user)
    {

        return app('db')->select("SELECT 
            c.id_category,
            c.description,
            c.color,
            c.id_user 
        FROM category c WHERE c.id_user = {$user};");
    }

    public function get($id, $user)
    {
        return app('db')->select("SELECT 
            c.id_category,
            c.description,
            c.color,
            c.id_user 
        FROM category c WHERE c.id_category = {$id} and c.id_user = {$user};");
    }


    public function create($data)
    {
        $query = "INSERT INTO category(id_user, description, color) VALUES ({$data['id_user']},'{$data['description']}', '{$data['color']}' );";
        return app('db')->select($query);
    }

    public function update($id, $user, $data)
    {
        $query = "UPDATE category c SET c.description = '{$data['description']}', c.color = '{$data['color']}' WHERE c.id_category = {$id} AND c.id_user = {$user};";
        return app('db')->select($query);
    }

    public function Delete($id, $user)
    {
        $exist = app('db')->select("SELECT * FROM cash_flow f WHERE f.id_category = {$id} AND f.id_user = {$user};");
        if (count($exist)) {
            return 'Está categria está Relacionada a outros registros';
        } else {
            return app('db')->select("DELETE FROM category WHERE id_category = {$id} AND id_user = {$user};");
        }
    }
}
