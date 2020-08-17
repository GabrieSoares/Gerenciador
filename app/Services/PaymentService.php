<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class PaymentService
{

    public function getAll($user)
    {

        return app('db')->select("SELECT 
            p.id_payment,
            p.description,
            p.color,
            p.id_user 
        FROM payment p WHERE p.id_user = {$user};");
    }

    public function get($id, $user)
    {
        return app('db')->select("SELECT 
            p.id_payment,
            p.description,
            p.color,
            p.id_user 
        FROM payment p WHERE p.id_payment = {$id} and p.id_user = {$user};");
    }


    public function create($data)
    {
        $query = "INSERT INTO payment(id_user, description, color) VALUES ({$data['id_user']},'{$data['description']}', '{$data['color']}' );";
        return app('db')->select($query);
    }

    public function update($id, $user, $data)
    {
        $query = "UPDATE payment p SET p.description = '{$data['description']}', p.color = '{$data['color']}' WHERE p.id_payment = {$id} AND p.id_user = {$user};";
        return app('db')->select($query);
    }

    public function delete($id, $user)
    {
        // $exist = app('db')->select("SELECT * FROM cash_flow f WHERE f.id_category = {$id} AND f.id_user = {$user};");
        // if (count($exist)) {
        //     return 'Está categria está Relacionada a outros registros';
        // } else {
        return app('db')->select("DELETE FROM payment WHERE id_payment = {$id} AND id_user = {$user};");
        //}
    }
}
