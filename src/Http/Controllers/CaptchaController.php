<?php

namespace RabbitCMS\Captcha\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use RabbitCMS\Captcha\Support\Captcha;

class CaptchaController extends Controller
{
    public function getIndex()
    {
        return \Redirect::route('rabbitcms.captcha.image', ['id' => \Crypt::encrypt(Str::random(5))]);
    }

    public function getCaptcha()
    {
        return Captcha::image();
    }
}