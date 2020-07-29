<?php

namespace App\Models;

class validaFinan
{
    const RULE_CRTL_FIAN = [
        'id_user' => 'required',
        'description' => 'required | max:100',
        'dt_create' => 'required | date_format: "Y-m-d"',
        'due_date' => 'required | date_format: "Y-m-d"',
        'id_payment' => 'required',
        'value' => 'required',
        'status' => 'required'
    ];

}