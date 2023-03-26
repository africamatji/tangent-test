<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'method',
        'url',
        'status_code',
        'headers',
        'data',
        'content',
    ];
}
