<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DieselRefuelLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'diesel_level_before',
        'diesel_quantity',
        'diesel_level_after',
        'invoice_image_url',
        'waybill_image_url',
        'diesel_before_image_url',
        'diesel_after_image_url',
        'topup_worker_id'
    ];
}
