<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "price",
        "product_id",
    ];

    public function options()
    {
        return $this->belongsToMany(Option::class, "bundles_options", "bundle_id", "option_id");
    }

}
