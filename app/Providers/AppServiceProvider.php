<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;

use Vite;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      Carbon::setLocale('uk-UA');

      Paginator::defaultView('vendor.pagination.bootstrap-5');

      // виводити на усіх сторінках як зміну в footer.blade.php
      View::share('const_share_AppServiceProvider', 'розробка Васильєвої С.Ю.');

      // виводити на розділ, наприклад - user*
      View::composer('user*', function($view){
        $view->with('balance', 123456);
      });

      // Помічники

      // тільки для локальною розробки
      // видає помилку на моєму admin/devices - тому закрила
      // Model::preventLazyLoading(!app()->isProduction());

      // збереження полів вказаних $fillable, якщо відсутній, то буде Exception  
      Model::preventsSilentlyDiscardingAttributes (!app()->isProduction());

      // якщо запит виконується більше 500, то повідомити про це
      DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
        // Notify development team...
      });

    }
}