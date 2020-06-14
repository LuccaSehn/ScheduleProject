<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use PDO;

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
        if (Config::get('database.default') === 'mysql') {
            try {
                $dbh = new PDO("mysql:host=" . Config::get('database.connections.mysql.host') . ";" . "port=" . Config::get('database.connections.mysql.port'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));
                $createDatabaseQuery = 'CREATE DATABASE IF NOT EXISTS ' . Config::get('database.connections.mysql.database') . ';';
                $dbh->exec($createDatabaseQuery);
                Builder::defaultStringLength(191);
            } catch (PDOException $e) {
                die("DB ERROR: " . $e->getMessage());
            }
        }
    }
}
