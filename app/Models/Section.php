<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'days_of_week' => 'json'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function sessions(){
        return $this->hasMany(Session::class);
    }

    public function students(){
        return $this->belongsToMany(User::class,'student_sections','section_id','student_id');
    }
}
