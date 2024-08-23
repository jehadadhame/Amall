<?php

namespace App\Models;

use App\Models\Implementations\ModelsPermission;
use App\Models\Implementations\RedisKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\CategoryObserver;
#[ObservedBy([CategoryObserver::class])]
class Category extends Model implements ModelsPermission, RedisKey
{
    use HasFactory;
    use SoftDeletes;
    /** @var Category[] */
    public array $children;


    protected $fillable = [
        "name",
        "slug",
        "cover_path",
        "admin_id",
        "website_id",
        "parent_id",
    ];

    /**
     * Summary of permissions
     * @return array of Category Permission
     */
    public static function permissions(): array
    {
        return [
            "viewAny" => "view any category",
            'create' => "create category",
            'update' => "update category",
            'delete' => "delete category",
            'forceDelete' => "forceDelete category",
            'bulkDelete' => "bulkDelete category",
            'restore' => "create category",
        ];
    }

    public static function firstKey($website)
    {
        $x = "{$website}_categories";
        return $x;
    }
    public static function secondKey($category_id)
    {
        return $category_id;
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
