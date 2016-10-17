<?php

namespace RabbitCMS\Captcha\Support;


use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Str;

class Captcha
{
    public static function validate($value)
    {
        $captcha_hash = (string) \Session::get('captcha_hash');

        if (\Hash::check(Str::lower($value), $captcha_hash)) {
            \Session::forget('captcha_hash');
            return true;
        }

        return false;
    }

    public static function image()
    {
        $config = config('captcha');

        $builder = new CaptchaBuilder();
        $builder->setBackgroundColor(255, 255, 255);
        $builder->setIgnoreAllEffects(true);

        $builder->build($config['width'], $config['height']);

        $data = $builder->get($config['quality']);

        \Session::put('captcha_hash', \Hash::make(Str::lower($builder->getPhrase())));

        return \Response::make($data, 200, ['Content-Type' => 'image/jpeg']);
    }
}

