<?php

namespace app\assets;

use yii\web\AssetBundle;

class InputMaskAsset extends AssetBundle
{
    public $sourcePath = '@bower/inputmask/dist';
    public $js = [
        'jquery.inputmask.bundle.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
