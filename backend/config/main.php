<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'backend\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => 'v1/user',
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => 'v1/client',
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'   => false,
                    'controller' => 'v1/vehicle',
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => ['v1/vehicle/type' => 'v1/vehicle-type'],
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => ['v1/vehicle/brand' => 'v1/vehicle-brand'],
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => 'v1/action-log',
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => 'v1/login',
                ],
                'POST,OPTIONS v1/login/check' => 'v1/login/check',
                [
                    'class'      => 'yii\rest\UrlRule',
                    'pluralize'  => false,
                    'controller' => 'v1/role',
                ],
            ],
        ],
    ],
    'params' => $params,
];
