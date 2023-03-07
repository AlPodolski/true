<?php

/* @var $this \yii\web\View */

$links = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : Yii::$app->params['breadcrumbs'];

if ($links and isset($links[0]['label'])){

    $result = [
        '@context' => 'http://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [array(
            '@type' => 'ListItem',
            'position' => 1,
            'item' => [
                '@id' => 'https://' . Yii::$app->params['site_addr'],
                'name' => 'Главная'
            ]
        ),
            array(
                '@type' => 'ListItem',
                'position' => 2,
                'item' => [
                    '@id' => 'https://' . Yii::$app->params['site_addr'].Yii::$app->request->url,
                    'name' => $links[0]['label']
                ]
            )

        ]
    ];

    echo '<script type="application/ld+json">';

    echo json_encode($result);

    echo '</script>';

}

