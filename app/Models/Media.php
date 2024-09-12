<?php

namespace App\Models;

use App\Enums\RedisWebsiteProperty;
use App\Http\Controllers\Website\Admin\RedisController;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'path',
        'website_id',
        'size'
    ];
    public static function addMedia(File $file, $website)
    {
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website),
        );
        echo 'add Media method <br>';
        dd($file);
    }
    public function Website()
    {
        return $this->belongsTo(Website::class);
    }
    public function Models()
    {
        return $this->morphedByMany(Product::class, 'mediaable');
    }
    use HasFactory;
}
