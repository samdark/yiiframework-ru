<?php
namespace common\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $sourcePath = '@common/assets/select2/';

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css',

    ];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.full.min.js',
        'app.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}