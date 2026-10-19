<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\{Paginator, LengthAwarePaginator};
use Illuminate\Support\Collection;
use Jenssegers\Agent\Agent;
use App\Models\{Admin, Genre};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->callAfterResolving('cache', function ($manager) {
            $manager->extend('redis', function ($app, $config) use ($manager) {
                $connection = $config['connection'] ?? 'default';
                $store = new \App\Cache\HistorySafeRedisStore(
                    $app['redis'], $config['prefix'] ?? $app['config']['cache.prefix'], $connection
                );

                return $manager->repository($store->setLockConnection($config['lock_connection'] ?? $connection));
            });
        });

        \View::composer([
            'pages.gigs.modals.edit', 
            'pages.gigs.modals.create', 
        ], function($view) {
            $view->with(['musicians' => Admin::musicians()->get()]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Model::unguard();

        \Blade::include('components.core.alert');
        \Blade::include('components.core.btn');
        \Blade::include('components.core.hamburger');
        \Blade::include('components.core.fontawesome', 'fa');
        \Blade::include('components.core.switcher');

        \Blade::aliasComponent('components.core.form', 'form');
        \Blade::include('components.core.forms.input');
        \Blade::include('components.core.forms.toggle');
        \Blade::include('components.core.forms.textarea');
        \Blade::aliasComponent('components.core.forms.select');
        \Blade::aliasComponent('components.core.forms.checkbox');
        \Blade::include('components.core.forms.radio');
        \Blade::include('components.core.forms.option');
        \Blade::include('components.core.forms.submit');
        \Blade::include('components.core.forms.label');
        \Blade::include('components.core.forms.feedback');
        \Blade::include('components.core.forms.password');

        \Blade::include('components.core.breadcrumbs');
        \Blade::aliasComponent('components.core.container');
        \Blade::aliasComponent('components.core.modal');
        \Blade::include('components.core.delete');

        \Blade::include('components.core.forms.datepicker');
        \Blade::include('components.core.forms.timepicker');

        \Blade::include('components.buttons.create');
        \Blade::include('components.pagetitle');
        \Blade::include('components.searchbar');
        \Blade::include('components.nav');
        \Blade::include('layouts.menu.components.divider');
        \Blade::include('layouts.menu.components.link');

        \Blade::include('components.table.layout', 'table');
        \Blade::include('components.table.responsive.layout', 'responsiveTable');
        \Blade::aliasComponent('components.table.responsive.row', 'responsiveRow');


        \Blade::if('admin', function () {
            return auth()->check() && auth()->user()->admin;
        });

        \Blade::if('local', function () {
            return local();
        });       

        Collection::macro('paginate', function ($perPage) {
            $page = Paginator::resolveCurrentPage();

            return new LengthAwarePaginator($this->forPage($page, $perPage), $this->count(), $perPage, null, ['path' => Paginator::resolveCurrentPath()]);
        });
    }
}
