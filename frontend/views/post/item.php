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
                <div class="single-block-about__slider-item">

                    <?php foreach ($post['gal'] as $item) : ?>

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

                    <?php endforeach; ?>

                </div>
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
                                    <div class="single-block-about-params__cur"><?php echo $post['rost'] ?></div>
                                    <div class="single-block-about-params__name">рост</div>
                                </li>
                                <li class="single-block-about-params__item">
                                    <div class="single-block-about-params__cur"><?php echo $post['ves'] ?></div>
                                    <div class="single-block-about-params__name">вес</div>
                                </li>
                                <li class="single-block-about-params__item">
                                    <div class="single-block-about-params__cur"><?php echo $post['breast'] ?></div>
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
                                    <li class="single-block-about-tags__item tags__item">
                                        <a href="#" class="single-block-about-tags__link tags__link">#с
                                            выездом</a>
                                    </li>
                                    <li class="single-block-about-tags__item tags__item">
                                        <a href="#"
                                           class="single-block-about-tags__link tags__link">#блондинка</a>
                                    </li>
                                    <li class="single-block-about-tags__item tags__item">
                                        <a href="#" class="single-block-about-tags__link tags__link">#с
                                            выездом</a>
                                    </li>
                                    <li class="single-block-about-tags__item tags__item">
                                        <a href="#"
                                           class="single-block-about-tags__link tags__link">#блондинка</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="single-block-about-list__item single-block-about-list__item--descr">
                        <div class="single-block-about-list__name">
                            Описание:
                        </div>
                        <div class="single-block-about-list__cur single-block-about__descr">
                            <?php $post['about'] ?>
                        </div>
                    </li>
                </ul>
                <img src="/images/status_1.svg" alt="" class="single-block-about__status">
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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
                                    <a href="/service-<?php echo $serviceItem->url ?>"><?php echo $serviceItem->value ?></a>
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

            <div id="map-<?php echo $post['id'] ?>"
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
        <div class="single-block-reviews__add-text">
            К этой анкете ещё нет ни одного отзыва. Вы можете быть первым
            <img src="/images/icons/emoji.svg" alt="">
        </div>
        <button class="single-block-reviews__add-btn profile__modal-toggle">
            <span>Оставить отзыв</span>
        </button>
    </div>
    <div class="single-block-reviews__review single-block-reviews-review">
        <div class="single-block-reviews-review__top">
            <div class="single-block-reviews-review__top-left">
                <div class="single-block-reviews-review__avatar">
                    <img src="/images/avatar.png" alt="">
                </div>
                <div class="single-block-reviews-review__info">
                    <div class="single-block-reviews-review__name">
                        nickname
                        <img src="/images/icons/verify-none.svg" alt="">
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
                            <div class="rating-stars__progress" style="width: 37%;"></div>
                        </div>
                        <div class="rating-stars__value">
                            2.5
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-block-reviews-review__top-right">
                <div class="single-block-reviews-review__date">2 дня назад</div>
            </div>
        </div>
        <div class="single-block-reviews-review__text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
            ullamco
            laboris nisi ut aliquip ex ea commodo consequat.
        </div>
    </div>
</div>

