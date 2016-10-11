<?php

namespace RabbitCMS\Captcha\Providers;


use RabbitCMS\Modules\ModuleProvider;

class CaptchaServiceProvider extends ModuleProvider
{
    protected function name()
    {
        return 'captcha';
    }
}