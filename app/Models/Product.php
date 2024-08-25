<?php

namespace App\Models;

use App\Models\Implementations\ModelsPermission;
use App\Models\Implementations\RedisKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements ModelsPermission, RedisKey
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'cover',
        'admin_id',
        'website_id',
        'category_id',
        'is_special',
        'is_new',
    ];
    public static function firstKey($website)
    {
        return "{$website}_products";
    }
    public static function secondKey($id)
    {
        return $id;
    }
    public static function permissions(): array
    {
        return [
            "viewAny" => "view any product",
            'create' => "create product",
            'update' => "update product",
            'delete' => "delete product",
            'forceDelete' => "forceDelete product",
            'bulkDelete' => "bulkDelete product",
            'restore' => "create product",
        ];
    }
    public function reviews()
    {
        return $this->hasMany('reviews');
    }
    public function images()
    {
        return $this->hasMany('images');
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart-items', 'product_id', 'cart_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
