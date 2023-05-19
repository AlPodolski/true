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
        'chat' => [
            'class' => 'backend\modules\chat\Chat',
        ],
    ],
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
                '<protocol>://<city:[a-z-0-9]+>.<domain>/chat' => 'chat/chat/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/chat/get' => 'chat/chat/get',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/chat/send' => 'chat/chat/send',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/phones-chenge' => 'phone/edit',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/phones/get' => 'phone/get',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/api/post' => 'api/post',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/api/city' => 'api/city',
            ],
        ],

    ],
    'params' => $params,
];
