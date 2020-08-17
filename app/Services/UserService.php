<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Services\coreService;


class userService
{
    public function login($data)
    {
        //dd($data -> header('remembertoken'));

        dd($data);
    }

    public function createUser($data)
    {
    if (empty(app('db')->select("SELECT * FROM user u WHERE u.email = '{$data['email']}'"))) {
            $coreService = new coreService();
            $salary = array_key_exists("salary", $data) ? $data['salary'] : 0.00;
            $password = $coreService->encrypt($data['password']);
            $insert = "INSERT INTO user (name, salary, email, password) VALUE ('{$data['name']}', $salary, '{$data['email']}', '{$password}');";
            app('db')->select($insert);
            $rs = $this->createToken();
            return $rs;
        } else {
            $e = ('E-mail cadastrado');
            throw new \Exception($e);
        }
        
    }

    private function createToken()
    {
        $coreService = new coreService();
        $res = app('db')->select("SELECT MAX(u.id_user) ult from user u;");
        $id = $res[0]->ult;
        $token = $coreService->encode($id);
        app('db')->select("UPDATE user SET rememberToken = '{$token}' WHERE id_user = {$id}");
        return ["rememberToken" => $token];
    }
}
