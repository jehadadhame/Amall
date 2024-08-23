<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        "user_id",
        "website_id",
        "total_amount",
        "status"
    ];
    use HasFactory;
}
