<?Php
namespace App\Http\Controllers\Website\Admin\Catalog;

use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function index($website)
    {
        return view("website.admin.catalog.index", compact("website"));
    }
}