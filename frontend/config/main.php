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
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
        'advert' => [
            'class' => 'frontend\modules\advert\advert',
        ],
        'chat' => [
            'class' => 'frontend\modules\chat\Chat',
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
                '1024' => [1024, 1024],
                '175_210' => [175, 210],
                '350_490' => [350, 490],
                '360_471' => [360, 471],
                '100_100' => [100, 100],
                '200' => [200, 200],
                '59' => [59, 59],
                '77' => [77, 77],
                '350_420' => [350, 420],
                '360_430' => [360, 430],
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'frontend\components\Vk',
                    'clientId' => '7741906',
                    'clientSecret' => '5O2GJBLcC1EG8D1BHT2m',
                ],
                // etc.
            ],
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
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cust' => 'site/cust',
                'thumbs/<path:.*>' => 'site/thumb',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/' => 'site/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/find' => 'find/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/page-<page:[0-9]+>' => 'site/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/favorite' => 'site/favorite',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/favorite/list' => 'site/list-favorite',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/post/<id:[0-9]+>' => 'post/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/post/more' => 'post/more',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/post/get' => 'post/get',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/city/search' => 'city/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/search/name' => 'search/name',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/review/add' => 'user/review/add',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/data/get' => 'data/get',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/auth' => 'site/auth',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/site/auth' => 'site/auth',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum/<id:[0-9]+>' => 'advert/advert/view',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum/add' => 'advert/advert/ad',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/forum' => 'advert/advert/list',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/more-forum' => 'advert/advert/more',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/comment' => 'comment/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/signup' => 'user/user/signup',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/login' => 'user/user/login',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/faq' => 'user/cabinet/faq',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet' => 'user/cabinet/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/post/add' => 'user/post/add',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/pay' => 'user/pay/obmenka-pay',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/pay' => 'site/pay',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/pay/obmenka/<id:[0-9]+>' => 'site/obmenka-pay',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/post/edit/<id:[0-9]+>' => 'user/post/edit',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/up/<id:[0-9]+>' => 'user/up/index',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/chat' => 'chat/chat/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/chat/get' => 'chat/chat/get',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/chat/send' => 'chat/chat/send',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/phone/get-info' => 'user/phone/get-info',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/phone/add-review' => 'user/phone/add-review',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/message/read' => 'user/message/read',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/edit' => 'user/profile/edit',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/events' => 'user/events/index',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/sitemap.xml' => 'site/map',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/robots.txt' => 'site/robot',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/view/phone' => 'user/view/view-phone',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/view/buy' => 'user/view/buy-view',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/claim/get-modal' => 'claim/get-modal',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/claim/add' => 'claim/add',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/claim/anket/add' => 'claim/claim-anket',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/site/verify-email' => 'user/user/verify-email',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/site/request-password-reset' => 'user/user/request-password-reset',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/site/reset-password' => 'user/user/reset-password',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/tele/index' => 'telegram/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/telegram' => 'user/telegram/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/cabinet/call' => 'user/call/index',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/call/add' => 'call/add',

                '<protocol>://<city:[a-z-0-9]+>.<domain>/<param:[a-z-0-9]+>' => 'filter/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/<param:([a-z-0-9]+/)+[a-z-0-9]+>' => 'filter/index',
                '<protocol>://<city:[a-z-0-9]+>.<domain>/<param:([a-z-0-9]+/)+[a-z-0-9]+>/page-<page:[0-9]+>' => 'filter/index',
            ],
        ],
    ],
    'params' => $params,
];
