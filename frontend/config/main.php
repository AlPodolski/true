<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
        'advert' => [
            'class' => 'frontend\modules\advert\advert',
        ],
    ],
    'components' => [
        'imageCache' => [
            'class' => 'iutbay\yii2imagecache\ImageCache',
            'sourcePath' => '@app/web/uploads',
            'sourceUrl' => '@web/uploads',
            'thumbsPath' => '@app/web/thumbs',
            'extensions' => [
                'jpg' => 'jpeg',
                'jpeg' => 'jpeg',
                'png' => 'png',
                'gif' => 'gif',
                'bmp' => 'bmp',
            ],
            'sizes' => [
                'single' => [375, 450],
                '175_210' => [175, 210],
                '200' => [200, 200],
                '59' => [59, 59],
                '77' => [77, 77],
                '350_420' => [350, 420],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                'thumbs/<path:.*>' => 'site/thumb',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/' => 'site/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/favorite' => 'site/favorite',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/post/<id:[0-9]+>' => 'post/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/city/search' => 'city/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/search/name' => 'search/name',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/review/add' => 'user/review/add',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum/<id:[0-9]+>' => 'advert/advert/view',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum/ad' => 'advert/advert/ad',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum' => 'advert/advert/list',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/more-forum' => 'advert/advert/more',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/comment' => 'comment/index',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/<param:[a-z-0-9]+>' => 'filter/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/<param:([a-z-0-9]+/)+[a-z-0-9]+>' => 'filter/index',
            ],
        ],
    ],
    'params' => $params,
];
