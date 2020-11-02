<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <div class="container">
        <div class="d-flex top-header">
            <div class="city">
                <svg width="8" height="12" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.00001 0C1.34584 0 0 1.19473 0 2.66318C0 3.104 0.124154 3.54109 0.360176 3.92877L2.83595 7.90369C2.86891 7.95668 2.93172 7.98951 3.00001 7.98951C3.0683 7.98951 3.13111 7.95668 3.16407 7.90369L5.64076 3.92745C5.87587 3.54109 6.00002 3.10399 6.00002 2.66316C6.00002 1.19473 4.65418 0 3.00001 0ZM3.00001 3.99476C2.17292 3.99476 1.50001 3.3974 1.50001 2.66318C1.50001 1.92895 2.17292 1.3316 3.00001 1.3316C3.8271 1.3316 4.50001 1.92895 4.50001 2.66318C4.50001 3.3974 3.8271 3.99476 3.00001 3.99476Z" fill="#F74952"/>
                </svg>
                <span class="city-name" data-toggle="modal" data-target="#cityModal">
                    <?php echo \frontend\widgets\CurrentCity::widget() ?>
                </span>
            </div>
            <div class="logo">
                <a href="/">
                    <img src="/img/SexTrue.png" alt="">
                </a>
            </div>
            <div class="user-btn-mobil-menu-wrap">
                    <span class="user-btn">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 10.1387C3.59167 10.1387 0.613125 12.6972 0.613125 17.3431C0.613125 17.7059 0.907207 18 1.27005 18H16.7299C17.0928 18 17.3868 17.7059 17.3868 17.3431C17.3869 12.6974 14.4083 10.1387 9 10.1387ZM1.95089 16.6861C2.20929 13.2125 4.57752 11.4526 9 11.4526C13.4225 11.4526 15.7907 13.2125 16.0494 16.6861H1.95089Z" fill="#5C5C5C"/>
                        <path d="M9 0C6.51569 0 4.64235 1.91102 4.64235 4.44505C4.64235 7.05329 6.59718 9.17497 9 9.17497C11.4028 9.17497 13.3577 7.05329 13.3577 4.44526C13.3577 1.91102 11.4843 0 9 0ZM9 7.86132C7.32154 7.86132 5.95621 6.3289 5.95621 4.44526C5.95621 2.63081 7.23635 1.31386 9 1.31386C10.7354 1.31386 12.0438 2.65992 12.0438 4.44526C12.0438 6.3289 10.6785 7.86132 9 7.86132Z" fill="#5C5C5C"/>
                    </svg>
                    </span>
                <div class="login">
                    <div class="login-icon-close ">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M32 3.77081L28.2292 0L16 12.2291L3.77081 0L0 3.77081L12.2291 16L0 28.2292L3.77081 32L16 19.7709L28.2291 32L31.9999 28.2292L19.7709 16L32 3.77081Z" fill="white"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
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
                        <form action="" class="login-form">
                            <div class="login-text">Войти</div>
                            <input type="text" name="email" placeholder="Email" class="form-input email-input">
                            <input type="password" name="pass" placeholder="Пароль" class="form-input pass-input">
                            <div class="checbox">
                                <input type="checkbox" name="remember-me" id="remember-me" class="custom-checkbox">
                                <label for="remember-me">Запомнить меня</label>
                            </div>
                            <div class="login-register-btns">
                                <input type="submit" class="in-btn" value="Войти">
                                <a href="#" class="register-btn">Регистрация</a>
                            </div>
                            <div class="reset-pass-block">
                                <p class="reset-text">
                                    Забыли пароль <a href="#">Сбросить</a>
                                </p>
                                <p class="reset-text">
                                    Отправить письмо еще раз <a href="#">Отправить</a>
                                </p>
                            </div>
                            <div class="in-with-text">
                                Войти с помощью:
                            </div>
                            <div class="vk-icon">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path d="M15.1813 24.375C19.5212 24.375 17.9738 21.6275 18.3088 20.8375C18.3038 20.2475 18.2987 19.68 18.3188 19.335C18.5938 19.4125 19.2425 19.7412 20.5825 21.0437C22.6512 23.1312 23.18 24.375 24.8512 24.375H27.9275C28.9025 24.375 29.41 23.9713 29.6638 23.6325C29.9088 23.305 30.1488 22.73 29.8862 21.835C29.2 19.68 25.1975 15.9587 24.9487 15.5662C24.9862 15.4937 25.0462 15.3975 25.0775 15.3475H25.075C25.865 14.3038 28.88 9.78625 29.3237 7.97875C29.325 7.97625 29.3263 7.9725 29.3263 7.96875C29.5662 7.14375 29.3463 6.60875 29.1187 6.30625C28.7763 5.85375 28.2313 5.625 27.495 5.625H24.4188C23.3888 5.625 22.6075 6.14375 22.2125 7.09C21.5513 8.77125 19.6938 12.2288 18.3013 13.4525C18.2587 11.7188 18.2875 10.395 18.31 9.41125C18.355 7.4925 18.5 5.625 16.5087 5.625H11.6737C10.4262 5.625 9.2325 6.9875 10.525 8.605C11.655 10.0225 10.9312 10.8125 11.175 14.745C10.225 13.7262 8.535 10.975 7.34 7.45875C7.005 6.5075 6.4975 5.62625 5.06875 5.62625H1.9925C0.745 5.62625 0 6.30625 0 7.445C0 10.0025 5.66125 24.375 15.1813 24.375ZM5.06875 7.50125C5.34 7.50125 5.3675 7.50125 5.56875 8.0725C6.7925 11.6762 9.5375 17.0088 11.5425 17.0088C13.0487 17.0088 13.0487 15.465 13.0487 14.8837L13.0475 10.2562C12.965 8.725 12.4075 7.9625 12.0413 7.5L16.4263 7.505C16.4287 7.52625 16.4013 12.6237 16.4387 13.8587C16.4387 15.6125 17.8312 16.6175 20.005 14.4175C22.2987 11.8288 23.885 7.95875 23.9487 7.80125C24.0425 7.57625 24.1238 7.5 24.4188 7.5H27.495H27.5075C27.5063 7.50375 27.5063 7.5075 27.505 7.51125C27.2237 8.82375 24.4475 13.0063 23.5188 14.305C23.5037 14.325 23.49 14.3463 23.4762 14.3675C23.0675 15.035 22.735 15.7725 23.5325 16.81H23.5337C23.6062 16.8975 23.795 17.1025 24.07 17.3875C24.925 18.27 27.8575 21.2875 28.1175 22.4875C27.945 22.515 27.7575 22.495 24.8512 22.5012C24.2325 22.5012 23.7487 21.5763 21.9025 19.7137C20.2425 18.0988 19.165 17.4388 18.1838 17.4388C16.2787 17.4388 16.4175 18.985 16.435 20.855C16.4412 22.8825 16.4288 22.2413 16.4425 22.3688C16.3313 22.4125 16.0125 22.5 15.1813 22.5C7.25 22.5 2.085 9.91125 1.88625 7.505C1.955 7.49875 2.90125 7.5025 5.06875 7.50125Z" fill="white"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="30" height="30" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="mobil-menu">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 14.4444H0V16.6667H20V14.4444Z" fill="#F74952"/>
                        <path d="M20 8.88892H0V11.1112H20V8.88892Z" fill="#F74952"/>
                        <path d="M20 3.33334H0V5.55558H20V3.33334Z" fill="#F74952"/>
                    </svg>
                </div>
                <div class="menu">
                    <div class="icon-close">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M32 3.77081L28.2292 0L16 12.2291L3.77081 0L0 3.77081L12.2291 16L0 28.2292L3.77081 32L16 19.7709L28.2291 32L31.9999 28.2292L19.7709 16L32 3.77081Z" fill="#F74952"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="32" height="32" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <ul class="nav">
                        <li class="nav-item" ><a href="#">Индивидуалки</a></li>
                        <li class="nav-item" ><a href="#">Проверенные</a></li>
                        <li class="nav-item" ><a href="#">Элитные</a></li>
                        <li class="nav-item" ><a href="#">Форум</a></li>
                    </ul>
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="search-wrap position-relative">
                    <input type="text" class="search">
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.8962 15.8946L11.9579 10.9563C12.8945 9.79989 13.4583 8.32978 13.4583 6.72919C13.4583 3.01873 10.4396 0 6.72916 0C3.0187 0 0 3.01873 0 6.72919C0 10.4396 3.01873 13.4584 6.72919 13.4584C8.32978 13.4584 9.79989 12.8945 10.9563 11.9579L15.8946 16.8963C16.033 17.0346 16.2572 17.0346 16.3955 16.8963L16.8963 16.3955C17.0346 16.2572 17.0346 16.0329 16.8962 15.8946ZM6.72919 12.0417C3.79971 12.0417 1.41668 9.65868 1.41668 6.72919C1.41668 3.79971 3.79971 1.41668 6.72919 1.41668C9.65868 1.41668 12.0417 3.79971 12.0417 6.72919C12.0417 9.65868 9.65868 12.0417 6.72919 12.0417Z" fill="#F74952"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="wrap">

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

</div>

<footer class="footer">
    <div class="container">

    </div>
</footer>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-close-wrap">
                <svg data-dismiss="modal" aria-label="Close" width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.0282 4.97991C22.399 -1.64923 11.6092 -1.64923 4.98005 4.97991C1.76888 8.19234 0 12.4625 0 17.0039C0 21.5454 1.76888 25.8155 4.98005 29.0267C8.29529 32.3419 12.6497 33.9989 17.0041 33.9989C21.3585 33.9989 25.713 32.3419 29.0281 29.0267C35.6573 22.3976 35.6573 11.6103 29.0282 4.97991ZM27.1657 27.1643C21.5627 32.7673 12.4455 32.7673 6.84243 27.1643C4.12918 24.451 2.63423 20.8421 2.63423 17.0039C2.63423 13.1658 4.12918 9.55687 6.84243 6.84229C12.4455 1.23921 21.5627 1.24054 27.1657 6.84229C32.7675 12.4454 32.7675 21.5625 27.1657 27.1643Z" fill="#F74952"/>
                    <path d="M22.6797 20.6411L18.9509 16.9176L22.6797 13.1941C23.1933 12.6804 23.1933 11.8467 22.681 11.3316C22.166 10.8153 21.3323 10.8166 20.8173 11.3303L17.0859 15.0564L13.3545 11.3303C12.8395 10.8166 12.0058 10.8153 11.4908 11.3316C10.9771 11.8466 10.9771 12.6803 11.4921 13.1941L15.2209 16.9176L11.4921 20.6411C10.9771 21.1547 10.9771 21.9885 11.4908 22.5035C11.7477 22.7616 12.0861 22.8894 12.4233 22.8894C12.7606 22.8894 13.0977 22.7603 13.3546 22.5048L17.086 18.7786L20.8174 22.5048C21.0742 22.7616 21.4114 22.8894 21.7486 22.8894C22.0858 22.8894 22.4243 22.7603 22.6811 22.5035C23.1947 21.9885 23.1947 21.1547 22.6797 20.6411Z" fill="#F74952"/>
                </svg>
            </div>

            <h5 class="modal-title" id="exampleModalLabel">Добавить отзыв</h5>
            <div class="modal-body ">
                <div class="grey-text">
                    Оцените по 5 балльной шкале качество выполненной работы и оставить отзыв.
                </div>
                <div class="row review-modal-body">
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Фото</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Сервис</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Общая</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Секс классический</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Минет без резинки</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Окончание в рот</div>
                            <div class="col-6">тут звездочки</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <textarea name="" placeholder="Комментарий" class="review-textarea"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="send-btn-wrap">
                            <span class="orange-btn">Опубликовать</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-close-wrap">
                <svg data-dismiss="modal" aria-label="Close" width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.0282 4.97991C22.399 -1.64923 11.6092 -1.64923 4.98005 4.97991C1.76888 8.19234 0 12.4625 0 17.0039C0 21.5454 1.76888 25.8155 4.98005 29.0267C8.29529 32.3419 12.6497 33.9989 17.0041 33.9989C21.3585 33.9989 25.713 32.3419 29.0281 29.0267C35.6573 22.3976 35.6573 11.6103 29.0282 4.97991ZM27.1657 27.1643C21.5627 32.7673 12.4455 32.7673 6.84243 27.1643C4.12918 24.451 2.63423 20.8421 2.63423 17.0039C2.63423 13.1658 4.12918 9.55687 6.84243 6.84229C12.4455 1.23921 21.5627 1.24054 27.1657 6.84229C32.7675 12.4454 32.7675 21.5625 27.1657 27.1643Z" fill="#F74952"/>
                    <path d="M22.6797 20.6411L18.9509 16.9176L22.6797 13.1941C23.1933 12.6804 23.1933 11.8467 22.681 11.3316C22.166 10.8153 21.3323 10.8166 20.8173 11.3303L17.0859 15.0564L13.3545 11.3303C12.8395 10.8166 12.0058 10.8153 11.4908 11.3316C10.9771 11.8466 10.9771 12.6803 11.4921 13.1941L15.2209 16.9176L11.4921 20.6411C10.9771 21.1547 10.9771 21.9885 11.4908 22.5035C11.7477 22.7616 12.0861 22.8894 12.4233 22.8894C12.7606 22.8894 13.0977 22.7603 13.3546 22.5048L17.086 18.7786L20.8174 22.5048C21.0742 22.7616 21.4114 22.8894 21.7486 22.8894C22.0858 22.8894 22.4243 22.7603 22.6811 22.5035C23.1947 21.9885 23.1947 21.1547 22.6797 20.6411Z" fill="#F74952"/>
                </svg>
            </div>

            <h5 class="modal-title" id="exampleModalLabel">Выбрать город</h5>
            <div class="modal-body ">
                <input type="text" name="city" class="form-control city-search" placeholder="Ввидите название города:">

                <div class="city-wrap">
                    <ul class="city-list">
                        <li><a class="red-link" href="https://msk.sex-true.com">Москва</a></li>
                        <li><a class="red-link" href="https://sankt-piterburg.sex-true.com">Санкт-Петербург</a></li>
                        <li><a class="red-link" href="https://novosibirsk.sex-true.com">Новосибирск</a></li>
                        <li><a class="red-link" href="https://ekaterinburg.sex-true.com">Екатеринбург</a></li>
                        <li><a class="red-link" href="https://nizhniy-novgorod.sex-true.com">Нижний Новгород</a></li>
                        <li><a class="red-link" href="https://kazan.sex-true.com">Казань</a></li>
                        <li><a class="red-link" href="https://chelyabinsk.sex-true.com">Челябинск</a></li>
                        <li><a class="red-link" href="https://omsk.sex-true.com">Омск</a></li>
                        <li><a class="red-link" href="https://samara.sex-true.com">Самара</a></li>
                        <li><a class="red-link" href="https://rostov-na-dony.sex-true.com">Ростов-на-Дону</a></li>
                        <li><a class="red-link" href="https://ufa.sex-true.com">Уфа</a></li>
                        <li><a class="red-link" href="https://voronezh.sex-true.com">Воронеж</a></li>
                        <li><a class="red-link" href="https://perm.sex-true.com">Пермь</a></li>
                        <li><a class="red-link" href="https://volgograd.sex-true.com">Волгоград</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
