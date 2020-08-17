<?php

namespace App\Models;

class validaCategory
{
    const RULE_CATEGORY = [
        'id_user' => 'required',
        'description' => 'required | max:150'
    ];

}