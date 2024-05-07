<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAttendance extends Model
{
    use HasFactory;


    protected $fillable = [
        'member_id',
        'service_id',
        'time_in',
        'time_out',
        'created_by'
    ];
}
