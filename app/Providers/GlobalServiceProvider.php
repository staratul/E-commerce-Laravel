<?php

namespace App\Providers;

use App\Models\Admin\Menu;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class GlobalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('categories', function() {
            return $this->boot();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $menus = Menu::select(
                'menus.menu',
                'menus.menu_url',
                DB::raw('GROUP_CONCAT(sub_menus.sub_menu) as sub_menus'),
                DB::raw('GROUP_CONCAT(sub_menus.sub_menu_url) as sub_menu_urls')
            )
            ->leftJoin('sub_menus', 'menus.id', 'sub_menus.menu_id')
            ->groupBy('menus.menu')
            ->orderBy('menus.created_at')
            ->get();
        view()->share('menus', $menus);

        $categories = Category::select(
                'categories.category',
                'categories.category_url',
                DB::raw('GROUP_CONCAT(sub_categories.sub_category) as sub_categories'),
                DB::raw('GROUP_CONCAT(sub_categories.sub_category_url) as sub_category_urls')
            )
            ->leftJoin('sub_categories', 'categories.id', 'sub_categories.category_id')
            ->groupBy('categories.category')
            ->orderBy('categories.created_at')
            ->get();
        view()->share('categories', $categories);
        return $categories;
    }
}
