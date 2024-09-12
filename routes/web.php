<?php
use App\Enums\AttributeType;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Category;
use App\Models\Website;
use Illuminate\Support\Facades\Route;
use Kunnu\Dropbox\DropboxApp;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Route name => website
 */
Route::domain('{website}.amall.ps')->group(function () {
    /**
     * Route name => website.admin
     */
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', ['App\Http\Controllers\website\Admin\WebsiteDashboardController', 'index'])->name('website.admin.dashboard')->middleware('websiteadmin');
        /**
         * Route name => website.admin.auth
         */
        Route::group(['middleware' => "notwebsiteadmin:{website}"], function () {
            Route::get('/login', ['App\Http\Controllers\website\Admin\Auth\AdminLoginController', 'showLoginForm'])->name('website.admin.auth.loginform');
            Route::post('/login', ['App\Http\Controllers\website\Admin\Auth\AdminLoginController', 'login'])->name('website.admin.auth.login');
            Route::get('/forgetpassword', ['App\Http\Controllers\website\Admin\Auth\AdminForgetPasswordController', 'showforgetpasswordForm'])->name('website.admin.auth.forgetpasswordform');
            Route::post('/forgetpassword', ['App\Http\Controllers\website\Admin\Auth\AdminForgetPasswordController', 'forgetpassword'])->name('website.admin.auth.forgetpassword');
            Route::post('/logout', ['App\Http\Controllers\website\Admin\Auth\AdminLoginController', 'logout'])->name('website.admin.auth.logout');

        });
        /**
         * Route name => website.admin.admins
         */
        Route::group(['prefix' => 'admins', 'middleware' => 'websiteadmin'], function () {
            Route::get('/', ['App\Http\Controllers\website\Admin\Admins\AdminsController', 'index'])->name('website.admin.admins.index');
            Route::get('/register', ['App\Http\Controllers\website\Admin\Admins\AdminRegisterController', 'showRegisterForm'])->name('website.admin.admins.registerform');
            Route::post('/register', ['App\Http\Controllers\website\Admin\Admins\AdminRegisterController', 'register'])->name('website.admin.admins.register');
            Route::get('/edit', ['App\Http\Controllers\website\Admin\Admins\AdminEditController', 'showEditForm'])->name('website.admin.admins.editform');
            Route::post('/edit', ['App\Http\Controllers\website\Admin\Admins\AdminEditController', 'edit'])->name('website.admin.admins.edit');
            Route::resource('role', 'App\Http\Controllers\website\Admin\Admins\RoleController', [
                'names' => [
                    'index' => 'website.admin.admins.role.index',
                    'create' => 'website.admin.admins.role.create',
                    'store' => 'website.admin.admins.role.store',
                    'show' => 'website.admin.admins.role.show',
                    'edit' => 'website.admin.admins.role.edit',
                    'update' => 'website.admin.admins.role.update',
                    'destroy' => 'website.admin.admins.role.destroy',
                ]
            ]);
        });
        /**
         * Route name => website.admin.catalog
         */
        Route::group(['prefix' => 'catalog', 'middleware' => 'websiteadmin'], function () {
            Route::get('/', ['App\Http\Controllers\website\Admin\Catalog\CatalogController', 'index'])->name('website.admin.catalog.index');
            /**
             * Route name => website.admin.catalog.category
             */
            Route::resource('category', 'App\Http\Controllers\website\Admin\Catalog\CategoryController', [
                'names' => [
                    'index' => 'website.admin.catalog.category.index',
                    'create' => 'website.admin.catalog.category.create',
                    'store' => 'website.admin.catalog.category.store',
                    'show' => 'website.admin.catalog.category.show',
                    'edit' => 'website.admin.catalog.category.edit',
                    'update' => 'website.admin.catalog.category.update',
                    'destroy' => 'website.admin.catalog.category.destroy',
                ]
            ]);
            /**
             * Route name => website.admin.catalog.product
             */
            Route::resource('product', 'App\Http\Controllers\website\Admin\Catalog\ProductController', [
                'names' => [
                    'index' => 'website.admin.catalog.product.index',
                    'create' => 'website.admin.catalog.product.create',
                    'store' => 'website.admin.catalog.product.store',
                    'show' => 'website.admin.catalog.product.show',
                    'edit' => 'website.admin.catalog.product.edit',
                    'update' => 'website.admin.catalog.product.update',
                    'destroy' => 'website.admin.catalog.product.destroy',
                ]
            ]);
            /**
             * Route name => website.admin.catalog.attribute
             */
            Route::resource('attribute', 'App\Http\Controllers\Website\Admin\Catalog\AttributeController', [
                'names' => [
                    'index' => 'website.admin.catalog.attribute.index',
                    'create' => 'website.admin.catalog.attribute.create',
                    'store' => 'website.admin.catalog.attribute.store',
                    'show' => 'website.admin.catalog.attribute.show',
                    'edit' => 'website.admin.catalog.attribute.edit',
                    'update' => 'website.admin.catalog.attribute.update',
                    'destroy' => 'website.admin.catalog.attribute.destroy',
                ],
            ]);
            Route::group(['prefix' => 'attribute'], function () {
                Route::delete('forcedelete/{id}', ['App\Http\Controllers\Website\Admin\Catalog\AttributeController', 'forcedelete'])->name('website.admin.catalog.attribute.forcedelete');
                Route::put('restore/{id}', ['App\Http\Controllers\website\Admin\Catalog\AttributeController', 'restore'])->name('website.admin.catalog.attribute.restore');
            });
            Route::resource('brand', 'App\Http\Controllers\website\Admin\Catalog\BrandController', [
                'names' => [
                    'index' => 'website.admin.catalog.brand.index',
                    'create' => 'website.admin.catalog.brand.create',
                    'store' => 'website.admin.catalog.brand.store',
                    'show' => 'website.admin.catalog.brand.show',
                    'edit' => 'website.admin.catalog.brand.edit',
                    'update' => 'website.admin.catalog.brand.update',
                    'destroy' => 'website.admin.catalog.brand.destroy',
                ],
            ]);
        });
    });
});

/**
 * 
 * Merchant Authentication
 */
Route::group(["prefix" => "merchant"], function () {
    // if merchant didn't login
    Route::group(['middleware' => 'notmerchant'], function () {
        Route::get('/register', ['App\Http\Controllers\Merchant\Auth\RegisterController', 'showRegisterForm'])->name('merchant.auth.registerform');
        Route::post('/register', ['App\Http\Controllers\Merchant\Auth\RegisterController', 'register'])->name('merchant.auth.register');
        Route::get('/login', ['App\Http\Controllers\Merchant\Auth\LoginController', 'showLoginForm'])->name('merchant.auth.loginform');
        Route::post('/login', ['App\Http\Controllers\Merchant\Auth\LoginController', 'login'])->name('merchant.auth.login');
        Route::post('/logout', ['App\Http\Controllers\Merchant\Auth\LoginController', 'logout'])->name('merchant.auth.logout');
    });
    // when merchant login 
    Route::group(['middleware' => 'merchant'], function () {
        Route::redirect('/', 'dashboard');
        Route::get("dashboard", ['App\Http\Controllers\Merchant\MerchantDashboardController', 'index'])->name("merchant.dashboard");
        Route::get("redirect{website}", ['App\Http\Controllers\Merchant\MerchantDashboardController', 'gotoWebisteDashboard'])->name("merchant.gotoWebisteDashboard");
        Route::get('Website/create', ['App\Http\Controllers\Merchant\Website\WebsiteController', 'create'])->name('merchant.website.create');
        Route::post('Website/store', ['App\Http\Controllers\Merchant\Website\WebsiteController', 'store'])->name('merchant.website.store');
        Route::get('Website/edit/{id}', ['App\Http\Controllers\Merchant\Website\WebsiteController', 'edit'])->name('merchant.website.edit');
        Route::post('Website/update', ['App\Http\Controllers\Merchant\Website\WebsiteController', 'update'])->name('merchant.website.update');
    });
});

use App\Models\Media;
use Symfony\Component\HttpFoundation\File\File;
use Kunnu\Dropbox\Dropbox;
Route::get('/', function () {
    $filepath = public_path('2.jpg');
    $file = new File($filepath);
    // echo $file->getFilename();
    // echo '<br>';
    // echo $file->getMimeType();
    // echo '<br>';
    // echo $file->getSize();
    // echo '<br>';
    // // dd($file);
    // Media::addMedia($file, 'demo');
    $app = new DropboxApp(
        'gcdfiv31wl3sqk4',
        '90vrpbs07rzdohk',
        'sl.B8xNfIoADRqFnSYxr8Xhr5OgzAoXh2zVdFUhISXhTtzB3PbsunYGsvqKN9YVCdx-gsLuENl0_3gOstFs__09TrG9l1OkPuFCY6oyVlzeDZglN7LUU_P9UFKqGsfHnVaESkLjQf5u7YcM7kcpaBc6idg',
    );
    $dropbox = new Dropbox($app);
    $fileMetaData = $dropbox->upload($file, '/App');
    $listFolderContents = $dropbox->listFolder("/");
    dd([$fileMetaData, $listFolderContents]);
});