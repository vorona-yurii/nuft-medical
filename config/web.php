<?php
$params = require __DIR__ . '/params.php';
( new \Dotenv\Dotenv( __DIR__ . '/..' ) )->load();
$db = require __DIR__ . '/db.php';

$config = [
    'id'               => 'basic',
    'basePath'         => dirname( __DIR__ ),
    'bootstrap'        => [ 'log' ],
    'name'             => 'Nuft Medical',
    'language'         => 'ru',
    'aliases'          => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components'       => [
        'assetManager' => [
            'class'   => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset'                => [
                    'js' => [
                        'jquery.min.js',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset'       => [
                    'css' => [
                        'css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js',
                    ],
                ],
            ],
        ],
        'request'      => [
            'baseurl'             => '',
            'cookieValidationKey' => 'Bmesdfsdfsdfsdf8Pl1kCb5N_8eBbhK8sdfsdasfWSjKIZMCFRP7',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => [ 'user/login' ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [ 'error', 'warning' ],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'showScriptName'  => false,
            'enablePrettyUrl' => true,
            'rules'           => [
                'login'                   => 'user/login',
                'logout'                  => 'user/logout',

                 /***************** employee ******************/
                'employee'                => 'employee/list',
                'employee/list'           => 'employee/list',
                'employee/delete'         => 'employee/delete',
                'employee/<action>/<id>'  => 'employee/change',
                'employee/<action>'       => 'employee/change',

                /***************** department ******************/
                'department'                => 'department/list',
                'department/list'           => 'department/list',
                'department/delete'         => 'department/delete',
                'department/<action>/<id>'  => 'department/change',
                'department/<action>'       => 'department/change',

                /***************** profession ******************/
                'profession'                => 'profession/list',
                'profession/list'           => 'profession/list',
                'profession/delete'         => 'profession/delete',
                'profession/<action>/<id>'  => 'profession/change',
                'profession/<action>'       => 'profession/change',

                /***************** position ******************/
                'position'                => 'position/list',
                'position/list'           => 'position/list',
                'position/delete'         => 'position/delete',
                'position/<action>/<id>'  => 'position/change',
                'position/<action>'       => 'position/change',

                /*************** doctor *****************/
                'doctor'                => 'doctor/list',
                'doctor/list'           => 'doctor/list',
                'doctor/delete'         => 'doctor/delete',
                'doctor/<action>/<id>'  => 'doctor/change',
                'doctor/<action>'       => 'doctor/change',

                /***************** analysis ******************/
                'analysis'                => 'analysis/list',
                'analysis/list'           => 'analysis/list',
                'analysis/delete'         => 'analysis/delete',
                'analysis/<action>/<id>'  => 'analysis/change',
                'analysis/<action>'       => 'analysis/change',

                 /***************** report ******************/
                'report/employee-medical-card/download'     => 'report/employee-medical-card-download',
                'report/employee-medical-referral/download' => 'report/employee-medical-referral-download',
                'report/3'      => 'report/medical-examination-schedule-download',
                'report/4'      => 'report/medical-examination-workers-list-download',
                'report/5'      => 'report/workers-categories-act-download',

                '<controller>/<action>'   => '<controller>/<action>',
            ],
    ],

    ],
    'params'           => $params,
];

if ( YII_ENV_DEV && !getenv( 'YII_PROD' ) ) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
