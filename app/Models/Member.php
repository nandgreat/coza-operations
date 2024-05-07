<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'member_code',
        'church_id',
        'member_code',
        'image_url',
        'percentage_attendance',
        'total_attendance',
        'total_services',
        'expected_attendance',
        'is_onboarding_completed',
        'created_by'
    ];
}
