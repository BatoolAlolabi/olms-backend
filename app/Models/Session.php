<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'leasson_sessions';
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'max_capacity'
    ];
}
