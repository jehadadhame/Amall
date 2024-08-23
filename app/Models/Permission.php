<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description"
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'permission_id', 'role_id');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_permissions', 'permission_id', 'admin_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
