<?php

namespace RabbitCMS\Captcha\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;
use RabbitCMS\Captcha\Support\Captcha;

class CaptchaServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->registerConfig();
    }

    protected function registerConfig()
    {
        $configPath = realpath(__DIR__ . '/../../config/config.php');

        $this->mergeConfigFrom($configPath, 'captcha');

        $this->publishes([$configPath => config_path('captcha.php')]);
    }

    public function boot(ValidationFactory $factory, Router $router)
    {
        $router->get('captcha', ['as' => 'rabbitcms.captcha', 'uses' => 'RabbitCMS\\Captcha\\Http\\Controllers\\CaptchaController@getCaptcha'])
            ->middleware(['backend']);

        $factory->extend(
            'captcha',
            function ($attribute, $value, $parameters) {
                return Captcha::validate($value);
            }
        );
    }
}