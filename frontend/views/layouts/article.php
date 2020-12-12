<?php

/* @var $post array */

use frontend\widgets\PhotoWidget;

?>

<div class="col-xl-4 col-lg-4 col-md-6 col-12 post-wrap">
    <article class="post">
        <div class="post-img position-relative">
            <a href="/post/<?php echo $post['id'] ?>">
                <?php echo PhotoWidget::widget([
                    'path' => $post['avatar']['file'] ,
                    'size' => '350_420',
                    'options' => [
                        'class' => 'img user-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                    ],
                ]  ); ?>
            </a>
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
                    </div>г <?php echo \frontend\widgets\CurrentCity::widget() ?>
                    <?php if (isset($post['metro'][0]['value'])) : ?>
                        м. <?php echo $post['metro'][0]['value'] ?>
                    <?php endif; ?>
                </div>
                <div class="post-find-and-otzivi-count-block">
                    <div class="icon find-date-icon">
                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.60468 5.8101C7.04756 5.20531 7.31247 4.46243 7.31247 3.6571C7.31247 1.64111 5.67221 0.000854492 3.65622 0.000854492C1.64024 0.000854492 0 1.64111 0 3.6571C0 5.67308 1.64026 7.31334 3.65624 7.31334C4.46158 7.31334 5.20452 7.0484 5.80931 6.60552L8.2046 9.0008L9 8.2054C9 8.20538 6.60468 5.8101 6.60468 5.8101ZM3.65624 6.18834C2.26043 6.18834 1.125 5.05291 1.125 3.6571C1.125 2.26129 2.26043 1.12586 3.65624 1.12586C5.05205 1.12586 6.18748 2.26129 6.18748 3.6571C6.18748 5.05291 5.05204 6.18834 3.65624 6.18834Z" fill="white"/>
                        </svg>
                    </div>
                    <span class="date"> <?php echo date('m.d.y', $post['created_at'])?></span>
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
                                    <?php $countReview = \frontend\modules\user\models\Posts::countReview($post['id']) ?>

                        <?php echo $countReview ?> <?php echo getNumEnding($countReview, ['отзыв','отзыва', 'отзывов']); ?></span>
                </div>
            </div>
            <?php $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']) ?>
            <div class="post-rating">
                <div class="star-bg">
                </div>
                <?php
                if ($postRating) echo $postRating['total_rating'];
                else echo 0
                ?>
            </div>
            <div class="black-gradient"></div>
        </div>
        <div class="bottom-info">
            <div class="post-info-table-wrapper">
                <table class="post-info-table ">
                    <tr>
                        <th>Чистота</th>
                        <th>Качество услуг</th>
                        <th>Жалобы</th>
                        <th>Довольных гостей</th>
                    </tr>
                    <tr><td><?php echo  isset($postRating['clean_marc'] ) ? $postRating['clean_marc']  : "-";?></td>
                        <td><?php echo  isset($postRating['service_marc'] ) ? $postRating['service_marc']  : "-";?></td>
                        <td><?php echo  isset($postRating['not_happy_marc_count'] ) ? $postRating['not_happy_marc_count']  : "-";?></td>
                        <td><?php echo  isset($postRating['happy_marc_count'] ) ? $postRating['happy_marc_count']  : "-";?></td>
                    </tr>
                </table>
            </div>
            <div class="post-marc-block">
                <?php if ($post['category'] == 1) : ?>
                    <div class="indi-marc post-marc red-post-marc">
                        <img src="/img/user(1)1.png" alt="">
                        индивидуалка
                    </div>
                <?php else : ?>
                    <div class="indi-marc post-marc red-post-marc">
                        <img src="/img/star(2)1.png" alt="">
                        салон
                    </div>
                <?php endif; ?>
                <?php if ($post['check_photo_status'] == 1) : ?>
                    <div class="indi-marc post-marc blue-post-marc">
                        <img src="/img/verified1.png" alt="">
                        фото реальное
                    </div>
                <?php endif; ?>
                <div class="indi-marc post-marc blue-post-marc">
                    <img src="/img/photo-camera1.png" alt="">

                </div>
                <div class="indi-marc post-marc red-post-marc">
                    <img src="/img/video-player1.png" alt="">
                    <?php if (!$post['video']) : ?>
                        нет
                    <?php else : ?>
                        есть
                    <?php endif; ?>
                    видео
                </div>

            </div>
        </div>
        <div class="price">
            от <?php echo $post['price'] ?> руб.
        </div>
    </article>
</div>
