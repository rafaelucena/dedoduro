<?php

namespace App\Providers;

use App;
use App\Http\Models\Category;
use App\Http\Models\Setting;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* @var EntityManager $em */
        $em = app('em');
        // Share sidebar Categories with all views
        if ($categories = $em->getRepository(Category::class)->findAll()) {
//            $categories = Category::select('name', 'slug', 'id')->get();
            View::share('sidebar_categories', $categories);
        }

        // Share Settings all views
        if ($settings = $em->getRepository(Setting::class)->findAll()) {
            // You can keep this in your filters.php file
            App::singleton('global_settings', function () use ($settings) {
//                return Setting::select('setting_name', 'setting_value')->get();
                return $settings;
            });
            // If you use this line of code then it'll be available in any view
            // as $global_settings but you may also use app('global_settings') as well
            // View::share('global_settings', app('global_settings'));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
