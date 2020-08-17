<?php

namespace App\Models;

class validaUser
{
    const RULE_USER = [
        'name' => 'required|max:100',
        'email' => 'required|email|max:100',
        'password' => 'required|max:100'
    ];

}