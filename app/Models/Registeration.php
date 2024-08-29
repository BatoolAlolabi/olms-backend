<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registeration extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $dates = [
        'end_at',
        'started_at',
        'created_at',
        'updated_at',

    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function courses(){
        return $this->belongsToMany(Course::class,'course_registerations');
    }


}
