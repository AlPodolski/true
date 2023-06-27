<?php

/* @var $post array */
/* @var $postsByPhone \frontend\modules\user\models\Posts[] */
/* @var $viewPosts \frontend\modules\user\models\Posts[] */
/* @var $serviceList array */
/* @var $serviceListReview array */
/* @var $cityInfo array */
/* @var $this \yii\web\View */
/* @var $id integer */
/* @var $productShema string */
/* @var $phoneComments array */

/* @var $backUrl string */
/* @var $refererCategory string|null */

/* @var $first bool */

use kartik\icons\FontAwesomeAsset;
use frontend\assets\RateAsset;

$price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends' => ['yii\web\YiiAsset']]);

$title = 'Проститутка ' . $post['name'] . ' из ' . $cityInfo['city2'];

if (isset($post['metro'][0]['value'])) $title .= ' у метро ' . $post['metro'][0]['value'];

$title .= ' скрасит  твой  досуг  за ' . $post['price'] . ' руб/час ' . ' Анкета номер ' . $post['id'];

$this->title = $title;

$des = 'Индивидуалка ' . $post['name'];

if ($post['breast']) $des .= ' красавица c ' . $post['breast'] . ' размером груди ';

if ($post['service']) $des .= ' ,  нравится ' . $post['service'][0]['service']['value'];

if ($post['place']) {

    foreach ($post['place'] as $item) {

        if ($item['url'] == 'v-sayne') $des .= ' возможен выезд в сауну или баню ';
        if ($item['url'] == 'appartamentu') $des .= ' есть аппартаменты ';

    }

}

$des .= ' , остальная информация в анкете сексуальной проститутки.';


$des .= ' Анкета номер ' . $post['id'];


Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

echo \frontend\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://' . Yii::$app->params['site_addr'] . $post['avatar']['file'],
]);


$this->params['breadcrumbs'][] = array(
    'label' => $post['name'],
);

if ($productShema) echo $productShema;

?>

<div class="single">
    <div class="container">

        <?php echo $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
            'post' => $post,
            'cityInfo' => $cityInfo,
            'serviceListReview' => $serviceListReview,
            'viewPosts' => $viewPosts,
            'phoneComments' => $phoneComments,
            'first' => $first,
            'backUrl' => $backUrl,
            'refererCategory' => $refererCategory,
            'price' => $price
        ]); ?>

        <div class="profile__about-sim profile__about-block  profile__tab" id="profileServices">
            <ul class="profile__about-sim-tabs">
                <li class="profile__about-sim-tabs-item active" id="rec">
                    Рекомендации
                </li>
                <li class="profile__about-sim-tabs-item" id="view">
                    Просмотренные анкеты
                </li>
            </ul>
            <div class="profile__about-sim-items active row" id="rec">
                <div class="catalog__item catalog-item">
                    <div class="catalog-item__header" style="background-image: url(images/catalog-item.png)">
                        <img class="catalog-item__status" src="images/status_1.svg" alt="">
                        <div class="catalog-item__content">
                            <div class="catalog-item__content-top">
                                <div class="catalog-item__title">
                                    <div class="catalog-item__name">
                                        Марина, 23
                                    </div>
                                    <div class="catalog-item__icons">
                                        <img src="images/icons/verify.svg" alt="">
                                        <img src="images/icons/video.svg" alt="">
                                        <img src="images/icons/car.svg" alt="">
                                    </div>
                                </div>
                                <div class="catalog-item__rating">
                                    4.3
                                </div>
                            </div>
                            <div class="catalog-item__content-bottom">
                                <div class="catalog-item__address">
                                    м. Авиамоторная
                                </div>
                                <div class="catalog-item__price">
                                    1 500р/час
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-item__body">
                        <div class="catalog-item__characters catalog-item-characters">
                            <ul class="catalog-item-characters__list">
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        180
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        рост
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        50
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        вес
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        4
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        грудь
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="catalog-item__tags">
                            <ul class="catalog-item-tags__list">
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #с выездом
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-item__footer">
                        <div class="catalog-item__phone">
                                <span class="catalog-item-phone__text active">
                                    Показать номер
                                </span>
                            <span class="catalog-item-phone__phone">
                                    <a href="#">+7 (777) 777 77 77</a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="catalog__item catalog-item">
                    <div class="catalog-item__header" style="background-image: url(images/catalog-item.png)">
                        <img class="catalog-item__status" src="images/status_1.svg" alt="">
                        <div class="catalog-item__content">
                            <div class="catalog-item__content-top">
                                <div class="catalog-item__title">
                                    <div class="catalog-item__name">
                                        Марина, 23
                                    </div>
                                    <div class="catalog-item__icons">
                                        <img src="images/icons/verify.svg" alt="">
                                        <img src="images/icons/video.svg" alt="">
                                        <img src="images/icons/car.svg" alt="">
                                    </div>
                                </div>
                                <div class="catalog-item__rating">
                                    4.3
                                </div>
                            </div>
                            <div class="catalog-item__content-bottom">
                                <div class="catalog-item__address">
                                    м. Авиамоторная
                                </div>
                                <div class="catalog-item__price">
                                    1 500р/час
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-item__body">
                        <div class="catalog-item__characters catalog-item-characters">
                            <ul class="catalog-item-characters__list">
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        180
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        рост
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        50
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        вес
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        4
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        грудь
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="catalog-item__tags">
                            <ul class="catalog-item-tags__list">
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #с выездом
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-item__footer">
                        <div class="catalog-item__phone">
                                <span class="catalog-item-phone__text active">
                                    Показать номер
                                </span>
                            <span class="catalog-item-phone__phone">
                                    <a href="#">+7 (777) 777 77 77</a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="catalog__item catalog-item">
                    <div class="catalog-item__header" style="background-image: url(images/catalog-item.png)">
                        <img class="catalog-item__status" src="images/status_1.svg" alt="">
                        <div class="catalog-item__content">
                            <div class="catalog-item__content-top">
                                <div class="catalog-item__title">
                                    <div class="catalog-item__name">
                                        Марина, 23
                                    </div>
                                    <div class="catalog-item__icons">
                                        <img src="images/icons/verify.svg" alt="">
                                        <img src="images/icons/video.svg" alt="">
                                        <img src="images/icons/car.svg" alt="">
                                    </div>
                                </div>
                                <div class="catalog-item__rating">
                                    4.3
                                </div>
                            </div>
                            <div class="catalog-item__content-bottom">
                                <div class="catalog-item__address">
                                    м. Авиамоторная
                                </div>
                                <div class="catalog-item__price">
                                    1 500р/час
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-item__body">
                        <div class="catalog-item__characters catalog-item-characters">
                            <ul class="catalog-item-characters__list">
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        180
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        рост
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        50
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        вес
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        4
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        грудь
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="catalog-item__tags">
                            <ul class="catalog-item-tags__list">
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #с выездом
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-item__footer">
                        <div class="catalog-item__phone">
                                <span class="catalog-item-phone__text active">
                                    Показать номер
                                </span>
                            <span class="catalog-item-phone__phone">
                                    <a href="#">+7 (777) 777 77 77</a>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile__about-sim-items row" id="view">
                <div class="catalog__item catalog-item">
                    <div class="catalog-item__header" style="background-image: url(images/catalog-item.png)">
                        <img class="catalog-item__status" src="images/status_1.svg" alt="">
                        <div class="catalog-item__content">
                            <div class="catalog-item__content-top">
                                <div class="catalog-item__title">
                                    <div class="catalog-item__name">
                                        Марина, 23
                                    </div>
                                    <div class="catalog-item__icons">
                                        <img src="images/icons/verify.svg" alt="">
                                        <img src="images/icons/video.svg" alt="">
                                        <img src="images/icons/car.svg" alt="">
                                    </div>
                                </div>
                                <div class="catalog-item__rating">
                                    4.3
                                </div>
                            </div>
                            <div class="catalog-item__content-bottom">
                                <div class="catalog-item__address">
                                    м. Авиамоторная
                                </div>
                                <div class="catalog-item__price">
                                    1 500р/час
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-item__body">
                        <div class="catalog-item__characters catalog-item-characters">
                            <ul class="catalog-item-characters__list">
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        180
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        рост
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        50
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        вес
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        4
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        грудь
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="catalog-item__tags">
                            <ul class="catalog-item-tags__list">
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #с выездом
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-item__footer">
                        <div class="catalog-item__phone">
                                <span class="catalog-item-phone__text active">
                                    Показать номер
                                </span>
                            <span class="catalog-item-phone__phone">
                                    <a href="#">+7 (777) 777 77 77</a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="catalog__item catalog-item">
                    <div class="catalog-item__header" style="background-image: url(images/catalog-item.png)">
                        <img class="catalog-item__status" src="images/status_1.svg" alt="">
                        <div class="catalog-item__content">
                            <div class="catalog-item__content-top">
                                <div class="catalog-item__title">
                                    <div class="catalog-item__name">
                                        Марина, 23
                                    </div>
                                    <div class="catalog-item__icons">
                                        <img src="images/icons/verify.svg" alt="">
                                        <img src="images/icons/video.svg" alt="">
                                        <img src="images/icons/car.svg" alt="">
                                    </div>
                                </div>
                                <div class="catalog-item__rating">
                                    4.3
                                </div>
                            </div>
                            <div class="catalog-item__content-bottom">
                                <div class="catalog-item__address">
                                    м. Авиамоторная
                                </div>
                                <div class="catalog-item__price">
                                    1 500р/час
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-item__body">
                        <div class="catalog-item__characters catalog-item-characters">
                            <ul class="catalog-item-characters__list">
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        180
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        рост
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        50
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        вес
                                    </div>
                                </li>
                                <li class="catalog-item-characters__item">
                                    <div class="catalog-item-characters__cur">
                                        4
                                    </div>
                                    <div class="catalog-item-characters__name">
                                        грудь
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="catalog-item__tags">
                            <ul class="catalog-item-tags__list">
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #с выездом
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                                <li class="catalog-item-tags__item">
                                    <a href="#" class="catalog-item-tags__link">
                                        #блондинка
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-item__footer">
                        <div class="catalog-item__phone">
                                <span class="catalog-item-phone__text active">
                                    Показать номер
                                </span>
                            <span class="catalog-item-phone__phone">
                                    <a href="#">+7 (777) 777 77 77</a>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
