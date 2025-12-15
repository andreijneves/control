<?php

namespace app\modules\auth;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'app\\modules\\auth\\controllers';
    public $defaultRoute = 'auth/login';
}
