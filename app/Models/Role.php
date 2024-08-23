<?php

namespace App\Models;

use App\Models\Implementations\RedisKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Role extends Model implements RedisKey
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'website_id'
    ];

    public static function firstKey($website)
    {
        return "{$website}_roles";
    }
    public static function secondKey($id)
    {
        return $id;
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}
