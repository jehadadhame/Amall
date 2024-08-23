<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = [
        'path',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    use HasFactory;
}
