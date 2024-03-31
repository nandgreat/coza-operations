<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratorUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        "generator_id",
        "time_on",
        "time_off",
        "turn_off_worker_id",
        "usage_session_id",
        "turn_on_worker_id",
        "generator_purpose_id",
        "generator_load",
        "approved_by"
    ];
}
