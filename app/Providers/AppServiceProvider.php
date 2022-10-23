<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::include('components.core.alert');
        \Blade::include('components.core.btn');
        \Blade::include('components.core.hamburger');
        \Blade::include('components.core.fontawesome', 'fa');
        \Blade::include('components.core.switcher');

        \Blade::aliasComponent('components.core.form', 'form');
        \Blade::include('components.core.forms.input');
        \Blade::include('components.core.forms.textarea');
        \Blade::aliasComponent('components.core.forms.select');
        \Blade::include('components.core.forms.checkbox');
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
    }
}
