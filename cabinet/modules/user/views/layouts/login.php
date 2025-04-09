<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use cabinet\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="apple-touch-icon" sizes="76x76" href="/img/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
        <link rel="manifest" href="/img/favicons/site.webmanifest">
        <link rel="mask-icon" href="/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <?php if ($link = \cabinet\components\helpers\CanonicalHelper::getLink(Yii::$app->request->url)) : ?>
            <link rel="canonical" href="https://<?php echo $_SERVER['HTTP_HOST'] . $link ?>">
            <meta name="robots" content="noindex, follow">
        <?php endif; ?>

        <link rel="preload" as="font" href="/fonts/Rubik/Rubik.woff2" crossorigin>
        <link rel="preload" as="font" href="/fonts/Rubik/Rubikmedium.woff2" crossorigin>
        <link rel="preload" as="font" href="/fonts/Rubik/Rubiklight.woff2" crossorigin>

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/img/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="HandheldFriendly" content="True">
    </head>
    <body>
    <?php $this->beginBody() ?>
    <header>
        <div class="row">
            <div class="container">
                <div class="col-12">
                    <div class="logo"><img src="/images/logo.svg" alt="Проститутки Москвы"></div>
                </div>
            </div>
        </div>
    </header>
    <div class="wrapper">
        <div class="content">
            <main>
                <?php echo \cabinet\widgets\Alert::widget() ?>
                <?= $content ?>
            </main>
        </div>

    </div>

    <?php $this->endBody() ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(70919698, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>

    </noscript>
    </body>

    </html>
<?php $this->endPage() ?>