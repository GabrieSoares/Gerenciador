<?php

namespace App\Models;

class validaPayment
{
    const RULE_PAYMENT = [
        'id_user' => 'required',
        'description' => 'required | max:150'
    ];

}