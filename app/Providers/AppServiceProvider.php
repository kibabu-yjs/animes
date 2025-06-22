<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

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
        Model::unguard();

        /* Register a Blade Directive to render Blocks. */
        Blade::directive('faustblock', function (string $expression) {
            return Str::replaceArray('x', [
                $expression
            ], '<?php echo \SkyRaptor\FilamentBlocksBuilder\BlocksRenderer::render(x); ?>');
        });
    }
}
