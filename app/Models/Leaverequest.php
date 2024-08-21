<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Leaverequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_id',
        'date',
        'department_id',
        'positions_id',
        'from',
        'upto',
        'description',
        'attachment',
        'total',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

    //  public function department()
    //  {
    //      return $this->belongsTo(Department::class);
    //  }

    // public function position()
    // {
    //     return $this->belongsTo(Position::class);
    // }

    protected $append = [
        'leavedays','isPaid'
    ];


    public function getisPaidAttribute()
    {
        return leave::get('isPaidleave');

    }

    public function getleavedaysAttribute()
    {
        $date1=Carbon::parse($this->from);
        $date2=Carbon::parse($this->upto);
        $diff=$date1->diffInDays($date2);
        return $diff;

    }


}
