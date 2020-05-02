<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ChouJiangRecord extends Model
{
    use Notifiable;
    //
    protected $fillable = [
        'prize',
        'email'
    ];
}
