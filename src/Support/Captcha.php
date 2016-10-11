<?php

namespace RabbitCMS\Captcha\Support;


use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Str;

class Captcha
{
    public static function validate($value)
    {
        return true;
    }

    public static function image($captcha_id)
    {
        $config = config('captcha');

        $builder = new CaptchaBuilder(\Crypt::decrypt($captcha_id));
        $builder->build($config['width'], $config['height']);

        $data = $builder->get();

        return \Response::make($data, 200, ['Content-Type' => 'image/jpeg']);
    }
}
/*
class Captcha
{
    protected $builder;
    // Builds a code until it is not readable by ocrad.
    // You'll need to have shell_exec enabled, imagemagick and ocrad installed.
    protected $against_ocr = false;
    // Builds a code with the given width, height and font. By default, a random font will be used from the library.
    protected $width = 150;
    protected $height = 40;
    protected $font = null;
    // Setting the picture quality.
    protected $quality = 80;
    public function __construct()
    {
        $this->builder = new CaptchaBuilder();
        $configKey = 'captcha.';
        $this->against_ocr = \Config::get($configKey . 'against_ocr');
        $this->width = \Config::get($configKey . 'width');
        $this->height = \Config::get($configKey . 'height');
        $this->font = \Config::get($configKey . 'font');
        $this->quality = \Config::get($configKey . 'quality');

        $this->builder->setDistortion(\Config::get($configKey . 'distortion'));
        $this->builder->setInterpolation(\Config::get($configKey . 'interpolate'));
        $this->builder->setIgnoreAllEffects(\Config::get($configKey . 'ignore_all_effects'));
    }
    public static function instance()
    {
        static $object;
        if (is_null($object)) {
            $object = new static();
        }
        return $object;
    }

    public function create()
    {
        $method = $this->against_ocr ? 'buildAgainstOCR' : 'build';
        $this->builder->$method($this->width, $this->height, $this->font);
        $data = $this->builder->get($this->quality);
        $phrase = $this->builder->getPhrase();
        \Session::put('captcha_hash', \Hash::make(Str::lower($phrase)));
        return \Response::make($data)->header('Content-type', 'image/jpeg');
    }

    public static function check($value)
    {
        $captcha_hash = (string) \Session::get('captcha_hash');
        \Session::forget('captcha_hash');
        return $captcha_hash && \Hash::check(Str::lower($value), $captcha_hash);
    }

    public static function url()
    {
        $uniqid = uniqid(gethostname(), true);
        $md5 = substr(md5($uniqid), 12, 8); // 8位md5
        $uint = hexdec($md5);
        $uniqid = sprintf('%010u', $uint);
        return \URL::to('captcha?' . $uniqid);
    }
}*/
