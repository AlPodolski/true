<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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

        <?php if ($link = \frontend\components\helpers\CanonicalHelper::getLink(Yii::$app->request->url)) : ?>
            <link rel="canonical" href="https://<?php echo Yii::$app->params['site_addr'] . $link ?>">
            <meta name="robots" content="noindex, follow">
        <?php endif; ?>

        <link rel="preload" as="font" href="/fonts/Rubik/Rubik-Regular.ttf" crossorigin>
        <link rel="preload" as="font" href="/fonts/Rubik/Rubik-Medium.ttf" crossorigin>
        <link rel="preload" as="font" href="/fonts/Rubik/Rubik-Light.ttf" crossorigin>

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/img/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="HandheldFriendly" content="True">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TEVW282QTC"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-TEVW282QTC');
        </script>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <div class="content">
            <header class="header">
                <div class="header__top">
                    <div class="container">
                        <div class="row">
                            <?php echo \frontend\widgets\CurrentCity::widget() ?>
                            <div class="header__col header__col--tags">
                                <ul class="header-tags">
                                    <li class="header-tags__item">
                                        <a href="/pol-muzhskoj" class="header-tags__link">Жигало </a>
                                    </li>
                                    <li class="header-tags__item">
                                        <a href="/proverennye" class="header-tags__link">Проверенные </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="header__col header__col--cab-menu">
                                <ul class="header-cab-menu">
                                    <li class="header-cab-menu__item">
                                        <a <?php if (Yii::$app->user->isGuest) : ?>
                                            href="#"
                                            onclick="get_user_menu()"
                                        <?php else : ?>
                                            href="/cabinet"
                                        <?php endif; ?>
                                                class="header-cab-menu__link">Кабинет</a>
                                    </li>
                                    <li class="header-cab-menu__item">
                                        <a onclick="get_claim_modal()" class="header-cab-menu__link">Обратная связь</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__bottom">
                    <div class="container">
                        <div class="row">
                            <div class="header__col header__col--logo">
                                <a href="/" class="header__logo">

                                    <?php

                                    $logoTitle = 'Проститутки';

                                    if (isset(Yii::$app->requestedParams['city'])) {

                                        $cityInfo = \common\models\City::getCity(Yii::$app->requestedParams['city']);

                                        $logoTitle = 'Проститутки ' . $cityInfo['city2'];

                                    }

                                    ?>

                                    <img src="/images/logo.svg" alt="<?php echo $logoTitle ?>">
                                </a>
                            </div>
                            <div class="header__col header__col--catalog">
                                <div class="header__catalog header-catalog">
                                    <div class="header-catalog__btn" data-params-btn>
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect width="7" height="7" fill="#EE3E84"/>
                                            <rect y="10" width="7" height="7" fill="#EE3E84"/>
                                            <rect y="21" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="11" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="11" y="10" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="11" y="21" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="21" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="21" y="10" width="7" height="7" fill="#EE3E84"/>
                                            <rect x="21" y="21" width="7" height="7" fill="#EE3E84"/>
                                        </svg>
                                        Каталог
                                    </div>
                                </div>
                            </div>

                            <?php echo \frontend\widgets\SearchFormWidget::widget() ?>

                            <div class="header__col header__col--cab">
                                <a
                                    <?php if (Yii::$app->user->isGuest) : ?>
                                        href="#"
                                        onclick="get_user_menu()"
                                    <?php else : ?>
                                        href="/cabinet"
                                    <?php endif; ?>
                                        class="header__cab header-cab">
                                    <svg width="35" height="34" viewBox="0 0 35 34" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M34.7876 31.6094C32.2294 27.1868 28.2872 24.0155 23.6865 22.5122C25.9622 21.1574 27.7303 19.0931 28.7192 16.6363C29.7082 14.1794 29.8633 11.4659 29.1607 8.91235C28.4582 6.35881 26.9369 4.10649 24.8304 2.50126C22.7239 0.896039 20.1487 0.0266724 17.5003 0.0266724C14.8518 0.0266724 12.2766 0.896039 10.1701 2.50126C8.06364 4.10649 6.5423 6.35881 5.83977 8.91235C5.13723 11.4659 5.29234 14.1794 6.28127 16.6363C7.2702 19.0931 9.03827 21.1574 11.314 22.5122C6.7133 24.0138 2.77108 27.1851 0.212913 31.6094C0.1191 31.7623 0.0568751 31.9325 0.0299087 32.1099C0.00294227 32.2873 0.0117808 32.4684 0.0559027 32.6423C0.100025 32.8162 0.178536 32.9796 0.286805 33.1227C0.395074 33.2658 0.530907 33.3857 0.68629 33.4755C0.841674 33.5652 1.01346 33.6229 1.19151 33.6452C1.36956 33.6675 1.55028 33.6539 1.72299 33.6052C1.8957 33.5565 2.05691 33.4738 2.19711 33.3618C2.3373 33.2498 2.45365 33.1108 2.53928 32.9531C5.70381 27.4841 11.2972 24.2187 17.5003 24.2187C23.7033 24.2187 29.2967 27.4841 32.4612 32.9531C32.5469 33.1108 32.6632 33.2498 32.8034 33.3618C32.9436 33.4738 33.1048 33.5565 33.2775 33.6052C33.4502 33.6539 33.631 33.6675 33.809 33.6452C33.9871 33.6229 34.1588 33.5652 34.3142 33.4755C34.4696 33.3857 34.6054 33.2658 34.7137 33.1227C34.822 32.9796 34.9005 32.8162 34.9446 32.6423C34.9887 32.4684 34.9976 32.2873 34.9706 32.1099C34.9436 31.9325 34.8814 31.7623 34.7876 31.6094ZM8.09401 12.125C8.09401 10.2646 8.64567 8.44601 9.67925 6.89916C10.7128 5.35231 12.1819 4.14669 13.9006 3.43475C15.6194 2.72281 17.5107 2.53654 19.3353 2.89948C21.16 3.26242 22.836 4.15828 24.1515 5.47377C25.467 6.78926 26.3628 8.46529 26.7258 10.2899C27.0887 12.1146 26.9024 14.0058 26.1905 15.7246C25.4786 17.4434 24.2729 18.9124 22.7261 19.946C21.1792 20.9796 19.3606 21.5312 17.5003 21.5312C15.0064 21.5286 12.6154 20.5367 10.852 18.7733C9.08854 17.0098 8.09667 14.6189 8.09401 12.125Z"
                                                fill="white"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="filter">
                <div class="container">

                    <?php echo \frontend\widgets\MegaMenuWidget::widget([
                        'city' => Yii::$app->requestedParams['city']
                    ]) ?>

                    <?php if (Yii::$app->controller->id == 'filter') echo \frontend\widgets\LinkWidget::widget(['url' => Yii::$app->request->url]) ?>

                </div>
            </div>
            <main>
                <?php echo \frontend\widgets\Alert::widget() ?>
                <?= $content ?>
            </main>
        </div>

    </div>

    <div class="claim__modal-bg modal">

    </div>

    <div class="login">
        <div class="login-icon-close ">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(.clip0)">
                    <path d="M32 3.77081L28.2292 0L16 12.2291L3.77081 0L0 3.77081L12.2291 16L0 28.2292L3.77081 32L16 19.7709L28.2291 32L31.9999 28.2292L19.7709 16L32 3.77081Z"
                          fill="white"/>
                </g>
                <defs>
                    <clipPath class="clip0">
                        <rect width="32" height="32" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div class="color-boll first-color-boll">

        </div>
        <div class="color-boll second-color-boll">

        </div>
        <div class="color-boll color-boll-3">

        </div>
        <div class="color-boll color-boll-4">

        </div>
        <div class="color-boll color-boll-5">
        </div>
        <div class="color-boll color-boll-6">
        </div>
        <div class="color-boll color-boll-7">
        </div>
        <div class="login-form-wrap">
            <?php

            echo (new frontend\widgets\LoginWidget)->run();

            ?>
        </div>
    </div>
    <div class="register">
        <div class="register-icon-close">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(.clip0)">
                    <path d="M32 3.77081L28.2292 0L16 12.2291L3.77081 0L0 3.77081L12.2291 16L0 28.2292L3.77081 32L16 19.7709L28.2291 32L31.9999 28.2292L19.7709 16L32 3.77081Z"
                          fill="white"/>
                </g>
                <defs>
                    <clipPath class="clip0">
                        <rect width="32" height="32" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div class="color-boll first-color-boll">

        </div>
        <div class="color-boll second-color-boll">

        </div>
        <div class="color-boll color-boll-3">

        </div>
        <div class="color-boll color-boll-4">

        </div>
        <div class="color-boll color-boll-5">
        </div>
        <div class="color-boll color-boll-6">
        </div>
        <div class="color-boll color-boll-7">
        </div>
        <div class="login-form-wrap">
            <?php

            echo (new frontend\widgets\RegisterWidget)->run();

            ?>
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
    <!-- /Yandex.Metrika counter -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TEVW282QTC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-TEVW282QTC');
    </script>
    </body>

    </html>
<?php $this->endPage() ?>