<?php

/* @var $post array */
/* @var $serviceList array */
/* @var $cityInfo array */
/* @var $id integer */
/* @var $serviceReviewFormForm \frontend\modules\user\models\ServiceReviewForm */
/* @var $postReviewForm \frontend\modules\user\models\ReviewForm */

use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use kartik\icons\FontAwesomeAsset;
use frontend\widgets\PhotoWidget;
FontAwesomeAsset::register($this);

$this->registerJsFile('/js/owl.carousel.js', ['depends' => ['yii\web\YiiAsset']]);
$this->registerJsFile('https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js', ['depends' => ['yii\web\YiiAsset']]);
$this->registerCssFile('/css/owl.carousel.min.css');
$this->registerCssFile('/css/owl.theme.default.min.css');
$this->registerCssFile('https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css');

$countReview = \frontend\modules\user\models\Posts::countReview($post['id']);

$servicePostList = $post['service'];
$price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

$osobenostList = $post['osobenost'];
$strizhkaList = $post['strizhka'];
$cvetList = $post['cvet'];
$nacionalnostList = $post['nacionalnost'];
$rayonList = $post['rayon'];
$serviceList = $post['service'];
$placeList = $post['place'];

$title = 'Проститутка '.$post['name'] .' из города '.$cityInfo['city'].' - '.Yii::$app->request->hostName;

$this->title = $title;

$des = 'Проститутка '.$post['name'].' ждет Вашего звонка. Цена от '.$price['min'];


Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

?>

    <article class="single position-relative">
        <div class="row">
            <div class="col-12 col-lg-4 col-xl-4 position-relative">
                <div class="owl-carousel owl-theme owl-carousel-main">
                    <?php foreach ($post['allPhoto'] as $item) : ?>

                        <?php if ($item['type'] != \frontend\models\Files::SELPHY_TYPE) :  ?>

                            <?php echo PhotoWidget::widget([
                                'path' => $item['file'],
                                'size' => 'single',
                                'options' => [
                                    'class' => 'img user-img',
                                    'loading' => 'lazy',
                                    'alt' => $post['name'],
                                ],
                            ]  ); ?>

                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
                <?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>
                    <div class="check-label">
                        проверенная
                        индивидуалка
                    </div>
                <?php endif ?>
                <?php $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']) ?>
                <div class="post-rating">
                    <div class="star-bg">
                    </div>
                    <?php
                    if ($postRating) echo $postRating['total_rating'];
                    else echo 0
                    ?>
                </div>
            </div>
            <a href="#" class="back position-absolute"></a>
            <div class="single-bottom-info position-relative  col-xl-8 col-lg-8">
                <div class="row height-100 single-post-info-row">
                    <div class="col-12 col-lg-9 single-post-info-wrap">
                        <div class="post-top-info">
                            <div class="phone-photo-count">
                                <div class="row">
                                    <div class="col-12">
                                        <h1><?php echo $post['name'] ?></h1>
                                    </div>
                                    <div class="col-12">
                                        <a href="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>" class="post-phone"><?php echo $post['phone'] ?></a>
                                    </div>
                                    <div class="col-12">
                                        <div class="icon count-photo-icon">
                                            <img src="/img/camera1.svg" alt="">
                                        </div>
                                        <span class="photo-count">
                                            +<?php echo \frontend\modules\user\models\Posts::countPhoto($post['id'])?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="post-address">
                                <div class="geo-icon icon">
                                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.50001 0C2.84583 0 1.5 1.34583 1.5 3.00001C1.5 3.49659 1.62415 3.98895 1.86018 4.42566L4.33595 8.90332C4.36891 8.96302 4.43172 9 4.50001 9C4.5683 9 4.6311 8.96302 4.66406 8.90332L7.14075 4.42419C7.37586 3.98895 7.50001 3.49657 7.50001 2.99999C7.50001 1.34583 6.15418 0 4.50001 0ZM4.50001 4.5C3.67292 4.5 3.00001 3.82709 3.00001 3.00001C3.00001 2.17292 3.67292 1.50001 4.50001 1.50001C5.32709 1.50001 6 2.17292 6 3.00001C6 3.82709 5.32709 4.5 4.50001 4.5Z" fill="white"/>
                                    </svg>
                                </div>г <?php echo $cityInfo['city']?> м. Авиамоторная</div>
                            <div class="post-find-and-otzivi-count-block">
                                <div class="row">
                                    <div class="col-12 single-date-wrap">
                                        <div class="icon find-date-icon">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.60468 5.8101C7.04756 5.20531 7.31247 4.46243 7.31247 3.6571C7.31247 1.64111 5.67221 0.000854492 3.65622 0.000854492C1.64024 0.000854492 0 1.64111 0 3.6571C0 5.67308 1.64026 7.31334 3.65624 7.31334C4.46158 7.31334 5.20452 7.0484 5.80931 6.60552L8.2046 9.0008L9 8.2054C9 8.20538 6.60468 5.8101 6.60468 5.8101ZM3.65624 6.18834C2.26043 6.18834 1.125 5.05291 1.125 3.6571C1.125 2.26129 2.26043 1.12586 3.65624 1.12586C5.05205 1.12586 6.18748 2.26129 6.18748 3.6571C6.18748 5.05291 5.05204 6.18834 3.65624 6.18834Z" fill="white"/>
                                            </svg>
                                        </div>
                                        <span class="date"> <span class="find-date">Найдено</span> 03.08.20</span>
                                    </div>
                                    <div class="col-12">
                                        <span class="otzivi-count">
                                            <span class="icon otzivi-count-icon">
                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0)">
                                                        <path d="M8.96765 7.06371L8.44493 5.54244C8.69689 5.02737 8.83005 4.45453 8.83094 3.87816C8.83249 2.87598 8.44475 1.92839 7.73913 1.20997C7.03337 0.491412 6.0929 0.0869214 5.09095 0.0710484C4.05199 0.0546304 3.07542 0.449822 2.34124 1.18399C1.63329 1.89192 1.24063 2.82519 1.22821 3.82251C0.530458 4.34785 0.11862 5.1669 0.119974 6.04175C0.120624 6.45114 0.212769 6.8581 0.387372 7.22609L0.0273193 8.27389C-0.0345733 8.45402 0.0106377 8.64959 0.145321 8.78427C0.240103 8.87907 0.365066 8.92954 0.49358 8.92954C0.54765 8.92954 0.602353 8.92061 0.655703 8.90228L1.70352 8.54222C2.07152 8.71683 2.47847 8.80897 2.88786 8.80962C2.88934 8.80962 2.89075 8.80962 2.89222 8.80962C3.78009 8.80959 4.60539 8.38713 5.12881 7.67228C5.67351 7.65794 6.21243 7.52608 6.69965 7.28774L8.22093 7.81048C8.28432 7.83226 8.34932 7.84288 8.41357 7.84288C8.56629 7.84288 8.71479 7.7829 8.82745 7.67022C8.98748 7.51017 9.0412 7.27777 8.96765 7.06371ZM2.89219 8.27391C2.89104 8.27391 2.88983 8.27391 2.88869 8.27391C2.52633 8.27337 2.16649 8.18403 1.84813 8.0156C1.78267 7.98099 1.70582 7.97499 1.63582 7.99904L0.561396 8.36823L0.93059 7.29382C0.954637 7.22381 0.94866 7.14696 0.914031 7.08151C0.745597 6.76314 0.656265 6.40331 0.655703 6.04094C0.654806 5.45807 0.881547 4.9056 1.27806 4.49192C1.40757 5.28146 1.78387 6.00902 2.36715 6.58193C2.94612 7.1506 3.67389 7.51267 4.45914 7.63104C4.0445 8.03972 3.48559 8.27391 2.89219 8.27391ZM8.4486 7.29141C8.43336 7.30665 8.41529 7.3108 8.39497 7.30381L6.76639 6.74419C6.73811 6.73447 6.70868 6.72965 6.67936 6.72965C6.63614 6.72965 6.59307 6.74011 6.5541 6.76075C6.08911 7.00674 5.56366 7.1372 5.03452 7.13801C5.03278 7.13801 5.0312 7.13801 5.02946 7.13801C3.25648 7.13801 1.79199 5.69776 1.7639 3.9252C1.74975 3.03249 2.08932 2.1935 2.72004 1.56278C3.35077 0.932061 4.18989 0.59261 5.08248 0.606672C6.85674 0.634815 8.29797 2.10201 8.29523 3.87732C8.29441 4.40645 8.16396 4.93192 7.91799 5.39688C7.88336 5.46232 7.87738 5.53917 7.90143 5.60919L8.46103 7.23777C8.46801 7.25816 8.46382 7.27621 8.4486 7.29141Z" fill="white"/>
                                                        <path d="M6.62504 2.45239H3.43355C3.28561 2.45239 3.1657 2.57233 3.1657 2.72025C3.1657 2.86819 3.28563 2.98811 3.43355 2.98811H6.62504C6.77298 2.98811 6.8929 2.86817 6.8929 2.72025C6.8929 2.57233 6.77298 2.45239 6.62504 2.45239Z" fill="white"/>
                                                        <path d="M6.62504 3.55396H3.43355C3.28561 3.55396 3.1657 3.67389 3.1657 3.82181C3.1657 3.96973 3.28563 4.08967 3.43355 4.08967H6.62504C6.77298 4.08967 6.8929 3.96973 6.8929 3.82181C6.8929 3.67389 6.77298 3.55396 6.62504 3.55396Z" fill="white"/>
                                                        <path d="M5.39656 4.65564H3.43355C3.28561 4.65564 3.1657 4.77558 3.1657 4.9235C3.1657 5.07143 3.28563 5.19135 3.43355 5.19135H5.39654C5.54448 5.19135 5.6644 5.07142 5.6644 4.9235C5.6644 4.77558 5.5445 4.65564 5.39656 4.65564Z" fill="white"/>
                                                    </g>
                                                    <defs>
                                                    <clipPath id="clip0">
                                                        <rect width="9" height="9" fill="white"/>
                                                    </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                            <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-info-table-wrapper mobile-rating-info-table">
                            <table class="post-info-table ">
                                <tr>
                                    <th>Чистота</th>
                                    <th>Качество услуг</th>
                                    <th>Жалобы</th>
                                    <th>Довольных гостей</th>
                                </tr>
                                <tr>
                                    <td><?php echo isset($postRating['clean_marc'] ) ? $postRating['clean_marc']  : "-";?></td>
                                    <td><?php echo isset($postRating['service_marc'] ) ? $postRating['service_marc']  : "-";?></td>
                                    <td><?php echo isset($postRating['not_happy_marc_count'] ) ? $postRating['not_happy_marc_count']  : "-";?></td>
                                    <td><?php echo isset($postRating['happy_marc_count'] ) ? $postRating['happy_marc_count']  : "-";?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="btn-wrap">

                            <div class="orange-btn selfi-btn" data-toggle="modal" data-target="#selfy-modal">
                                <img src="/img/camera(1)1.png" alt="">Смотеть селфи
                            </div>

                            <?php if ($post['video']) : ?>
                                <div class="white-btn video-btn" data-toggle="modal" data-target="#video-modal">
                                    <img src="/img/play1.png" alt="">Смотреть видео
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="red-block " onclick="show_site_price_block()">
                            <div>На других сайтах цены:</div>
                            <div class="white-bold-text">от <?php echo $price['min'] ?> руб. - <?php echo $price['max'] ?> руб.</div>
                            <div class="show-info show-info-white"></div>
                        </div>
                        <div onclick="show_otzivi_block()" class="white-block itzivi-block">
                            <img src="/img/conversation2.png" alt="">
                            <div>

                                <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?></span></div>
                            <div class="show-info show-info-grey"></div>
                        </div>
                        <div onclick="show_anket_params_block()" class="white-block">
                            <img src="/img/pen.png" alt="">
                            <div>Параметры анкеты</div>
                            <div class="show-info show-info-grey"></div>
                        </div>

                        <?php

                            $favoriteClass = '';

                            if(\frontend\helpers\FavoriteHelper::isFavorite($post['id'])) $favoriteClass = 'favorite';

                        ?>

                        <div onclick="favorite(this)" class="favorite-btn-wrap <?php echo $favoriteClass ?>"
                             data-id="<?php echo $post['id'] ?>">

                            <div class="favorite-btn">

                                <div class="add">
                                    <img src="/img/heart1.png" alt="">
                                </div>
                                <div class="added">
                                    <img src="/img/heart2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 desctop-rating-info-wrap">
                        <div class="desctop-rating-info">
                            <div class="desctop-rating-info-item">
                                <div class="desctop-rating-info-item-title">
                                    Чистота
                                </div>
                                <span>
                                    <?php echo isset($postRating['clean_marc'] ) ? $postRating['clean_marc']  : "-";?>
                                </span>
                            </div>
                            <div class="desctop-rating-info-item">
                                <div class="desctop-rating-info-item-title">
                                    Качество услуг
                                </div>
                                <span>
                                    <?php echo isset($postRating['service_marc'] ) ? $postRating['service_marc']  : "-";?>
                                </span>
                            </div>
                            <div class="desctop-rating-info-item">
                                <div class="desctop-rating-info-item-title">
                                    Жалобы
                                </div>
                                <span>
                                    <?php echo isset($postRating['not_happy_marc_count'] ) ? $postRating['not_happy_marc_count']  : "-";?>
                                </span>
                            </div>
                            <div class="desctop-rating-info-item">
                                <div class="desctop-rating-info-item-title">
                                    Довольных <br> гостей
                                </div>
                                <span>
                                    <?php echo isset($postRating['happy_marc_count'] ) ? $postRating['happy_marc_count']  : "-";?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

<!-- Nav tabs -->
<ul class="nav nav-tabs single-tabs ">
    <li class="nav-item col-4">
        <a class="nav-link active " data-toggle="tab" href="#home">
            <span class="">
                <span class="small-text">На других сайтах цены:</span><br>
                <span class="big-text">от <?php echo $price['min'] ?> руб. - <?php echo $price['max'] ?> руб.</span>
            </span>
        </a>
    </li>
    <li class="nav-item col-4">
                <a class="nav-link" data-toggle="tab" href="#menu1">
                <span class="icon otzivi-count-icon">
                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M8.96765 7.06371L8.44493 5.54244C8.69689 5.02737 8.83005 4.45453 8.83094 3.87816C8.83249 2.87598 8.44475 1.92839 7.73913 1.20997C7.03337 0.491412 6.0929 0.0869214 5.09095 0.0710484C4.05199 0.0546304 3.07542 0.449822 2.34124 1.18399C1.63329 1.89192 1.24063 2.82519 1.22821 3.82251C0.530458 4.34785 0.11862 5.1669 0.119974 6.04175C0.120624 6.45114 0.212769 6.8581 0.387372 7.22609L0.0273193 8.27389C-0.0345733 8.45402 0.0106377 8.64959 0.145321 8.78427C0.240103 8.87907 0.365066 8.92954 0.49358 8.92954C0.54765 8.92954 0.602353 8.92061 0.655703 8.90228L1.70352 8.54222C2.07152 8.71683 2.47847 8.80897 2.88786 8.80962C2.88934 8.80962 2.89075 8.80962 2.89222 8.80962C3.78009 8.80959 4.60539 8.38713 5.12881 7.67228C5.67351 7.65794 6.21243 7.52608 6.69965 7.28774L8.22093 7.81048C8.28432 7.83226 8.34932 7.84288 8.41357 7.84288C8.56629 7.84288 8.71479 7.7829 8.82745 7.67022C8.98748 7.51017 9.0412 7.27777 8.96765 7.06371ZM2.89219 8.27391C2.89104 8.27391 2.88983 8.27391 2.88869 8.27391C2.52633 8.27337 2.16649 8.18403 1.84813 8.0156C1.78267 7.98099 1.70582 7.97499 1.63582 7.99904L0.561396 8.36823L0.93059 7.29382C0.954637 7.22381 0.94866 7.14696 0.914031 7.08151C0.745597 6.76314 0.656265 6.40331 0.655703 6.04094C0.654806 5.45807 0.881547 4.9056 1.27806 4.49192C1.40757 5.28146 1.78387 6.00902 2.36715 6.58193C2.94612 7.1506 3.67389 7.51267 4.45914 7.63104C4.0445 8.03972 3.48559 8.27391 2.89219 8.27391ZM8.4486 7.29141C8.43336 7.30665 8.41529 7.3108 8.39497 7.30381L6.76639 6.74419C6.73811 6.73447 6.70868 6.72965 6.67936 6.72965C6.63614 6.72965 6.59307 6.74011 6.5541 6.76075C6.08911 7.00674 5.56366 7.1372 5.03452 7.13801C5.03278 7.13801 5.0312 7.13801 5.02946 7.13801C3.25648 7.13801 1.79199 5.69776 1.7639 3.9252C1.74975 3.03249 2.08932 2.1935 2.72004 1.56278C3.35077 0.932061 4.18989 0.59261 5.08248 0.606672C6.85674 0.634815 8.29797 2.10201 8.29523 3.87732C8.29441 4.40645 8.16396 4.93192 7.91799 5.39688C7.88336 5.46232 7.87738 5.53917 7.90143 5.60919L8.46103 7.23777C8.46801 7.25816 8.46382 7.27621 8.4486 7.29141Z" fill="white"/>
                            <path d="M6.62504 2.45239H3.43355C3.28561 2.45239 3.1657 2.57233 3.1657 2.72025C3.1657 2.86819 3.28563 2.98811 3.43355 2.98811H6.62504C6.77298 2.98811 6.8929 2.86817 6.8929 2.72025C6.8929 2.57233 6.77298 2.45239 6.62504 2.45239Z" fill="white"/>
                            <path d="M6.62504 3.55396H3.43355C3.28561 3.55396 3.1657 3.67389 3.1657 3.82181C3.1657 3.96973 3.28563 4.08967 3.43355 4.08967H6.62504C6.77298 4.08967 6.8929 3.96973 6.8929 3.82181C6.8929 3.67389 6.77298 3.55396 6.62504 3.55396Z" fill="white"/>
                            <path d="M5.39656 4.65564H3.43355C3.28561 4.65564 3.1657 4.77558 3.1657 4.9235C3.1657 5.07143 3.28563 5.19135 3.43355 5.19135H5.39654C5.54448 5.19135 5.6644 5.07142 5.6644 4.9235C5.6644 4.77558 5.5445 4.65564 5.39656 4.65564Z" fill="white"/>
                        </g>
                        <defs>
                            <clipPath id="clip0">
                                <rect width="9" height="9" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                    <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?>
                </a>
            </li>
            <li class="nav-item col-4">
                <a class="nav-link" data-toggle="tab" href="#menu2">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0515 0.961332C11.3459 0.256948 10.2032 0.256948 9.4976 0.961332L8.8583 1.60414L2.05298 8.40584L2.03852 8.42041C2.03502 8.42392 2.03502 8.42764 2.03129 8.42764C2.02406 8.43849 2.01321 8.44923 2.00609 8.46007C2.00609 8.46369 2.00236 8.46369 2.00236 8.4673C1.99513 8.47815 1.99163 8.48538 1.98428 8.49623C1.98078 8.49985 1.98078 8.50335 1.97717 8.50708C1.97355 8.51792 1.96993 8.52516 1.96621 8.536C1.96621 8.53951 1.9627 8.53951 1.9627 8.54323L0.452809 13.0837C0.408516 13.2129 0.442188 13.3561 0.539473 13.452C0.607832 13.5195 0.700032 13.5572 0.795961 13.5569C0.835169 13.5562 0.874038 13.5501 0.911551 13.5388L5.44847 12.0253C5.45197 12.0253 5.45197 12.0253 5.4557 12.0218C5.46711 12.0184 5.47807 12.0135 5.48813 12.0072C5.49095 12.0069 5.49344 12.0056 5.49547 12.0037C5.50621 11.9965 5.52067 11.9891 5.53152 11.9819C5.54225 11.9748 5.55321 11.9639 5.56406 11.9567C5.56767 11.953 5.57117 11.953 5.57117 11.9495C5.5749 11.9458 5.58213 11.9423 5.58575 11.935L13.0304 4.49037C13.7348 3.78474 13.7348 2.64207 13.0304 1.93656L12.0515 0.961332ZM5.33288 11.1764L2.81883 8.66244L9.11117 2.3701L11.6252 4.88403L5.33288 11.1764ZM2.46472 9.33067L4.66103 11.5269L1.36306 12.6249L2.46472 9.33067ZM12.5211 3.98462L12.1382 4.37117L9.62404 1.85701L10.0107 1.47058C10.4336 1.048 11.1191 1.048 11.5422 1.47058L12.5246 2.45304C12.9444 2.87788 12.9428 3.56181 12.5211 3.98462Z" fill="#5C5C5C"/>
                    </svg>
                    Параметры анкеты
                </a>
            </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
        <div class="row">
            <div class="col-4 bottom-gallery">

                <?php $imgs = array(); ?>

                <?php

                    if (count($post['allPhoto']) == 1) $size = 'single';

                    else $size = '175_210';

                ?>

                <?php foreach ($post['allPhoto'] as $item) : ?>

                    <?php if ($item['type'] != \frontend\models\Files::SELPHY_TYPE) {

                        $imgs[] = Yii::$app->imageCache->thumbSrc($item['file'], $size);

                    }
                   ?>

                <?php endforeach; ?>

                <div data-img="<?php echo implode(',' , $imgs) ?>" id="bottom-imgs"></div>

            </div>

            <div class="col-8">

                <div class="big-red-text">На других сайтах</div>

                <div class="sites-wrap">

                    <?php foreach ($post['sites'] as $item) : ?>

                        <div class="site-item">
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4">
                                    <div class="site-img-wrap">

                                        <?php if (isset($item['site']['photo']['file'])) : ?>

                                            <img class="site-img" src="<?php echo $item['site']['photo']['file'] ?>" alt="">

                                        <?php else: ?>

                                            <img class="site-img" src="/uploads/no-image.png" alt="">

                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-9 col-sm-8" >
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="site-find-date">
                                                <?php echo date('d.m.y' , $item['created_at'] ); ?>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="age-name">
                                                <?php echo $item['name_on_site'] ?>, <?php echo $item['age'] ?>
                                            </div>
                                        </div>
                                        <div class="col-12">

                                            <div class="site-price">
                                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.5 13C4.76379 13 3.13148 12.3239 1.90379 11.0962C0.676102 9.86852 0 8.23621 0 6.5C0 4.76379 0.676127 3.1315 1.90379 1.90379C3.13145 0.676076 4.76379 0 6.5 0C8.23621 0 9.86852 0.676102 11.0962 1.90379C12.3239 3.13148 13 4.76379 13 6.5C13 8.23621 12.3239 9.8685 11.0962 11.0962C9.86855 12.3239 8.23621 13 6.5 13ZM6.5 0.8125C3.3639 0.8125 0.8125 3.3639 0.8125 6.5C0.8125 9.6361 3.3639 12.1875 6.5 12.1875C9.6361 12.1875 12.1875 9.6361 12.1875 6.5C12.1875 3.3639 9.6361 0.8125 6.5 0.8125Z" fill="#F74952"/>
                                                    <path d="M6.5 6.09375C5.93998 6.09375 5.48438 5.63814 5.48438 5.07812C5.48438 4.51811 5.93998 4.0625 6.5 4.0625C7.06002 4.0625 7.51562 4.51811 7.51562 5.07812C7.51562 5.30248 7.6975 5.48438 7.92188 5.48438C8.14625 5.48438 8.32812 5.30248 8.32812 5.07812C8.32812 4.20974 7.71931 3.48136 6.90625 3.29606V2.84375C6.90625 2.6194 6.72438 2.4375 6.5 2.4375C6.27562 2.4375 6.09375 2.6194 6.09375 2.84375V3.29606C5.28069 3.48136 4.67188 4.20974 4.67188 5.07812C4.67188 6.08616 5.49197 6.90625 6.5 6.90625C7.06002 6.90625 7.51562 7.36186 7.51562 7.92188C7.51562 8.48189 7.06002 8.9375 6.5 8.9375C5.93998 8.9375 5.48438 8.48189 5.48438 7.92188C5.48438 7.69752 5.3025 7.51562 5.07812 7.51562C4.85375 7.51562 4.67188 7.69752 4.67188 7.92188C4.67188 8.79026 5.28069 9.51864 6.09375 9.70394V10.1562C6.09375 10.3806 6.27562 10.5625 6.5 10.5625C6.72438 10.5625 6.90625 10.3806 6.90625 10.1562V9.70394C7.71931 9.51864 8.32812 8.79026 8.32812 7.92188C8.32812 6.91384 7.50803 6.09375 6.5 6.09375Z" fill="#F74952"/>
                                                </svg>
                                                <?php echo $item['price'] ?> руб/час
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>
    </div>
    <div id="menu1" class="container tab-pane fade bottom-gallery"><br>
        <div class="otzivi-block-desc">

            <div class="row">
                <div class="col-4 bottom-gallery">
                    <div class="d-flex otzivi-block-top-info">
                        <div class="post-img">
                            <?php echo PhotoWidget::widget([
                                'path' => $post['avatar']['file'],
                                'size' => '200',
                                'options' => [
                                    'class' => 'img user-img',
                                    'loading' => 'lazy',
                                    'alt' => $post['name'],
                                ],
                            ]  ); ?>

                        </div>
                        <div class="grey-big-text">
                            <?php if ($postRating) echo $postRating['total_rating']; ?>/10
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="rating-block">
                        <div class="row">
                            <div class="col-12 rating-item">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="left">
                                            Фото
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <?php $photoRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['photo_marc']) ?>
                                        <div class="right" >
                                            <?php echo $photoRating?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="rating-wrap">
                                            <div class="rating" style="width: <?php echo $photoRating?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 rating-item">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="left">
                                            Сервис
                                        </div>
                                    </div>
                                    <?php $serviceRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['service_marc']) ?>
                                    <div class="col-4">
                                        <div class="right">
                                            <?php echo $serviceRating?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="rating-wrap">
                                            <div class="rating" style="width: <?php echo $serviceRating?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 rating-item">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="left">
                                            Общая
                                        </div>
                                    </div>
                                    <?php $totalRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['total_marc']) ?>
                                    <div class="col-4">
                                        <div class="right">
                                            <?php echo $totalRating?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="rating-wrap">
                                            <div class="rating" style="width: <?php echo $totalRating?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php foreach ($serviceList as $service) : ?>

                                <?php if ($service['review']) : ?>

                                    <?php $serviceRating = \frontend\helpers\PostRatingHelper::setPercentRating($service['review']) ?>

                                    <div class="col-12 rating-item">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="left">
                                                    <?php echo $service['value'] ?>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="right">
                                                    <?php echo $serviceRating?>%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="rating-wrap">
                                                    <div class="rating" style="width: <?php echo $serviceRating?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 bottom-gallery">
                <div class="red-bold-text">
                    <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?>
                </div>
            </div>

            <?php

            if ($postRating['review']) :

                foreach ( $postRating['review'] as $item) : ?>

                    <div class="review-block">
                        <div class="review-item">
                            <div class="col-12 bottom-gallery">
                                <div class="review-item-wrap">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-1">
                                                    <div class="author-img">
                                                        <?php echo PhotoWidget::widget([
                                                            'path' => $item['author']['avatar']['file'] ,
                                                            'size' => '59',
                                                            'options' => [
                                                                'class' => 'img user-img',
                                                                'loading' => 'lazy',
                                                                'alt' => $post['name'],
                                                            ],
                                                        ]  ); ?>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="author-name">
                                                        <?php echo $item['author']['username'] ?>
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.0943 4.77885C10.308 4.99248 10.308 5.33876 10.0943 5.55228L6.42557 9.22115C6.21194 9.43466 5.86577 9.43466 5.65215 9.22115L3.90567 7.47456C3.69205 7.26105 3.69205 6.91476 3.90567 6.70125C4.11919 6.48763 4.46547 6.48763 4.67899 6.70125L6.0388 8.06107L9.32091 4.77885C9.53453 4.56534 9.88081 4.56534 10.0943 4.77885ZM14 7C14 10.8692 10.8687 14 7 14C3.13075 14 0 10.8687 0 7C0 3.13075 3.13129 0 7 0C10.8692 0 14 3.13129 14 7ZM12.9062 7C12.9062 3.73531 10.2643 1.09375 7 1.09375C3.73531 1.09375 1.09375 3.73573 1.09375 7C1.09375 10.2647 3.73573 12.9062 7 12.9062C10.2647 12.9062 12.9062 10.2643 12.9062 7Z" fill="#31DA92"/>
                                                        </svg>

                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="date">
                                                        <div class="date-text">

                                                            <?php

                                                            $day = time() - $item['created_at'];

                                                            $day = (intdiv($day, 3600 * 24));

                                                            ?>

                                                            <?php echo $day ?> <?php echo getNumEnding($day, ['день','дня', 'дней']); ?>

                                                            назад

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12"></div>
                                    </div>
                                    <div class="review-text">
                                        <?php echo $item['text'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

            <div data-toggle="modal" data-target="#exampleModal" class="add-review-btn-wrap">
                <div class="add-review-btn">
                    <div class="bg">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2188 9.21875H10.7812V0.78125C10.7812 0.349766 10.4315 0 10 0C9.56852 0 9.21875 0.349766 9.21875 0.78125V9.21875H0.78125C0.349766 9.21875 0 9.56852 0 10C0 10.4315 0.349766 10.7812 0.78125 10.7812H9.21875V19.2188C9.21875 19.6502 9.56852 20 10 20C10.4315 20 10.7812 19.6502 10.7812 19.2188V10.7812H19.2188C19.6502 10.7812 20 10.4315 20 10C20 9.56852 19.6502 9.21875 19.2188 9.21875Z" fill="white"/>
                        </svg>
                        <span class="text">
                            отзыв
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu2" class="container tab-pane fade bottom-gallery"><br>
        <div class="desc-params ">
            <div class="row">
                <div class="col-4 bottom-gallery">
                    <div class="d-flex otzivi-block-top-info">
                        <div class="post-img">
                            <?php echo PhotoWidget::widget([
                                'path' => $post['avatar']['file'],
                                'size' => '200',
                                'options' => [
                                    'class' => 'img user-img',
                                    'loading' => 'lazy',
                                    'alt' => $post['name'],
                                ],
                            ]  ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="red-bold-text">
                                <?php echo $post['name'] ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="main-params-wrap bottom-gallery d-flex">
                                <div class="main-param-item">
                                    <img src="/img/calendar.png" alt="">
                                    <?php echo $post['age'] ? $post['age']  : "-";?>
                                </div>
                                <div class="main-param-item">
                                    <img src="/img/2-Ruler.png" alt="">
                                    <?php echo $post['rost'] ? $post['rost']  : "-";?> см
                                </div>
                                <div class="main-param-item">
                                    <img src="/img/weight-scale1.png" alt="">
                                    <?php echo $post['ves'] ? $post['ves']  : "-";?> кг
                                </div>
                                <div class="main-param-item">
                                    <img src="/img/women-brassiere1.png" alt="">
                                    <?php echo $post['ves'] ? $post['ves']  : "-";?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-service-block bottom-gallery">

                <?php if ($post['place']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Место встречи:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['place']); ?>

                            <?php foreach ($post['place'] as $item) : ?>

                                <a class="grey-text" href="/mesto/<?php echo $item['url'] ?>">
                                    <?php echo $item['value'] ?>
                                </a>

                            <?php endforeach; ?>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['service']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Услуги:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['service']); ?>

                            <?php foreach ($post['service'] as $item) : ?>
                                <a class="grey-text" href="/usluga-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/usluga-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['rayon']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Район:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['rayon']); ?>

                            <?php foreach ($post['rayon'] as $item) : ?>
                                <a class="grey-text" href="/rayon-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/rayon-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['nacionalnost']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Национальность:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['nacionalnost']); ?>

                            <?php foreach ($post['nacionalnost'] as $item) : ?>
                                <a class="grey-text" href="/nacionalnost-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/nacionalnost-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['cvet']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Цвет волос:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['cvet']); ?>

                            <?php foreach ($post['cvet'] as $item) : ?>
                                <a class="grey-text" href="/cvet-volos-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/cvet-volos-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['strizhka']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Интимная стрижка:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['strizhka']); ?>

                            <?php foreach ($post['strizhka'] as $item) : ?>
                                <a class="grey-text" href="/intimnaya-strizhka-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/intimnaya-strizhka-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($post['osobenost']) : ?>

                    <div class="user-service-item">
                        <span class="red-text">
                            Особенности:
                        </span>
                        <div class="grey-text">

                        <?php $lastElement = array_pop($post['osobenost']); ?>

                            <?php foreach ($post['osobenost'] as $item) : ?>
                                <a class="grey-text" href="/osobenost-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                                </a>,

                            <?php endforeach; ?>

                            <a class="grey-text" href="/osobenost-<?php echo $lastElement['url'] ?>">
                                <?php echo $lastElement['value'] ?>
                            </a>

                        </div>
                    </div>

                <?php endif; ?>

                <div class="user-service-item">
                    <span class="red-text">
                        Описание:
                    </span>
                    <span class="grey-text">
                    <?php echo $post['about'] ?>
                </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="otzivi-block">
        <div class="back-block" onclick="close_otzivi_block()">
            <img src="/img/back-red.png" alt="">
        </div>
        <div class="d-flex otzivi-block-top-info">
            <div class="post-img">
                <?php echo PhotoWidget::widget([
                    'path' => $post['avatar']['file'],
                    'size' => '200',
                    'options' => [
                        'class' => 'img user-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                    ],
                ]  ); ?>
            </div>
            <div class="red-bold-text">
                <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?>
            </div>
            <div class="grey-big-text">
                <?php if ($postRating) echo $postRating['total_rating']; ?>/10
            </div>
        </div>
        <div class="rating-block">
            <div class="row">
                <div class="col-12 rating-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="left">
                                Фото
                            </div>
                        </div>
                        <div class="col-4">
                            <?php $photoRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['photo_marc']) ?>
                            <div class="right" >
                                <?php echo $photoRating?>%
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rating-wrap">
                                <div class="rating" style="width: <?php echo $photoRating?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 rating-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="left">
                                Сервис
                            </div>
                        </div>
                        <?php $serviceRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['service_marc']) ?>
                        <div class="col-4">
                            <div class="right">
                                <?php echo $serviceRating?>%
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rating-wrap">
                                <div class="rating" style="width: <?php echo $serviceRating?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 rating-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="left">
                                Общая
                            </div>
                        </div>
                        <?php $totalRating = \frontend\helpers\PostRatingHelper::setPercentRating($postRating['total_marc']) ?>
                        <div class="col-4">
                            <div class="right">
                                <?php echo $totalRating?>%
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rating-wrap">
                                <div class="rating" style="width: <?php echo $totalRating?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach ($serviceList as $service) : ?>

                    <?php if ($service['review']) : ?>

                    <?php $serviceRating = \frontend\helpers\PostRatingHelper::setPercentRating($service['review']) ?>

                        <div class="col-12 rating-item">
                            <div class="row">
                                <div class="col-8">
                                    <div class="left">
                                        <?php echo $service['value'] ?>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="right">
                                        <?php echo $serviceRating?>%
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="rating-wrap">
                                        <div class="rating" style="width: <?php echo $serviceRating?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>

        <?php if ($postRating['review'] ) : ?>

            <?php foreach ( $postRating['review'] as $item) : ?>

                <div class="review-block">
                    <div class="review-item">
                        <div class="col-12">
                            <div class="review-item-wrap">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="author-img">
                                                    <?php echo PhotoWidget::widget([
                                                        'path' => $item['author']['avatar']['file'] ,
                                                        'size' => '59',
                                                        'options' => [
                                                            'class' => 'img user-img',
                                                            'loading' => 'lazy',
                                                            'alt' => $post['name'],
                                                        ],
                                                    ]  ); ?>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="author-name">
                                                    <?php echo $item['author']['username'] ?>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.0943 4.77885C10.308 4.99248 10.308 5.33876 10.0943 5.55228L6.42557 9.22115C6.21194 9.43466 5.86577 9.43466 5.65215 9.22115L3.90567 7.47456C3.69205 7.26105 3.69205 6.91476 3.90567 6.70125C4.11919 6.48763 4.46547 6.48763 4.67899 6.70125L6.0388 8.06107L9.32091 4.77885C9.53453 4.56534 9.88081 4.56534 10.0943 4.77885ZM14 7C14 10.8692 10.8687 14 7 14C3.13075 14 0 10.8687 0 7C0 3.13075 3.13129 0 7 0C10.8692 0 14 3.13129 14 7ZM12.9062 7C12.9062 3.73531 10.2643 1.09375 7 1.09375C3.73531 1.09375 1.09375 3.73573 1.09375 7C1.09375 10.2647 3.73573 12.9062 7 12.9062C10.2647 12.9062 12.9062 10.2643 12.9062 7Z" fill="#31DA92"/>
                                                    </svg>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="date">
                                                    <div class="date-text">

                                                        <?php

                                                            $day = time() - $item['created_at'];

                                                            $day = (intdiv($day, 3600 * 24));

                                                        ?>

                                                        <?php echo $day ?> <?php echo getNumEnding($day, ['день','дня', 'дней']); ?>

                                                         назад

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="review-text">
                                    <?php echo $item['text'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

        <div data-toggle="modal" data-target="#exampleModal" class="add-review-btn-wrap">
            <div class="add-review-btn">
                <div class="bg">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.2188 9.21875H10.7812V0.78125C10.7812 0.349766 10.4315 0 10 0C9.56852 0 9.21875 0.349766 9.21875 0.78125V9.21875H0.78125C0.349766 9.21875 0 9.56852 0 10C0 10.4315 0.349766 10.7812 0.78125 10.7812H9.21875V19.2188C9.21875 19.6502 9.56852 20 10 20C10.4315 20 10.7812 19.6502 10.7812 19.2188V10.7812H19.2188C19.6502 10.7812 20 10.4315 20 10C20 9.56852 19.6502 9.21875 19.2188 9.21875Z" fill="white"/>
                    </svg>
                    <span class="text">
                            отзыв
                        </span>
                </div>
            </div>
        </div>
    </div>
<div class="anket-params-block">
        <div class="back-block" onclick="close_anket_params_block()">
            <img src="/img/back-red.png" alt="">
        </div>
        <div class="d-flex otzivi-block-top-info">
            <div class="otziv-count">
                Параметры анкеты
            </div>
            <div class="post-img">
                <?php echo PhotoWidget::widget([
                    'path' => $post['avatar']['file'],
                    'size' => '200',
                    'options' => [
                        'class' => 'img user-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                    ],
                ]  ); ?>
            </div>
            <div class="red-bold-text">
                <?php echo $post['name'] ?>
            </div>
        </div>
        <div class="main-params-wrap d-flex">
            <div class="main-param-item">
                <img src="/img/calendar.png" alt="">
                <?php echo $post['age'] ? $post['age']  : "-";?>
            </div>
            <div class="main-param-item">
                <img src="/img/2-Ruler.png" alt="">
                <?php echo $post['rost'] ? $post['rost']  : "-";?> см
            </div>
            <div class="main-param-item">
                <img src="/img/weight-scale1.png" alt="">
                <?php echo $post['ves'] ? $post['ves']  : "-";?> кг
            </div>
            <div class="main-param-item">
                <img src="/img/women-brassiere1.png" alt="">
                <?php echo $post['ves'] ? $post['ves']  : "-";?>
            </div>
        </div>
        <div class="user-service-block">

            <?php if ($placeList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Место встречи:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($placeList); ?>

                        <?php foreach ($placeList as $item) : ?>

                            <?php echo $item['value'] ?>,

                            <a class="grey-text" href="/mesto-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                         <a class="grey-text" href="/mesto-<?php echo $lastElement['url']?>">
                                <?php echo $lastElement['value'] ?>
                            </a>.

                        </div>
                </div>

            <?php endif; ?>

            <?php if ($serviceList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Услуги:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($serviceList); ?>

                        <?php foreach ($serviceList as $item) : ?>

                            <a class="grey-text" href="/usluga-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                            <?php echo $item['value'] ?>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/usluga-<?php echo $lastElement['url']?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                        </div>
                </div>

            <?php endif; ?>

            <?php if ($rayonList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Район:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($rayonList); ?>

                        <?php foreach ($rayonList as $item) : ?>
                            <a class="grey-text" href="/rayon-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/rayon-<?php echo $lastElement['url'] ?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <?php if ($nacionalnostList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Национальность:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($nacionalnostList); ?>

                        <?php foreach ($nacionalnostList as $item) : ?>
                            <a class="grey-text" href="/nacionalnost-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/nacionalnost-<?php echo $lastElement['url'] ?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <?php if ($cvetList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Цвет волос:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($cvetList); ?>

                        <?php foreach ($cvetList as $item) : ?>
                            <a class="grey-text" href="/cvet-volos-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/cvet-volos-<?php echo $lastElement['url'] ?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <?php if ($strizhkaList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Интимная стрижка:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($strizhkaList); ?>

                        <?php foreach ($strizhkaList as $item) : ?>
                            <a class="grey-text" href="/intimnaya-strizhka-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/intimnaya-strizhka-<?php echo $lastElement['url'] ?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <?php if ($osobenostList) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Особенности:
                        </span>
                    <div class="grey-text">

                        <?php $lastElement = array_pop($osobenostList); ?>

                        <?php foreach ($osobenostList as $item) : ?>
                            <a class="grey-text" href="/osobenost-<?php echo $item['url']?>">
                                <?php echo $item['value'] ?>
                            </a>,

                        <?php endforeach; ?>

                        <a class="grey-text" href="/osobenost-<?php echo $lastElement['url'] ?>">
                            <?php echo $lastElement['value'] ?>
                        </a>

                    </div>
                </div>

            <?php endif; ?>

            <div class="user-service-item">
                    <span class="red-text">
                        Описание:
                    </span>
                <span class="grey-text">
                    <?php echo $post['about'] ?>
                </span>
            </div>
        </div>
    </div>
<div class="site-price-block">

    <div class="back-block" onclick="close_site_price_block()">
        <img src="/img/back-red.png" alt="">
    </div>

    <div class="owl-carousel owl-theme owl-carousel-main">
            <?php foreach ($post['allPhoto'] as $item) : ?>

                <?php if ($item['type'] != \frontend\models\Files::SELPHY_TYPE) :  ?>

                    <img src="<?php echo $item['file'] ?>" alt="">

                <?php endif; ?>

            <?php endforeach; ?>
        </div>

    <div class="sites-wrap">

            <div class="red-bold-text">
                На других сайтах
            </div>

            <div class="container">

                <?php foreach ($post['sites'] as $item) : ?>

                    <div class="site-item">

                        <div class="row">

                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4">
                                <div class="site-img-wrap">

                                    <?php if (isset($item['site']['photo']['file'])) : ?>

                                        <img class="site-img" src="<?php echo $item['site']['photo']['file'] ?>" alt="">

                                    <?php else: ?>

                                        <img class="site-img" src="/img/no-image.png" alt="">

                                    <?php endif; ?>

                                </div>
                            </div>

                            <div class="col-xl-8 col-lg-8 col-md-9 col-sm-9 col-8" >
                                <div class="row">
                                    <div class="col-12">
                                        <div class="site-find-date">
                                            <?php echo date('d.m.y' , $item['created_at'] ); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="age-name">
                                            <?php echo $item['name_on_site'] ?>, <?php echo $item['age'] ?>
                                        </div>
                                    </div>
                                    <div class="col-12">

                                        <div class="site-price">
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.5 13C4.76379 13 3.13148 12.3239 1.90379 11.0962C0.676102 9.86852 0 8.23621 0 6.5C0 4.76379 0.676127 3.1315 1.90379 1.90379C3.13145 0.676076 4.76379 0 6.5 0C8.23621 0 9.86852 0.676102 11.0962 1.90379C12.3239 3.13148 13 4.76379 13 6.5C13 8.23621 12.3239 9.8685 11.0962 11.0962C9.86855 12.3239 8.23621 13 6.5 13ZM6.5 0.8125C3.3639 0.8125 0.8125 3.3639 0.8125 6.5C0.8125 9.6361 3.3639 12.1875 6.5 12.1875C9.6361 12.1875 12.1875 9.6361 12.1875 6.5C12.1875 3.3639 9.6361 0.8125 6.5 0.8125Z" fill="#F74952"/>
                                                <path d="M6.5 6.09375C5.93998 6.09375 5.48438 5.63814 5.48438 5.07812C5.48438 4.51811 5.93998 4.0625 6.5 4.0625C7.06002 4.0625 7.51562 4.51811 7.51562 5.07812C7.51562 5.30248 7.6975 5.48438 7.92188 5.48438C8.14625 5.48438 8.32812 5.30248 8.32812 5.07812C8.32812 4.20974 7.71931 3.48136 6.90625 3.29606V2.84375C6.90625 2.6194 6.72438 2.4375 6.5 2.4375C6.27562 2.4375 6.09375 2.6194 6.09375 2.84375V3.29606C5.28069 3.48136 4.67188 4.20974 4.67188 5.07812C4.67188 6.08616 5.49197 6.90625 6.5 6.90625C7.06002 6.90625 7.51562 7.36186 7.51562 7.92188C7.51562 8.48189 7.06002 8.9375 6.5 8.9375C5.93998 8.9375 5.48438 8.48189 5.48438 7.92188C5.48438 7.69752 5.3025 7.51562 5.07812 7.51562C4.85375 7.51562 4.67188 7.69752 4.67188 7.92188C4.67188 8.79026 5.28069 9.51864 6.09375 9.70394V10.1562C6.09375 10.3806 6.27562 10.5625 6.5 10.5625C6.72438 10.5625 6.90625 10.3806 6.90625 10.1562V9.70394C7.71931 9.51864 8.32812 8.79026 8.32812 7.92188C8.32812 6.91384 7.50803 6.09375 6.5 6.09375Z" fill="#F74952"/>
                                            </svg>
                                            <?php echo $item['price'] ?> руб/час
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

</div>


<!-- Modal -->
<div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="video-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($post['video']) : ?>
                    <video controls="controls" class="video">
                        <source src="<?php echo $post['video'] ?>" type='video/webm; codecs="vp8, vorbis"'>
                    </video>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="selfy-modal" tabindex="-1" role="dialog" aria-labelledby="selfy-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $imgs = array(); ?>

                <?php foreach ($post['allPhoto'] as $item) : ?>

                    <?php

                        if ($item['type'] == \frontend\models\Files::SELPHY_TYPE) $imgs[] = $item['file']

                    ?>


                <?php endforeach; ?>

                <div data-img="<?php echo implode(',' , $imgs) ?>" id="selfy-imgs"></div>

            </div>
        </div>
    </div>
</div>

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
                <?php

                $form = ActiveForm::begin([
                    'action' => '/review/add',
                    'options' => ['class' => 'form-horizontal'],
                ]);


                echo $form->field($postReviewForm, 'post_id')->hiddenInput(['value' => $id])->label(false);

                ?>
                <div class="row review-modal-body">

                    <div class="col-12 reting-item">

                        <div class="row">

                            <div class="col-6">Фото</div>
                            <div class="col-6">
                                <?php

                                echo $form->field($postReviewForm, 'photo')->widget(StarRating::className(), [
                                    'value' => 8,
                                    'pluginOptions' =>  [
                                        'size' => 'xs',
                                        'min' => 0,
                                        'max' => 10,
                                        'step' => 1,
                                        'readonly' => false,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ])->label(false);

                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Чистота</div>
                            <div class="col-6"><?php

                                echo $form->field($postReviewForm, 'clean')->widget(StarRating::className(), [
                                    'value' => 8,
                                    'pluginOptions' =>  [
                                        'size' => 'xs',
                                        'min' => 0,
                                        'max' => 10,
                                        'step' => 1,
                                        'readonly' => false,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ])->label(false);

                                ?></div>
                        </div>
                    </div>
                    <div class="col-12 reting-item">
                        <div class="row">
                            <div class="col-6">Общая</div>
                            <div class="col-6"><?php

                                echo $form->field($postReviewForm, 'total')->widget(StarRating::className(), [
                                    'value' => 8,
                                    'pluginOptions' =>  [
                                        'size' => 'xs',
                                        'min' => 0,
                                        'max' => 10,
                                        'step' => 1,
                                        'readonly' => false,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ])->label(false);

                                ?>
                            </div>
                        </div>
                    </div>


                    <?php foreach ($servicePostList as $item) : ?>
                    <div class="col-12 reting-item">
                        <div class="row">

                                <div class="col-6"><?php echo $item['value']?></div>
                                <div class="col-6"><?php

                                    echo $form->field($serviceReviewFormForm, $item['id'])->widget(StarRating::className(), [
                                        'value' => 8,
                                        'pluginOptions' =>  [
                                            'size' => 'xs',
                                            'min' => 0,
                                            'max' => 10,
                                            'step' => 1,
                                            'readonly' => false,
                                            'showClear' => false,
                                            'showCaption' => false,
                                        ],
                                    ])->label(false);

                                    ?></div>

                        </div>
                    </div>

                    <?php endforeach; ?>


                    <div class="col-12">

                        <?php

                        echo $form->field($postReviewForm, 'text')
                            ->textarea(['placeholder' => 'Комментарий'])->label(false);

                        ?>

                    </div>

                    <div class="col-12">
                        <div class="send-btn-wrap">
                            <?= \yii\helpers\Html::submitButton('Опубликовать', ['class' => 'orange-btn']) ?>
                        </div>
                    </div>

                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>