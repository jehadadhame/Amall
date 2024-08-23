<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Session;
class CategoryTree extends Model
{
    /**
     * Summary of tree
     * @param mixed $website_id
     * @param Collection|array $categories
     * @param \App\Models\Category|null $parent
     * @param \App\Models\Category|null $root
     * @return Category|null
     */
    public static function tree($categories, Category $parent = null, Category &$root = null)
    {
        if (is_array($categories)) {
            if (empty($categories))
                return null;
            $categories = collect($categories);
        }
        // dd($categories);
        if ($parent === null) {
            $rootCategory = $categories->whereNull('parent_id')->first();
            if (!$rootCategory) {
                return null; // No root category found
            }
            $parent = $rootCategory;
            $root = $rootCategory;
        }

        // Load children from the database
        $parent->children = $categories->where('parent_id', '=', $parent->id)->all();

        if (empty($parent->children)) {
            return;
        }
        foreach ($parent->children as $child) {
            self::tree($categories, $child, $root); // Recursive call
        }

        return $root;
    }

    /**
     * Summary of printTree
     * @param mixed $website
     * @param \App\Models\Category|null $tree
     * @param mixed $tr
     * @return mixed
     */
    public static function printTree($website, Category $tree = null, $tr = '')
    {
        if (null == $tree)
            return;
        $children = $tree->children; // Ensure this matches your relationship method
        if (empty($children)) {
            return $tr;
        }
        $tr .= '<ul>';
        foreach ($children as $child) {
            $tr .= "<li name='$child->id' id = '$child->id'>" .
                "<div class='container'>" .
                "<div class='cat-name'>" . $child->name . "</div>" .
                "<div class='cat-delete'>" .
                "<form action='" . route('website.admin.catalog.category.destroy', ['website' => $website, 'category' => $child->id]) . "' method= 'post' >" .
                csrf_field() .
                "<input type='hidden' name='_method' value='DELETE'>
                    <button type='submit'>delete</button>
                </form>" .
                "</div>" .
                "<div class='cat-edit'>" . "<a href='" . route('website.admin.catalog.category.edit', ['website' => $website, 'category' => $child->id]) . "'>edit</a>" . "</div>" .
                "</div>" .
                "</li>";
            $tr = self::printTree($website, $child, $tr);
        }
        $tr .= '</ul>';
        return $tr;
    }

}
