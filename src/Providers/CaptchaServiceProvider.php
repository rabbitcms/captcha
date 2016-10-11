<?php

namespace RabbitCMS\Captcha\Providers;


use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;
use RabbitCMS\Captcha\Facades\Captcha as CaptchaFacade;

class CaptchaServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->registerConfig();

        AliasLoader::getInstance(['Captcha' => CaptchaFacade::class]);

        $this->app['captcha'] = $this->app->share(function ($app) {
            return \Captcha::instance();
        });
    }

    protected function registerConfig()
    {
        $configPath = realpath(__DIR__ . '/../../config/config.php');

        $this->mergeConfigFrom($configPath, 'captcha');

        $this->publishes([$configPath => config_path('captcha.php')]);
    }

    public function boot(ValidationFactory $factory, Router $router)
    {
        $router->get('captcha/{id}', ['as' => 'rabbitcms.captcha.image', 'uses' => 'RabbitCMS\\Captcha\\Http\\Controllers\\CaptchaController@getCaptcha']);
        $router->get('captcha', ['as' => 'rabbitcms.captcha', 'uses' => 'RabbitCMS\\Captcha\\Http\\Controllers\\CaptchaController@getIndex']);

        $factory->extend(
            'captcha',
            function ($attribute, $value, $parameters) {
                return true;
                //dd($attribute, $value, $parameters);
                //Captcha::check($value);
            }
        );
    }
}