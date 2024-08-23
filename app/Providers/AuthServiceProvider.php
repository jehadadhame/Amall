<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Product;
use Attribute;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\AttributePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Attribute::class => AttributePolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        // $permissions = Permission::all();
        // foreach ($permissions as $permission) {
        //     Gate::define($permission->name, function ($user) use ($permission) {
        //         return $user->hasPermissionTo($permission->name);
        //     });
        // }
        $this->registerPolicies();

        //
    }
}
