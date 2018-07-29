<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carolinian extends Model
{
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'idnumber',
        'password',
        'description',
        'strength',
        'weakness',
        'usertype',
        'course_id'
    ];
}
