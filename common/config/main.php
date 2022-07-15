<?php
return [
    'name'=>'sex-true',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'pay' => [
            'class' => 'common\components\service\PayService'
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'imageCache' => [
            'class' => 'frontend\components\service\image\ImageCache',
            'sourcePath' => '@frontend/web/uploads',
            'sourceUrl' => '@web/uploads',
            'thumbsPath' => '@frontend/web/thumbs',
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
                '500_700' => [500, 700],
                '175_210' => [175, 210],
                '350_490' => [350, 490],
                '360_471' => [360, 471],
                '100_100' => [100, 100],
                '200' => [200, 200],
                '59' => [59, 59],
                '77' => [77, 77],
                '350_420' => [350, 420],
                '360_430' => [360, 430],
                '390_460' => [390, 460],
                '129' => [129, 129],
            ],
            'text' => [
                'text' => 'sex-true',
                'fontFile' => '@frontend/web/fonts/MullerExtraBold.ttf'
            ],
        ],
    ],
    'bootstrap' => [
        'queue', // Компонент регистрирует свои консольные команды
    ],
];
