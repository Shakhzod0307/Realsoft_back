<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'number',
        'email',
        'message',
        'file'
    ];
}
