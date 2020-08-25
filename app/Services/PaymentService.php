<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PaymentService
{

    public function getAll($auth)
    {
        return DB::table('payment')
            ->where('id_user', $auth[0]->id_user)
            ->get();
    }

    public function get($id, $auth)
    {
        return DB::table('payment')
            ->where([
                ['id_user', $auth[0]->id_user],
                ['id_payment', $id]
            ])
            ->get();
    }


    public function create($data)
    {
        return DB::table('payment')->insert(
            [
                'id_user' => $data['id_user'],
                'description' => $data['description'],
                'color' => $data['color']
            ],
        );
    }

    public function update($data)
    {
        return DB::table('payment')->updateOrInsert(
            [
                'id_user' => $data['id_user'],
                'id_payment' => $data['id_payment']
            ],
            [
                'description' => $data['description'],
                'color' => $data['color']
            ]
        );
    }

    public function delete($id, $auth)
    {
        $valida = $exist = DB::table('payment')->where([['id_user', $auth[0]->id_user], ['id_payment', $id]])->get();
        if (count($valida)) {
            $exist = DB::table('cash_flow')->where([['id_user', $auth[0]->id_user], ['id_payment', $id]])->get();
            if (count($exist)) {
                throw new Exception('Está Forma de Pagamento está Relacionada à outros registros', Response::HTTP_BAD_REQUEST);
            } else {
                return DB::table('payment')
                    ->where([
                        ['id_payment', $id],
                        ['id_user', $auth[0]->id_user]

                    ])
                    ->delete();
            }
        } else {
            throw new Exception('Registro não encontrado', Response::HTTP_BAD_REQUEST);
        }
    }
}
