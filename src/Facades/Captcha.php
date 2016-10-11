<?php

namespace RabbitCMS\Captcha\Facades;


use Illuminate\Support\Facades\Facade;
use \RabbitCMS\Captcha\Support\Captcha as CaptchaSupport;

class Captcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CaptchaSupport::class;
    }
}