<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratorUsageSession extends Model
{
    use HasFactory;

    protected $fillable = [
        "diesel_level_before",
        "time_start",
        "turn_on_worker_id",
        "time_stop",
        "diesel_level_after",
        "turn_off_worker_id"
    ];
}
