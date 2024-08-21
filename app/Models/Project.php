<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'arname',
        'slug',
        'code',
        'customer',
        'Description',
        'esstimedStartDate',
        'esstimedEndDate',
        'accualstartDate',
        'accualendDate',
        'status',
        'hourlyrate',
        'esstimedhours',
    ];
}
