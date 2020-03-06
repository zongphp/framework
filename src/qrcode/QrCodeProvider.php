<?php

namespace zongphp\qrcode;

use zongphp\framework\build\Provider;

class QrCodeProvider extends Provider
{
    //延迟加载
    public $defer = true;

    public function register()
    {
        $this->app->single(
            'QrCode',
            function () {
                return QrCode::single();
            }
        );
    }
}