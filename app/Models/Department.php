<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'school_id'
    ];


    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}
