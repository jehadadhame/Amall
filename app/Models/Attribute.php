<?php

namespace App\Models;

use App\Enums\AttributeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Implementations\ModelsPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model implements ModelsPermission
{
    use SoftDeletes;

    use HasFactory;
    protected $table = "attributes";
    protected $fillable = [
        "name",
        "description",
        "type",
        "website_id",
        "admin_id",
    ];

    public static function permissions(): array
    {
        return [
            "viewAny" => "view any atribute",
            'create' => "create atribute",
            'update' => "update atribute",
            'delete' => "delete atribute",
            'forceDelete' => "forceDelete atribute",
            'bulkDelete' => "bulkDelete atribute",
            'restore' => "create atribute",
        ];
    }
    protected function casts(): array
    {
        return [
            'type' => AttributeType::class,
        ];
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
