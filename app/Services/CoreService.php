<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class coreService
{
    public function encode($string)
    {
        return base64_encode($string);
    }

    public function decode($string)
    {
        return base64_decode($string);
    }

    public function encrypt($string)
    {
        return md5($string);
    }
}
