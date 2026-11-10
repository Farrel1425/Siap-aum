<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Carbon as Carbon2;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('development')) {
            // enable telescope
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('recaptcha', function (string $attribute, mixed $value): bool {
            if (! config('recaptcha.enabled')) {
                return true;
            }

            if (! is_string($value) || $value === '') {
                return false;
            }

            try {
                $response = Http::asForm()
                    ->timeout((int) config('recaptcha.curl_timeout', 10))
                    ->post('https://'.config('recaptcha.api_domain', 'www.google.com').'/recaptcha/api/siteverify', [
                        'secret' => config('recaptcha.api_secret_key'),
                        'response' => $value,
                        'remoteip' => request()->ip(),
                    ]);

                return $response->successful() && $response->json('success') === true;
            } catch (\Throwable) {
                return false;
            }
        }, (string) config('recaptcha.error_message_key', 'Verifikasi captcha gagal. Harap ulangi kembali.'));

        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($expression)): ?>";
        });

        Blade::directive('endrole', function ($expression) {
            return '<?php endif; ?>';
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Carbon::setLocale('id');
        Carbon2::setLocale('id');

        if (config('app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
