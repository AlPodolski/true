<?php

/* @var $post array */
/* @var $cityInfo array */
/* @var $price array */
/* @var $this \yii\web\View */

/* @var $serviceListReview array */
/* @var $serviceList \common\models\Service[] */

/* @var $phoneComments array */

/* @var $first bool|null */

use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use frontend\widgets\PhotoWidget;
use frontend\helpers\LikeHelper;
use yii\helpers\Html;

$postReviewForm = new ReviewForm();
$serviceReviewFormForm = new ServiceReviewForm();

$strizhkaList = $post['strizhka'];
$cvetList = $post['cvet'];
$nacionalnostList = $post['nacionalnost'];
$rayonList = $post['rayon'];
$placeList = $post['place'];
$servicePostList = $post['service'];

$countReview = \frontend\modules\user\models\Posts::countReview($post['id']);

$photoTitle = 'Проститутка ' . $post['name'];

if ($post['check_photo_status']) $photoTitle = 'Проверенная проститутка ' . $post['name'];

?>

<div class="single__block single-block single-block__about single-block-about">
    <div class="row adaptive"></div>
    <div class="row single-block-about__row">
        <div class="single-block-about__media">
            <div class="single-block-about__slider">
                <div class="single-block-about__slider-item">

                    <?php echo PhotoWidget::widget([
                        'path' => $post['avatar']['file'],
                        'size' => '1024',
                        'width' => true,
                        'showPictureHref' => true,
                        'pictureOptions' => [
                            'class' => 'active carousel-item'
                        ],
                        'options' => [
                            'class' => 'img user-img card_img',
                            'alt' => $post['name'],
                            'title' => $photoTitle,
                        ],
                    ]); ?>

                </div>


                <?php foreach ($post['gal'] as $item) : ?>

                    <div class="single-block-about__slider-item">

                        <?php if ($item['type'] != \frontend\models\Files::SELPHY_TYPE) : ?>

                            <?php $i++; ?>

                            <?php echo PhotoWidget::widget([
                                'path' => $item['file'],
                                'size' => '1024',
                                'width' => true,
                                'showPictureHref' => true,
                                'pictureOptions' => [
                                    'class' => ' carousel-item'
                                ],
                                'options' => [
                                    'class' => 'img user-img',
                                    'loading' => 'lazy',
                                    'alt' => $post['name'],
                                    'title' => $photoTitle,
                                ],
                            ]); ?>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>
            <div class="single-block-about__video single-block-about-video">
                <?php if ($post['video']) : ?>
                    <video controls="controls" class="video">
                        <source src="<?php echo $post['video'] ?>">
                    </video>
                <?php endif; ?>
            </div>
        </div>
        <div class="single-block-about__info">
            <div class="row single-block-about__row-title">
                <div class="single-block-about__title">
                                <span class="single-block-about__name">
                                    <?php echo $post['name'] ?>, <?php echo $post['age'] ?>
                                </span>
                    <ul class="single-block-about__icons">

                        <?php if ($post['check_photo_status']) : ?>
                            <li><img src="/images/icons/verify.svg" alt=""></li>
                        <?php endif; ?>

                        <?php if ($post['video']) : ?>
                            <li><img src="/images/icons/video.svg" alt=""></li>
                        <?php endif; ?>

                        <?php if ($post['place']) : ?>

                            <?php foreach ($post['place'] as $placeItem) : ?>

                                <?php if ($placeItem['id'] == 2) : ?>
                                    <li><img src="/images/icons/car.svg" alt=""></li>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </ul>
                </div>
                <div class="single-block-about__price">
                    <?php echo $post['price'] ?> р/час
                </div>
            </div>
            <div class="row">
                <ul class="single-block-about__list single-block-about-list">
                    <li class="single-block-about-list__item">

                        <?php $targetPrice = \frontend\components\helpers\PriceTargetHelper::target($post['price']) ?>

                        <?php if ($post['phone']) : ?>

                            <div data-id="<?php echo $post['id'] ?>"
                                 data-city="<?php echo $post['city_id'] ?>"
                                 data-price="<?php echo $post['price'] ?>"
                                 data-age="<?php echo $post['age'] ?>"
                                 data-rayon="<?php echo $post['rayon'][0]['id'] ?>"

                                <?php $targetPrice = \frontend\components\helpers\PriceTargetHelper::target($post['price']) ?>
                                 onclick="getPhone(this);ym(70919698,'reachGoal','call'); <?php if ($post['partnerId']) : ?>
                                         ym(70919698,'reachGoal','<?php echo $post['partnerId']['partner_id'] ?>');  <?php endif; ?>
                                 <?php echo $targetPrice ?>"
                                 class="single-price cursor-pointer single-phone">
                                Показать номер
                            </div>

                        <?php endif; ?>

                    </li>
                    <?php if ($post['metro']) : ?>
                        <li class="single-block-about-list__item">
                            <div class="single-block-about-list__name">
                                Метро:
                            </div>
                            <div class="single-block-about-list__cur single-block-about__metro">

                                <?php foreach ($post['metro'] as $metroItem) : ?>

                                    <a href="/metro-<?php echo $metroItem['url'] ?>">м. <?php echo $metroItem['value'] ?></a>

                                    <?php
                                    if (last($post['metro']) != $metroItem) echo ',';
                                    ?>

                                <?php endforeach; ?>

                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="single-block-about-list__item single-block-about-list__item--params">
                        <div class="single-block-about-list__name">
                            Параметры:
                        </div>
                        <div class="single-block-about-list__cur">
                            <ul class="single-block-about__params single-block-about-params">
                                <li class="single-block-about-params__item">
                                    <div class="single-block-about-params__cur"><?php echo $post['rost'] ?? '∞' ?></div>
                                    <div class="single-block-about-params__name">рост</div>
                                </li>
                                <li class="single-block-about-params__item">
                                    <div class="single-block-about-params__cur"><?php echo $post['ves'] ?? '∞' ?></div>
                                    <div class="single-block-about-params__name">вес</div>
                                </li>
                                <li class="single-block-about-params__item">
                                    <div class="single-block-about-params__cur"><?php echo $post['breast'] ?? '∞' ?></div>
                                    <div class="single-block-about-params__name">грудь</div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="single-block-about-list__item">
                        <div class="single-block-about-list__name">
                            Доп. параметры:
                        </div>
                        <div class="single-block-about-list__cur">
                            <div class="single-block-about__tags single-block-about-tags tags">
                                <ul class="single-block-about-tags__list tags__list">

                                    <?php if ($post['place']) : ?>

                                        <?php foreach ($post['place'] as $item) : ?>

                                            <li class="single-block-about-tags__item tags__item">
                                                <a href="/mesto-<?php echo $item['url'] ?>"
                                                   class="single-block-about-tags__link tags__link">#<?php echo $item['value'] ?></a>
                                            </li>

                                        <?php endforeach; ?>


                                    <?php endif; ?>

                                    <?php if ($post['strizhka']) : ?>

                                        <?php foreach ($post['strizhka'] as $item) : ?>

                                            <li class="single-block-about-tags__item tags__item">
                                                <a href="/intimnaya-strizhka-<?php echo $item['url'] ?>"
                                                   class="single-block-about-tags__link tags__link">#<?php echo $item['value'] ?></a>
                                            </li>

                                        <?php endforeach; ?>

                                    <?php endif; ?>


                                    <?php if ($post['rayon']) : ?>

                                        <?php $rayon = $post['rayon']; ?>

                                        <?php foreach ($rayon as $item) : ?>

                                            <li class="single-block-about-tags__item tags__item">
                                                <a href="/rayon-<?php echo $item['url'] ?>"
                                                   class="single-block-about-tags__link tags__link">#<?php echo $item['value'] ?></a>
                                            </li>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                    <?php if ($post['nacionalnost']) : ?>

                                        <?php foreach ($post['nacionalnost'] as $item) : ?>
                                            <li class="single-block-about-tags__item tags__item">
                                                <a href="/nacionalnost-<?php echo $item['url'] ?>"
                                                   class="single-block-about-tags__link tags__link">#<?php echo $item['value'] ?></a>
                                            </li>
                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                    <?php if ($post['cvet']) : ?>

                                        <?php foreach ($post['cvet'] as $item) : ?>
                                            <li class="single-block-about-tags__item tags__item">
                                                <a href="/cvet-volos-<?php echo $item['url'] ?>"
                                                   class="single-block-about-tags__link tags__link">#<?php echo $item['value'] ?></a>
                                            </li>
                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="single-block-about-list__item single-block-about-list__item--descr">
                        <div class="single-block-about-list__name">
                            Описание:
                        </div>
                        <div class="single-block-about-list__cur single-block-about__descr">
                            <?php echo $post['about'] ?>
                        </div>
                    </li>
                </ul>

                <div class="single-block-about__status tarif_<?php echo $post['tarif_id'] ?>">

                </div>

            </div>
            <div class="row">
                <ul class="single-block-about-price__list">
                    <li class="single-block-about-price__item">
                        <div class="single-block-about-price__name">
                            <img src="/images/icons/aparts.svg" alt="">
                            Апартаменты:
                        </div>
                        <div class="single-block-about-price__cur">
                            <ul class="single-block-about-price__sublist single-block-about-price-sublist">
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Час:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['price'] ?></div>
                                </li>
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Два часа:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['price_2_hour'] ?></div>
                                </li>
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Ночь:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['price_night'] ?></div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="single-block-about-price__item">
                        <div class="single-block-about-price__name">
                            <img src="/images/icons/car-big.svg" alt="">
                            Выезд:
                        </div>
                        <div class="single-block-about-price__cur">
                            <ul class="single-block-about-price__sublist single-block-about-price-sublist">
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Час:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['exit_hour_price'] ?></div>
                                </li>
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Два часа:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['exit_two_hour_price'] ?></div>
                                </li>
                                <li class="single-block-about-price-sublist__item">
                                    <div class="single-block-about-price-sublist__name">Ночь:</div>
                                    <div class="single-block-about-price-sublist__cur"><?php echo $post['exit_night_price'] ?></div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="profile__about-services profile__about-block profile__tab" id="profileServices">
            <div class="profile__about-top">
                <div class="profile__about-services-title profile__about-title">
                    Предоставляемые услуги:
                </div>
                <ul class="profile__about-services-hints-list">
                    <li class="profile__about-services-hints-item">
                        включено в стоимость
                    </li>
                    <li class="profile__about-services-hints-item">
                        услуга не предоставляется
                    </li>
                </ul>
            </div>


            <div class="profile__about-services-lists">

                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        Секс
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'sex') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>

                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        Окончание
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'cum') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        БДСМ
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'bdsm') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        Массаж
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'mass') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        Минет
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'minet') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="profile__about-services-lists-item">
                    <div class="profile__about-services-lists-title">
                        Разное
                    </div>
                    <ul class="profile__about-services-list">

                        <?php foreach ($serviceList as $serviceItem) : ?>

                            <?php $statusClass = 'profile__about-services-list-item_stop' ?>

                            <?php if ($serviceItem->type == 'other') : ?>

                                <?php foreach ($post['service'] as $postServiceItem) {

                                    if ($postServiceItem['service_id'] == $serviceItem->id) {

                                        $statusClass = 'profile__about-services-list-item_onprice';

                                        break;

                                    }

                                } ?>

                                <li class="profile__about-services-list-item <?php echo $statusClass ?>">
                                    <a href="/usluga-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>
<?php if (isset($post['metro'][0]['x']) or $post['x'] or isset($cityInfo['x'])) : ?>
    <div class="single__block single-block single-block__map single-block-map">
        <div class="single-block__title">
            Расположение
        </div>
        <div class="single-block-map__map">

            <div id="map"
                 class="yandex-map map-not-exist" data-id="<?php echo $post['id'] ?>"

                <?php

                if ($post['x']) {
                    $x = $post['x'];
                    $y = $post['y'];
                } elseif (isset($post['metro'][0]['x']) and $post['metro'][0]['x']) {
                    $x = $post['metro'][0]['x'];
                    $y = $post['metro'][0]['y'];
                } elseif (isset($cityInfo['x']) and $cityInfo['x']) {
                    $x = $cityInfo['x'];
                    $y = $cityInfo['y'];
                }

                ?>

                 data-x="<?php echo $x ?>"
                 data-y="<?php echo $y ?>"

                 style="height: 200px">
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="single__block single-block single-block__reviews single-block__reviews">

    <div class="single-block__title">
        Отзывы
    </div>

    <div class="single-block-reviews__add">

        <?php if (!$post['review']) : ?>

            <div class="single-block-reviews__add-text">
                К этой анкете ещё нет ни одного отзыва. Вы можете быть первым
                <img src="/images/icons/emoji.svg" alt="">
            </div>

        <?php endif; ?>

        <button class="single-block-reviews__add-btn profile__modal-toggle">
            <span>Оставить отзыв</span>
        </button>
    </div>

    <?php if ($post['review']) : ?>

        <?php foreach ($post['review'] as $review) : ?>

            <div class="single-block-reviews__review single-block-reviews-review">
                <div class="single-block-reviews-review__top">
                    <div class="single-block-reviews-review__top-left">
                        <div class="single-block-reviews-review__avatar">

                            <?php if (isset($review['author']['avatar']['file']) and $review['author']['avatar']['file']) : ?>
                                <?php echo PhotoWidget::widget([
                                    'path' => $review['author']['avatar']['file'],
                                    'size' => '59',
                                    'options' => [
                                        'class' => 'img user-img',
                                        'loading' => 'lazy',
                                        'alt' => $review['author']['username'],
                                    ],
                                ]); ?>
                            <?php else : ?>

                                <div class="no-photo">
                                    <?php

                                    echo $review['name'][0] . $review['name'][1] ?? $review['author']['username'][0] . $review['author']['username'][1];

                                    ?>
                                </div>

                            <?php endif; ?>

                        </div>
                        <div class="single-block-reviews-review__info">
                            <div class="single-block-reviews-review__name">
                                <?php echo $review['name'] ?? $review['author']['username'] ?>
                            </div>
                            <div class="single-block-reviews-review__rating rating-stars rating-stars">
                                <div class="rating-stars__body">
                                    <div class="rating-stars__item">
                                        <input type="radio"><input type="radio">
                                    </div>
                                    <div class="rating-stars__item">
                                        <input type="radio"><input type="radio">
                                    </div>
                                    <div class="rating-stars__item">
                                        <input type="radio"><input type="radio">
                                    </div>
                                    <div class="rating-stars__item">
                                        <input type="radio"><input type="radio">
                                    </div>
                                    <div class="rating-stars__item">
                                        <input type="radio"><input type="radio">
                                    </div>
                                    <div class="rating-stars__progress"
                                         style="width: <?php echo $review['total_marc'] * 10 ?>%;"></div>
                                </div>
                                <div class="rating-stars__value">
                                    <?php echo $review['total_marc'] / 2 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-block-reviews-review__top-right">
                    </div>
                </div>
                <div class="single-block-reviews-review__text">
                    <?php echo $review->text ?>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<div class="profile__modal-bg">
    <div class="profile__modal">
        <div class="profile__modal-header">
            <div class="profile__modal-title">
                Добавить отзыв
            </div>
            <div class="profile__modal-close profile__modal-toggle">
                <svg>
                    <use xlink:href='/svg/dest/stack/sprite.svg#close'></use>
                </svg>
            </div>
        </div>
        <div class="profile__modal-text">
            Оцените по 5 балльной шкале качество выполненной работы и оставить отзыв.
        </div>
        <form action="/review/add" method="post" class="profile__modal-form">
            <?php echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>
            <input type="hidden" value="<?php echo $post['id'] ?>" name="post_id">
            <div class="profile__modal-rating-stars rating-stars-set">

                <input class="rating-stars-set__item" checked id="ratingSetItem1" type="radio" value="1"
                       name="reviewRating">
                <label for="ratingSetItem1">A</label>
                <input class="rating-stars-set__item" id="ratingSetItem2" type="radio" value="2"
                       name="reviewRating">
                <label for="ratingSetItem2">A</label>
                <input class="rating-stars-set__item" id="ratingSetItem3" type="radio" value="3"
                       name="reviewRating">
                <label for="ratingSetItem3">A</label>
                <input class="rating-stars-set__item" id="ratingSetItem4" type="radio" value="4"
                       name="reviewRating">
                <label for="ratingSetItem4">A</label>
                <input class="rating-stars-set__item" id="ratingSetItem5" type="radio" value="5"
                       name="reviewRating">
                <label for="ratingSetItem5">A</label>
            </div>

            <input type="text" name="name" required placeholder="Ваше имя" class="profile__modal-form-input">

            <textarea class="profile__modal-form-textarea" required name="text" placeholder="Комментарий"></textarea>
            <div class="profile__modal-form-captcha"></div>
            <button class="profile__modal-form-btn btn">
                Опубликовать
            </button>
        </form>
    </div>
</div>