<?php

/* @var $post array */
/* @var $cityInfo array */
/* @var $price array */
/* @var $this \yii\web\View */

/* @var $serviceListReview array */

/* @var $phoneComments array */
/* @var $first bool|null */

use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\ReviewForm;
use frontend\modules\user\models\ServiceReviewForm;
use frontend\widgets\PhotoWidget;
use yii\widgets\ActiveForm;

$postReviewForm = new ReviewForm();
$serviceReviewFormForm = new ServiceReviewForm();

$strizhkaList = $post['strizhka'];
$cvetList = $post['cvet'];
$nacionalnostList = $post['nacionalnost'];
$rayonList = $post['rayon'];
$serviceList = $post['service'];
$placeList = $post['place'];
$servicePostList = $post['service'];

$countReview = \frontend\modules\user\models\Posts::countReview($post['id']);

?>

<div class="row">
    <div >

    </div>
</div>

<?php if (isset($moreText)) : ?>
    <div class="red-bold-text text-center more-text"><?php echo $moreText?></div>
<?php endif; ?>

<article class="single position-relative" data-post-id="<?php echo $post['id'] ?>">
    <div class="row">
        <div class="col-12 col-lg-4 col-xl-4 position-relative">

            <?php

            $photoTitle = 'Проститутка ' . $post['name'];

            ?>
            <?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>
                <div class="check-label">
                    проверенная
                    индивидуалка
                </div>
                <?php

                $photoTitle = 'Проверенная проститутка ' . $post['name'];

                ?>
            <?php endif ?>

            <div class="position-relative single-photo-block-<?php echo $post['id'] ?>">

                <div class="post-photo">

                    <div id="carouselExampleControls-<?php echo $post['id'] ?>" class="carousel slide"
                         data-ride="carousel">

                        <div class="carousel-inner">

                            <?php $i = 0 ?>


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

                        <a class="carousel-control-prev"
                           href="#carouselExampleControls-<?php echo $post['id'] ?>" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next"
                           href="#carouselExampleControls-<?php echo $post['id'] ?>" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                        <ol class="carousel-indicators">
                            <?php $j = 0 ?>

                            <li data-target="#carouselExampleControls-<?php echo $post['id'] ?>" data-slide-to="0"
                                class="active"></li>

                            <?php while ($j + 1 <= $i) : ?>

                                <li data-target="#carouselExampleControls-<?php echo $post['id'] ?>"
                                    data-slide-to="<?php echo $j + 1 ?>"></li>

                                <?php $j++; ?>

                            <?php endwhile; ?>

                        </ol>
                    </div>

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

            <?php if ($post['video']) : ?>
                <div class="left-video-wrap">
                    <div class="red-bold-text">Видео</div>
                    <video controls="controls" class="video">
                        <source src="<?php echo $post['video'] ?>">
                    </video>
                </div>
            <?php endif; ?>

        </div>
        <?php if (isset($backUrl) and $backUrl) : ?>
            <a href="<?php echo $backUrl ?>" class="back position-absolute"></a>
        <?php endif; ?>
        <div class="single-bottom-info position-relative  col-xl-8 col-lg-8">
            <div class="row height-100 single-post-info-row">
                <div class="col-12 col-md-12 col-lg-9 single-post-info-wrap">
                    <div class="post-top-info">
                        <div class="">
                            <h1 class="text-center"><?php echo $post['name'] ?> ID: <?php echo $post['id'] ?>, Просмотров: <?php echo ViewCountHelper::countView($post['id'] , Yii::$app->params['redis_post_single_view_count_key']) ?></h1>

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
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="#fff"
                                         fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M16 22.621l-3.521-6.795c-.007.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.082-1.026-3.492-6.817-2.106 1.039c-1.639.855-2.313 2.666-2.289 4.916.075 6.948 6.809 18.071 12.309 18.045.541-.003 1.07-.113 1.58-.346.121-.055 2.102-1.029 2.11-1.033zm-2.5-13.621c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm9 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm-4.5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z"/>
                                    </svg>
                                    Показать номер
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="red-text " id="tell-me-text">НИКОГДА НЕ ПЕРЕВОДИТЕ ДЕНЬГИ ДО ВСТРЕЧИ <br> Скажите что звоните с сайта <?php echo Yii::$app->request->serverName ?> я
                            и все пойму
                        </div>

                        <div onclick="ym(70919698,'reachGoal','SHARE')" class="ya-share2" data-curtain
                             data-shape="round"
                             data-services="messenger,vkontakte,odnoklassniki,telegram,twitter,viber,whatsapp,skype,linkedin,reddit"></div>

                        <div class="main-params-wrap main-params-wrap-on-page bottom-gallery d-flex">
                            <div class="main-param-item">
                                <img loading="lazy" src="/img/calendar.png" width="14px" height="14px" alt="">
                                <?php echo $post['age'] ? $post['age'] : "-"; ?>
                            </div>
                            <div class="main-param-item">
                                <img loading="lazy" src="/img/2-Ruler.png" width="16px" height="16px" alt="">
                                <?php echo $post['rost'] ? $post['rost'] : "-"; ?> см
                            </div>
                            <div class="main-param-item">
                                <img loading="lazy" src="/img/weight-scale1.png" width="17px" height="17px" alt="">
                                <?php echo $post['ves'] ? $post['ves'] : "-"; ?> кг
                            </div>
                            <div class="main-param-item">
                                <img loading="lazy" src="/img/women-brassiere1.png" width="22px" height="22px"
                                     alt="">
                                <?php echo $post['breast'] ? $post['breast'] : "-"; ?>
                            </div>
                        </div>

                        <?php if ($post['check_photo_status'] == 1) : ?>
                            <div class="check-photo d-flex white-bold-text">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" rx="10" fill="#17CA29"></rect>
                                    <path d="M25.5586 6.9428C25.4612 6.83162 25.342 6.74173 25.2083 6.67875C25.0746 6.61577 24.9293 6.58107 24.7816 6.5768C22.4866 6.5168 19.5826 4.0628 17.6626 3.0998C16.4766 2.5068 15.6936 2.1158 15.1056 2.0128C14.9862 1.9954 14.8649 1.99574 14.7456 2.0138C14.1576 2.1168 13.3746 2.5078 12.1896 3.1008C10.2696 4.0628 7.3656 6.5168 5.0706 6.5768C4.92277 6.58129 4.77744 6.61609 4.64361 6.67904C4.50978 6.742 4.39031 6.83178 4.2926 6.9428C4.09008 7.17194 3.98558 7.47141 4.0016 7.7768C4.4946 17.7998 8.0896 24.0028 14.3976 27.6078C14.5616 27.7008 14.7436 27.7488 14.9246 27.7488C15.1056 27.7488 15.2876 27.7008 15.4526 27.6078C21.7606 24.0028 25.3546 17.7998 25.8486 7.7768C25.8656 7.47146 25.7613 7.17176 25.5586 6.9428ZM20.5426 10.8848L15.2196 18.7398C15.0286 19.0218 14.7286 19.2088 14.4316 19.2088C14.1336 19.2088 13.8026 19.0458 13.5936 18.8368L9.8416 15.0838C9.71911 14.9608 9.65033 14.7944 9.65033 14.6208C9.65033 14.4472 9.71911 14.2808 9.8416 14.1578L10.7686 13.2288C10.8918 13.1068 11.0582 13.0383 11.2316 13.0383C11.405 13.0383 11.5714 13.1068 11.6946 13.2288L14.1346 15.6688L18.3736 9.4118C18.4717 9.26862 18.6224 9.17006 18.7929 9.13765C18.9634 9.10523 19.1398 9.1416 19.2836 9.2388L20.3686 9.9748C20.5119 10.0727 20.6107 10.2234 20.6433 10.3939C20.6759 10.5644 20.6397 10.7409 20.5426 10.8848Z"
                                          fill="white"></path>
                                </svg>
                                <div class="">Фото проверенно</div>
                            </div>
                        <?php endif; ?>

                        <div class="photo-count phone-photo-count d-flex">
                            <div class="icon count-photo-icon">
                                <img src="/img/camera1.svg" width="12px" height="12px" alt="">
                            </div>
                            <a href="#photo-count-<?php echo $post['id'] ?>" class="photo-count">
                                +<?php echo \frontend\modules\user\models\Posts::countPhoto($post['id']) ?>
                                фото
                            </a>
                        </div>

                        <div class="post-address post-address-wrap">
                            <div class="geo-icon icon">
                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.50001 0C2.84583 0 1.5 1.34583 1.5 3.00001C1.5 3.49659 1.62415 3.98895 1.86018 4.42566L4.33595 8.90332C4.36891 8.96302 4.43172 9 4.50001 9C4.5683 9 4.6311 8.96302 4.66406 8.90332L7.14075 4.42419C7.37586 3.98895 7.50001 3.49657 7.50001 2.99999C7.50001 1.34583 6.15418 0 4.50001 0ZM4.50001 4.5C3.67292 4.5 3.00001 3.82709 3.00001 3.00001C3.00001 2.17292 3.67292 1.50001 4.50001 1.50001C5.32709 1.50001 6 2.17292 6 3.00001C6 3.82709 5.32709 4.5 4.50001 4.5Z"
                                          fill="white"/>
                                </svg>
                            </div>
                            <span> г <?php echo $cityInfo['city'] ?> </span>

                            <?php if (isset($post['metro'][0]['value'])) : ?>
                                <a class="post-address" href="/metro-<?php echo $post['metro'][0]['url'] ?>">
                                    м. <?php echo $post['metro'][0]['value'] ?>
                                </a>
                            <?php endif; ?>

                        </div>
                        <div class="site-price post-address">
                            <svg width="21" height="21" viewBox="0 0 13 13" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 13C4.76379 13 3.13148 12.3239 1.90379 11.0962C0.676102 9.86852 0 8.23621 0 6.5C0 4.76379 0.676127 3.1315 1.90379 1.90379C3.13145 0.676076 4.76379 0 6.5 0C8.23621 0 9.86852 0.676102 11.0962 1.90379C12.3239 3.13148 13 4.76379 13 6.5C13 8.23621 12.3239 9.8685 11.0962 11.0962C9.86855 12.3239 8.23621 13 6.5 13ZM6.5 0.8125C3.3639 0.8125 0.8125 3.3639 0.8125 6.5C0.8125 9.6361 3.3639 12.1875 6.5 12.1875C9.6361 12.1875 12.1875 9.6361 12.1875 6.5C12.1875 3.3639 9.6361 0.8125 6.5 0.8125Z"
                                      fill="#F74952"></path>
                                <path d="M6.5 6.09375C5.93998 6.09375 5.48438 5.63814 5.48438 5.07812C5.48438 4.51811 5.93998 4.0625 6.5 4.0625C7.06002 4.0625 7.51562 4.51811 7.51562 5.07812C7.51562 5.30248 7.6975 5.48438 7.92188 5.48438C8.14625 5.48438 8.32812 5.30248 8.32812 5.07812C8.32812 4.20974 7.71931 3.48136 6.90625 3.29606V2.84375C6.90625 2.6194 6.72438 2.4375 6.5 2.4375C6.27562 2.4375 6.09375 2.6194 6.09375 2.84375V3.29606C5.28069 3.48136 4.67188 4.20974 4.67188 5.07812C4.67188 6.08616 5.49197 6.90625 6.5 6.90625C7.06002 6.90625 7.51562 7.36186 7.51562 7.92188C7.51562 8.48189 7.06002 8.9375 6.5 8.9375C5.93998 8.9375 5.48438 8.48189 5.48438 7.92188C5.48438 7.69752 5.3025 7.51562 5.07812 7.51562C4.85375 7.51562 4.67188 7.69752 4.67188 7.92188C4.67188 8.79026 5.28069 9.51864 6.09375 9.70394V10.1562C6.09375 10.3806 6.27562 10.5625 6.5 10.5625C6.72438 10.5625 6.90625 10.3806 6.90625 10.1562V9.70394C7.71931 9.51864 8.32812 8.79026 8.32812 7.92188C8.32812 6.91384 7.50803 6.09375 6.5 6.09375Z"
                                      fill="#F74952"></path>
                            </svg>
                            <?php echo $post['price'] ?> руб.
                        </div>

                        <?php if ($countReview) : ?>
                            <div class="post-find-and-otzivi-count-block">
                                <div class="otzivi-count d-flex">
                                    <div class="icon otzivi-count-icon">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(.clip0)">
                                                <path d="M8.96765 7.06371L8.44493 5.54244C8.69689 5.02737 8.83005 4.45453 8.83094 3.87816C8.83249 2.87598 8.44475 1.92839 7.73913 1.20997C7.03337 0.491412 6.0929 0.0869214 5.09095 0.0710484C4.05199 0.0546304 3.07542 0.449822 2.34124 1.18399C1.63329 1.89192 1.24063 2.82519 1.22821 3.82251C0.530458 4.34785 0.11862 5.1669 0.119974 6.04175C0.120624 6.45114 0.212769 6.8581 0.387372 7.22609L0.0273193 8.27389C-0.0345733 8.45402 0.0106377 8.64959 0.145321 8.78427C0.240103 8.87907 0.365066 8.92954 0.49358 8.92954C0.54765 8.92954 0.602353 8.92061 0.655703 8.90228L1.70352 8.54222C2.07152 8.71683 2.47847 8.80897 2.88786 8.80962C2.88934 8.80962 2.89075 8.80962 2.89222 8.80962C3.78009 8.80959 4.60539 8.38713 5.12881 7.67228C5.67351 7.65794 6.21243 7.52608 6.69965 7.28774L8.22093 7.81048C8.28432 7.83226 8.34932 7.84288 8.41357 7.84288C8.56629 7.84288 8.71479 7.7829 8.82745 7.67022C8.98748 7.51017 9.0412 7.27777 8.96765 7.06371ZM2.89219 8.27391C2.89104 8.27391 2.88983 8.27391 2.88869 8.27391C2.52633 8.27337 2.16649 8.18403 1.84813 8.0156C1.78267 7.98099 1.70582 7.97499 1.63582 7.99904L0.561396 8.36823L0.93059 7.29382C0.954637 7.22381 0.94866 7.14696 0.914031 7.08151C0.745597 6.76314 0.656265 6.40331 0.655703 6.04094C0.654806 5.45807 0.881547 4.9056 1.27806 4.49192C1.40757 5.28146 1.78387 6.00902 2.36715 6.58193C2.94612 7.1506 3.67389 7.51267 4.45914 7.63104C4.0445 8.03972 3.48559 8.27391 2.89219 8.27391ZM8.4486 7.29141C8.43336 7.30665 8.41529 7.3108 8.39497 7.30381L6.76639 6.74419C6.73811 6.73447 6.70868 6.72965 6.67936 6.72965C6.63614 6.72965 6.59307 6.74011 6.5541 6.76075C6.08911 7.00674 5.56366 7.1372 5.03452 7.13801C5.03278 7.13801 5.0312 7.13801 5.02946 7.13801C3.25648 7.13801 1.79199 5.69776 1.7639 3.9252C1.74975 3.03249 2.08932 2.1935 2.72004 1.56278C3.35077 0.932061 4.18989 0.59261 5.08248 0.606672C6.85674 0.634815 8.29797 2.10201 8.29523 3.87732C8.29441 4.40645 8.16396 4.93192 7.91799 5.39688C7.88336 5.46232 7.87738 5.53917 7.90143 5.60919L8.46103 7.23777C8.46801 7.25816 8.46382 7.27621 8.4486 7.29141Z"
                                                      fill="white"/>
                                                <path d="M6.62504 2.45239H3.43355C3.28561 2.45239 3.1657 2.57233 3.1657 2.72025C3.1657 2.86819 3.28563 2.98811 3.43355 2.98811H6.62504C6.77298 2.98811 6.8929 2.86817 6.8929 2.72025C6.8929 2.57233 6.77298 2.45239 6.62504 2.45239Z"
                                                      fill="white"/>
                                                <path d="M6.62504 3.55396H3.43355C3.28561 3.55396 3.1657 3.67389 3.1657 3.82181C3.1657 3.96973 3.28563 4.08967 3.43355 4.08967H6.62504C6.77298 4.08967 6.8929 3.96973 6.8929 3.82181C6.8929 3.67389 6.77298 3.55396 6.62504 3.55396Z"
                                                      fill="white"/>
                                                <path d="M5.39656 4.65564H3.43355C3.28561 4.65564 3.1657 4.77558 3.1657 4.9235C3.1657 5.07143 3.28563 5.19135 3.43355 5.19135H5.39654C5.54448 5.19135 5.6644 5.07142 5.6644 4.9235C5.6644 4.77558 5.5445 4.65564 5.39656 4.65564Z"
                                                      fill="white"/>
                                            </g>
                                            <defs>
                                                <clipPath class="clip0">
                                                    <rect width="9" height="9" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <a href="#review-count-<?php echo $post['id'] ?>">
                                        <?php echo $countReview ?><?php echo getNumEnding($countReview, ['отзыв', 'отзыва', 'отзывов']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="price-wrap">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Експресс</th>
                                    <th scope="col">Час</th>
                                    <th scope="col">2 часа</th>
                                    <th scope="col">Ночь</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?php echo $post['express_price'] ?? '-' ?></td>
                                    <td><?php echo $post['price'] ?? '-' ?></td>
                                    <td><?php echo $post['price_2_hour'] ?? '-' ?></td>
                                    <td><?php echo $post['price_night'] ?? '-' ?></td>
                                </tr>
                                </tbody>
                            </table>
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
                                <td><?php echo isset($postRating['clean_marc']) ? $postRating['clean_marc'] : "-"; ?></td>
                                <td><?php echo isset($postRating['service_marc']) ? $postRating['service_marc'] : "-"; ?></td>
                                <td><?php echo isset($postRating['not_happy_marc_count']) ? $postRating['not_happy_marc_count'] : "-"; ?></td>
                                <td><?php echo isset($postRating['happy_marc_count']) ? $postRating['happy_marc_count'] : "-"; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="btn-wrap">

                        <div class="white-btn video-btn" onclick="get_modal(this);ym(70919698,'reachGoal','message')"
                             data-target="message" data-id="<?php echo $post['user_id'] ?>">
                            Написать автору
                        </div>

                        <br>

                        <div class="white-btn video-btn" onclick="get_modal(this);ym(70919698,'reachGoal','claim')"
                             data-target="claim" data-id="<?php echo $post['id'] ?>">
                            Пожаловаться
                        </div>

                        <br>

                        <div class="orange-btn video-btn" onclick="get_modal(this);ym(70919698,'reachGoal','getCall')"
                             data-target="call" data-id="<?php echo $post['id'] ?>">
                            Заказать звонок
                        </div>

                    </div>

                    <?php if ($post['video']) : ?>
                        <div class="right-video-wrap">
                            <div class="red-bold-text">Видео</div>
                            <video controls="controls" class="video">
                                <source src="<?php echo $post['video'] ?>">
                            </video>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($post['metro'][0]['x']) or $post['x']) : ?>
                        <div class="red-bold-text map-heading">Карта</div>
                        <div id="map-<?php echo $post['id'] ?>"
                             class="yandex-map map-not-exist" data-id="<?php echo $post['id'] ?>"

                            <?php
                            if ($post['x']) {
                                $x = $post['x'];
                                $y = $post['y'];
                            } else {
                                $x = $post['metro'][0]['x'];
                                $y = $post['metro'][0]['y'];
                            }
                            ?>

                             data-x="<?php echo $x ?>"
                             data-y="<?php echo $y ?>"

                             style="height: 200px">
                        </div>
                    <?php endif; ?>

                    <?php

                    $favoriteClass = '';

                    if (\frontend\helpers\FavoriteHelper::isFavorite($post['id'])) $favoriteClass = 'favorite';

                    ?>

                    <div onclick="favorite(this)" class="favorite-btn-wrap <?php echo $favoriteClass ?>"
                         data-id="<?php echo $post['id'] ?>">

                        <div class="favorite-btn">

                            <div class="add">
                                <img loading="lazy" width="28px" height="28px" src="/img/heart1.png" alt="">
                            </div>
                            <div class="added">
                                <img loading="lazy" src="/img/heart2.png" alt="">
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
                                    <?php echo isset($postRating['clean_marc']) ? $postRating['clean_marc'] : "-"; ?>
                                </span>
                        </div>
                        <div class="desctop-rating-info-item">
                            <div class="desctop-rating-info-item-title">
                                Качество услуг
                            </div>
                            <span>
                                    <?php echo isset($postRating['service_marc']) ? $postRating['service_marc'] : "-"; ?>
                                </span>
                        </div>
                        <div class="desctop-rating-info-item">
                            <div class="desctop-rating-info-item-title">
                                Жалобы
                            </div>
                            <span>
                                    <?php echo isset($postRating['not_happy_marc_count']) ? $postRating['not_happy_marc_count'] : "-"; ?>
                                </span>
                        </div>
                        <div class="desctop-rating-info-item">
                            <div class="desctop-rating-info-item-title">
                                Довольных <br> гостей
                            </div>
                            <span>
                                    <?php echo isset($postRating['happy_marc_count']) ? $postRating['happy_marc_count'] : "-"; ?>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<div class="desc-params ">
    <div class="red-bold-text">Параметры анкеты</div>
    <div class="user-service-block bottom-gallery">

        <?php if ($post['place']) : ?>

            <div class="user-service-item">
                <span class="red-text">Место встречи:</span>
                <div class="grey-text">

                    <?php $lastElement = array_pop($post['place']); ?>

                    <?php foreach ($post['place'] as $item) : ?>

                        <a class="grey-text" href="/mesto-<?php echo $item['url'] ?>">
                            <?php echo $item['value'] ?>
                        </a>

                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if ($post['service']) : ?>

            <div class="user-service-item">
                <span class="red-text">Услуги:</span>
                <div class="grey-text">

                    <?php foreach ($post['service'] as $item) : ?>

                        <a class="grey-text" href="/usluga-<?php echo $item['service']['url'] ?>">
                            <?php echo $item['service']['value'] ?>
                        </a>

                        <?php if ($item['service_info']) : ?>

                            <span class="service_desc">(<?php echo $item['service_info']; ?>)</span>

                        <?php endif; ?>

                        <?php if ($item != end($post['service'])) echo ', ' ?>

                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if ($post['rayon']) : ?>

            <?php $rayon = $post['rayon']; ?>

            <div class="user-service-item">
                <span class="red-text">Район:</span>
                <div class="grey-text">

                    <?php $lastElement = array_pop($rayon); ?>

                    <?php foreach ($rayon as $item) : ?>
                        <a class="grey-text" href="/rayon-<?php echo $item['url'] ?>">
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
                <span class="red-text">Национальность:</span>
                <div class="grey-text">

                    <?php foreach ($post['nacionalnost'] as $item) : ?>
                        <a class="grey-text" href="/nacionalnost-<?php echo $item['url'] ?>">
                            <?php echo $item['value'] ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if ($post['cvet']) : ?>

            <div class="user-service-item">
                <span class="red-text">Цвет волос:</span>
                <div class="grey-text">

                    <?php foreach ($post['cvet'] as $item) : ?>
                        <a class="grey-text" href="/cvet-volos-<?php echo $item['url'] ?>">
                            <?php echo $item['value'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($post['strizhka']) : ?>

            <div class="user-service-item">
                <span class="red-text">Интимная стрижка:</span>
                <div class="grey-text">

                    <?php foreach ($post['strizhka'] as $item) : ?>
                        <a class="grey-text" href="/intimnaya-strizhka-<?php echo $item['url'] ?>">
                            <?php echo $item['value'] ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if ($post['about']) : ?>

            <div class="user-service-item">
                <span class="red-text">Описание:</span>
                <span class="grey-text"><?php echo $post['about'] ?></span>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php if ($post['selphiCount']) : ?>

    <div class="photo-list-wrap">
        <div class="red-bold-text text-center">Селфи</div>
        <div class="photo-list">
            <?php foreach ($post['selphiCount'] as $item) : ?>

                <?php echo PhotoWidget::widget([
                    'path' => $item['file'],
                    'size' => '1024',
                    'showPictureHref' => true,

                    'options' => [
                        'class' => 'img user-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                        'title' => $photoTitle,
                    ],
                ]); ?>

            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>

<?php if ($post['gal']) : ?>

    <div class="photo-list-wrap">
        <div class="red-bold-text text-center">Фото</div>

        <div class="photo-list" id="photo-count-<?php echo $post['id'] ?>">
            <?php foreach ($post['gal'] as $item) : ?>

                <?php echo PhotoWidget::widget([
                    'path' => $item['file'],
                    'size' => '1024',
                    'showPictureHref' => true,

                    'options' => [
                        'class' => 'img user-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                        'title' => $photoTitle,
                    ],
                ]); ?>

            <?php endforeach; ?>
        </div>


    </div>

<?php endif; ?>

<div class="otzivi-block-desc">

    <?php if ($postRating['review']) : ?>

        <div id="review-count-<?php echo $post['id'] ?>" class="red-bold-text">Отзывы</div>
        <div class="row">

            <div class="rating-block rating-block-close">
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
                                <div class="right">
                                    <?php echo $photoRating ?>%
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="rating-wrap">
                                    <div class="rating" style="width: <?php echo $photoRating ?>%"></div>
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
                                    <?php echo $serviceRating ?>%
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="rating-wrap">
                                    <div class="rating" style="width: <?php echo $serviceRating ?>%"></div>
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
                                    <?php echo $totalRating ?>%
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="rating-wrap">
                                    <div class="rating" style="width: <?php echo $totalRating ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $reviewCount = 0 ?>

                    <?php if ($serviceListReview) foreach ($serviceListReview as $service) : ?>

                        <?php if (isset($service['review']) and $service['review']) : ?>

                            <?php $reviewCount++; ?>

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
                                            <?php echo $serviceRating ?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="rating-wrap">
                                            <div class="rating"
                                                 style="width: <?php echo $serviceRating ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>
            </div>

            <?php if (isset($reviewCount) and $reviewCount > 2) : ?>

                <div onclick="open_rating_block(this)" class="open-rating-block">
                    Показать все
                </div>

            <?php endif; ?>

        </div>

        <div class="col-12 bottom-gallery">
            <div class="red-bold-text">
                <?php echo $countReview ?><?php echo getNumEnding($countReview, ['отзыв', 'отзыва', 'отзывов']); ?>
            </div>
        </div>

        <?php

        foreach ($postRating['review'] as $item) : ?>

            <?php if ($item['text'])

                echo $this->renderFile(Yii::getAlias('@app/views/includes/review.php'),
                    compact('item')
                )

            ?>

        <?php endforeach; ?>

    <?php endif; ?>

    <div data-toggle="modal" data-target="comment-form" data-id="<?php echo $post['id'] ?>"
         onclick="get_modal(this)" class="add-review-btn-wrap">
        <div class="add-review-btn">
            <div class="bg">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.2188 9.21875H10.7812V0.78125C10.7812 0.349766 10.4315 0 10 0C9.56852 0 9.21875 0.349766 9.21875 0.78125V9.21875H0.78125C0.349766 9.21875 0 9.56852 0 10C0 10.4315 0.349766 10.7812 0.78125 10.7812H9.21875V19.2188C9.21875 19.6502 9.56852 20 10 20C10.4315 20 10.7812 19.6502 10.7812 19.2188V10.7812H19.2188C19.6502 10.7812 20 10.4315 20 10C20 9.56852 19.6502 9.21875 19.2188 9.21875Z"
                          fill="white"/>
                </svg>
                <span class="text">Отзыв</span>
            </div>
        </div>
    </div>
</div>

<?php if ($phoneComments and $phoneComments['comments']) : ?>

    <div class="otzivi-block-desc">
        <div class="red-bold-text">Отзывы на этот номер</div>

        <?php foreach ($phoneComments['comments'] as $comment) : ?>

            <?php /* @var $comment \common\models\Comments */ ?>
            <div class="review-block">
                <div class="review-text">
                    <?php echo $comment['text'] ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

<?php endif; ?>

