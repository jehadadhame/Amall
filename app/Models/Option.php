<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "attribute_id"
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {

        return $this->belongsToMany(Product::class, "products_options", "option_id", "product_id");
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, "bundles_options", "option_id", "bundle_id");
    }
}
