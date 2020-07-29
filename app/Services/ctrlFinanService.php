<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class ctrlFinanService
{

    public function getAll($month, $user)
    {

        return app('db')->select("SELECT  
                    cas.id_cash_flow,
                    cas.id_user,
                    cas.description,
                    cas.dt_create,
                    cas.due_date,
                    cas.value,
                    cas.porion,
                    cas.status,
                    p.descripction 'pay_description',
                    p.color 'pay_calor',
                    cat.descripction 'cat_description',
                    cat.color 'cat_calor'
                FROM cash_flow cas
                JOIN payment p ON cas.id_payment = p.id_payment and p.id_user = " . $user . "
                left JOIN category cat ON cas.id_category = cat.id_category and cat.id_user = " . $user . "
                WHERE MONTH(cas.due_date) = '" . $month . "' AND cas.id_user =" . $user . ";");
    }

    public function get($id, $user)
    {
        return app('db')->select("SELECT  
                    cas.id_cash_flow,
                    cas.id_user,
                    cas.description,
                    cas.dt_create,
                    cas.due_date,
                    cas.value,
                    cas.porion,
                    cas.status,
                    p.descripction 'pay_description',
                    p.color 'pay_calor',
                    cat.descripction 'cat_description',
                    cat.color 'cat_calor'
                FROM cash_flow cas
                JOIN payment p ON cas.id_payment = p.id_payment and p.id_user = " . $user . "
                left JOIN category cat ON cas.id_category = cat.id_category and cat.id_user = " . $user . "
                WHERE cas.id_cash_flow = " . $id . " AND cas.id_user =" . $user . ";");
    }


    public function create($data)
    {
        $query = "INSERT INTO cash_flow (id_user, description, dt_create, due_date, value, porion, status, id_payment, id_category) values ('";
        $query .= "{$data['id_user']}', '{$data['description']}', '{$data['dt_create']}', '{$data['due_date']}', '{$data['value']}', '{$data['porion']}', '{$data['status']}', {$data['id_payment']}, {$data['id_category']});";
        return app('db')->select($query);
    }

    public function update($id, $data)
    {
        $query = "UPDATE cash_flow SET id_user ='{$data['id_user']}', description = '{$data['description']}', dt_create = '{$data['dt_create']}',
         due_date ='{$data['due_date']}', value ='{$data['value']}', porion='{$data['porion']}', status ='{$data['status']}', 
         id_payment ={$data['id_payment']}, id_category ={$data['id_category']}
         WHERE id_cash_flow = {$id}";
        return app('db')->select($query);
    }

    public function Delete($id)
    {
        return app('db')->select("DELETE FROM cash_flow WHERE id_cash_flow = {$id}");
    }
}
