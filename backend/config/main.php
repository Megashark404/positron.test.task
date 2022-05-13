<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Positron Test Task (Админка)',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
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
            'showScriptName' => false,
            'rules' => [
                'video/update/<video_id>' => 'video/update',
                'book/update/<isbn>' => 'book/update',
                'book/view/<isbn>' => 'book/view',
                'book/delete/<isbn>' => 'book/delete',
                'book/set-category/<isbn>' => 'book/set-category',
                'category/update/<id>' => 'category/update',
                'category/view/<id>' => 'category/view',
                'category/delete/<id>' => 'category/delete',                
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ]
        
    ],
    'params' => $params,
];
