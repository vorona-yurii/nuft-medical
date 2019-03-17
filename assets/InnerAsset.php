<?php

namespace app\assets;

use yii\web\AssetBundle;

class InnerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css?v=3',
        'font-awesome/css/font-awesome.css',
        'css/plugins/iCheck/custom.css?v=3',
        'css/animate.css',
        'css/sweetalert.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=cyrillic',
//        'css/summernote.css',
        'css/admin.css'
    ];
    public $js = [
        'js/sweetalert.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/inspinia.js?v=3',
        'js/plugins/iCheck/icheck.min.js',
//        'js/summernote.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',

    ];
}