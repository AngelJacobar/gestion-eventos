<?php

namespace App\Providers;

use App\Providers\OAuth2\IDUProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            if (App::environment(['pruebas']) || App::isProduction()) {
                return Password::min(8)->max(15)->letters()->mixedCase()->numbers()->symbols()->uncompromised();
            }
            return Password::min(8)->max(15);
        });

        Blade::directive('date', function (string $expression) {
            return "<?php echo ({$expression} !== null) ? date('d/m/Y', strtotime({$expression})) : '' ; ?>";
        });

        Blade::directive('datetime', function (string $expression) {
            return "<?php echo ({$expression} !== null) ? date('d/m/Y H:i', strtotime({$expression})) : ''; ?>";
        });

        Blade::directive('sortIcon', function (string $expression) {
            $data = explode(',', str_replace(' ', '', $expression));
            $column = $data[0];
            $sort = $data[1];
            $direction = $data[2];

            return "<?php echo ({$sort} == {$column})?
                        (({$direction} == 'asc')
                        ?'<i class=\"fa-solid fa-sort-up\"></i>':'<i class=\"fa-solid fa-sort-down\"></i>')
                        :'<i class=\"fa-solid fa-sort\" style=\"#a5acb9\"></i>'
                    ?>";
        });

        if (config('app.force_https')) {
            URL::forceScheme('https');
        }

        if (config('services.idu.sso')) {
            $this->bootIDUSocialite();
        }
    }

    private function bootIDUSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'idu',
            function ($app) use ($socialite) {
                $config = $app['config']['services.idu'];
                return $socialite->buildProvider(IDUProvider::class, $config);
            }
        );
    }
}
