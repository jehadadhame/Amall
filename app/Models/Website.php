<?php

namespace App\Models;

use App\Models\Implementations\RedisKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RedisWebsiteProperty;
class Website extends Model implements RedisKey
{
    use HasFactory;

    protected $fillable = [
        "name",
        "domain",
        "merchant_id",
    ];

    public static function firstKey($website)
    {
        return $website;
    }
    public static function secondKey($property)
    {
        switch ($property) {
            case RedisWebsiteProperty::category_tree:
                return 'category_tree';
            case RedisWebsiteProperty::website_id:
                return 'website_id';
            // break;
        }
        return null;
    }

    public function Merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function Admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function Categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
