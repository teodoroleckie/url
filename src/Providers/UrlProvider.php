<?php

namespace Tleckie\Url\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use Tleckie\Url\Application\Shortener\ShortUrlFactory;
use Tleckie\Url\Application\Shortener\ShortUrlService;
use Tleckie\Url\Application\Shortener\ShortUrlServiceInterface;
use Tleckie\Url\Application\TokenValidator\TokenValidator;
use Tleckie\Url\Application\TokenValidator\TokenValidatorInterface;
use Tleckie\Url\Domain\ShortUrlAdapterInterface;
use Tleckie\Url\Domain\ShortUrlFactoryInterface;
use Tleckie\Url\Infrastructure\Http\Shortener\ShortUrlAdapter;

/**
 * Class UrlProvider
 * @package Tleckie\Url\Providers
 */
class UrlProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../routes/short-url.php'
        );

        $this->publishes([
            __DIR__.'/../config/shorturl.php' =>  config_path('shorturl.php'),
        ], 'config');
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TokenValidatorInterface::class, function ($app) {

            return new TokenValidator(
                $app['config']->get('shorturl.pattern'),
                $app['config']->get('shorturl.nestedTags')
            );
        });

        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });

        $this->app->bind(ShortUrlFactoryInterface::class, function () {
            return new ShortUrlFactory();
        });

        $this->app->bind(ShortUrlServiceInterface::class, function ($app) {

            return new ShortUrlService(
                $app[ShortUrlAdapterInterface::class],
                $app[ShortUrlFactoryInterface::class]
            );

        });

        $this->app->bind(ShortUrlAdapterInterface::class, function ($app) {

            return new ShortUrlAdapter(
                $app[ClientInterface::class],
                $app['config']->get('shorturl.shortenEndpoint'),
                $app['config']->get('shorturl.shortenRequestMethod')
            );
        });

    }

}
