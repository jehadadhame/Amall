<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $fillable = [
        'code',
        'type',
        'start_date',
        'end_date',
        'website_id',
        'used',
    ];
    use HasFactory;
}
