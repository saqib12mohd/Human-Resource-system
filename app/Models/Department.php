<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'arname',
        'slug',
        'grade',
        'isactive',
    ];

       public function position()
       {
        return $this->hasMany(Position::class);
       }
}
