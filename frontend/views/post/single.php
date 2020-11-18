<?php

/* @var $post array */
/* @var $serviceList array */

$this->registerJsFile('/js/owl.carousel.js', ['depends' => ['yii\web\YiiAsset']]);
$this->registerCssFile('/css/owl.carousel.min.css');
$this->registerCssFile('/css/owl.theme.default.min.css');
?>

    <article class="single position-relative">
        <div class="row">
            <div class="col-12 col-xl-4 position-relative">
                <div class="owl-carousel owl-theme">
                    <?php foreach ($post['allPhoto'] as $item) : ?>
                        <img src="<?php echo $item['file'] ?>" alt="">
                    <?php endforeach; ?>
                </div>
                <?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>
                    <div class="check-label">
                        проверенная
                        индивидуалка
                    </div>
                <?php endif ?>
            </div>
        </div>

        <a href="#" class="back position-absolute"></a>
        <?php $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']) ?>
        <div class="post-rating">
            <div class="star-bg">
            </div>
            <?php
            if ($postRating) echo $postRating['total_rating'];
            else echo 0
            ?>
        </div>
        <div class="single-bottom-info position-relative">
            <div class="post-top-info">
                <div class="phone-photo-count">
                    <a href="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>" class="post-phone"><?php echo $post['phone'] ?></a>
                    <div class="icon count-photo-icon">
                        <img src="/img/camera1.svg" alt="">
                    </div>
                    +<?php echo \frontend\modules\user\models\Posts::countPhoto($post['id'])?>
                </div>
                <div class="post-address">
                    <div class="geo-icon icon">
                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.50001 0C2.84583 0 1.5 1.34583 1.5 3.00001C1.5 3.49659 1.62415 3.98895 1.86018 4.42566L4.33595 8.90332C4.36891 8.96302 4.43172 9 4.50001 9C4.5683 9 4.6311 8.96302 4.66406 8.90332L7.14075 4.42419C7.37586 3.98895 7.50001 3.49657 7.50001 2.99999C7.50001 1.34583 6.15418 0 4.50001 0ZM4.50001 4.5C3.67292 4.5 3.00001 3.82709 3.00001 3.00001C3.00001 2.17292 3.67292 1.50001 4.50001 1.50001C5.32709 1.50001 6 2.17292 6 3.00001C6 3.82709 5.32709 4.5 4.50001 4.5Z" fill="white"/>
                        </svg>
                    </div>г Москва м. Авиамоторная</div>
                <div class="post-find-and-otzivi-count-block">
                    <div class="icon find-date-icon">
                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.60468 5.8101C7.04756 5.20531 7.31247 4.46243 7.31247 3.6571C7.31247 1.64111 5.67221 0.000854492 3.65622 0.000854492C1.64024 0.000854492 0 1.64111 0 3.6571C0 5.67308 1.64026 7.31334 3.65624 7.31334C4.46158 7.31334 5.20452 7.0484 5.80931 6.60552L8.2046 9.0008L9 8.2054C9 8.20538 6.60468 5.8101 6.60468 5.8101ZM3.65624 6.18834C2.26043 6.18834 1.125 5.05291 1.125 3.6571C1.125 2.26129 2.26043 1.12586 3.65624 1.12586C5.05205 1.12586 6.18748 2.26129 6.18748 3.6571C6.18748 5.05291 5.05204 6.18834 3.65624 6.18834Z" fill="white"/>
                        </svg>
                    </div>
                    <span class="date"> 03.08.20</span>
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
                                15 отзывов</span>
                </div>
            </div>
            <div class="post-info-table-wrapper">
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
                <?php if ($post['selfie']) : ?>
                    <div class="orange-btn selfi-btn">
                        <img src="/img/camera(1)1.png" alt="">Смотеть селфи
                    </div>
                <?php endif; ?>
                <?php if ($post['video']) : ?>
                    <div class="white-btn video-btn">
                        <img src="/img/play1.png" alt="">Смотреть видео
                    </div>
                <?php endif; ?>
            </div>
            <div class="red-block " >
                <div>На других сайтах цены:</div>
                <div class="white-bold-text">от 30 000 руб. - 35 000 руб.</div>
                <div class="show-info show-info-white"></div>
            </div>
            <div onclick="show_otzivi_block()" class="white-block itzivi-block">
                <img src="/img/conversation2.png" alt="">
                <div><?php $countReview = \frontend\modules\user\models\Posts::countReview($post['id']) ?>

                    <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?></span></div>
                <div class="show-info show-info-grey"></div>
            </div>
            <div onclick="show_anket_params_block()" class="white-block">
                <img src="img/pen.png" alt="">
                <div>Параметры анкеты</div>
                <div class="show-info show-info-grey"></div>
            </div>
        </div>
    </article>
    <div class="otzivi-block">
        <div class="back-block" onclick="close_otzivi_block()">
            <img src="/img/back-red.png" alt="">
        </div>
        <div class="d-flex otzivi-block-top-info">
            <div class="post-img">
                <img src="<?php echo $post['avatar']['file'] ?>" alt="">
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
                                                <img src="<?php echo $item['author']['avatar']['file'] ?>" alt="">
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
                <img src="<?php echo $post['avatar']['file'] ?>" alt="">
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

            <?php if ($post['place']) : ?>

                <div class="user-service-item">
                        <span class="red-text">
                            Место встречи:
                        </span>
                    <span class="grey-text">

                        <?php $lastElement = array_pop($post['place']); ?>

                        <?php foreach ($post['place'] as $item) : ?>

                            <?php echo $item['value'] ?>,

                        <?php endforeach; ?>

                        <?php echo $lastElement['value'] ?>.

                        </span>
                </div>

            <?php endif; ?>

            <div class="user-service-item">
                <span class="red-text">
                    Услуги:
                </span>
                <span class="grey-text">
                    Кунилингус, ролевые игры, лёгкая доминация, секс классика, Минет без резинки, Минет в резинки, массаж, окончание на грудь.
                </span>
            </div>
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

<?php d($post); ?>
