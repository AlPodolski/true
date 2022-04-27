<?php

/* @var $post array */
/* @var $countPost integer */
/* @var $advertising bool | null */

/* @var $promo bool | null */

use frontend\widgets\PhotoWidget;

?>

<div data-post-id="<?php echo $post['id'] ?>"
     class="col-xl-4 col-lg-4 col-md-6 col-12 post-wrap <?php echo isset($countPost) ? 'post-num-' . $countPost : ""; ?>">
    <article class="post">
        <div class="post-img position-relative">

            <?php

            $photoTitle = 'Проститутка ' . $post['name'];

            ?>

            <?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>

                <?php

                $photoTitle = 'Проверенная проститутка ' . $post['name'];

                ?>

            <?php endif ?>

            <?php if ((isset($advertising) and $advertising) or (isset($promo) and $promo)) : ?>
                <div class="check-label rek-block">
                    Реклама
                </div>
            <?php endif ?>

            <a target="_blank" href="/post/<?php echo $post['id'] ?>">

                <?php echo PhotoWidget::widget([
                    'path' => $post['avatar']['file'],
                    'size' => '360_430',
                    'options' => [
                        'class' => 'img user-img listing-img',
                        'loading' => 'lazy',
                        'alt' => $post['name'],
                        'title' => $photoTitle,
                    ],
                ]); ?>
            </a>
            <div class="post-top-info">
                <div class="row">
                    <div class="col-6">
                        <div class="phone-photo-count">
                            <?php echo $post['name'] ?>
                        </div>
                        <div class="phone-photo-count">
                            <?php echo $post['price'] ?> руб.
                        </div>
                        <?php if (isset($post['metro'][0]['value'])) : ?>
                            <div class="post-address">
                                м.
                                <a href="/metro-<?php echo $post['metro'][0]['url'] ?>"><?php echo $post['metro'][0]['value'] ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="row rating-row-wrap">
                                    <div class="col-3">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect width="30" height="30" rx="10" fill="#F74952"/>
                                            <path d="M9.233 7.834L9.678 5.608C9.76866 5.15444 10.0137 4.74633 10.3714 4.45314C10.7292 4.15995 11.1775 3.99982 11.64 4H18.36C18.8225 3.99982 19.2708 4.15995 19.6286 4.45314C19.9863 4.74633 20.2313 5.15444 20.322 5.608L20.767 7.834C20.8369 8.18279 21.0043 8.50459 21.2498 8.76198C21.4953 9.01938 21.8089 9.20178 22.154 9.288C22.967 9.49138 23.6887 9.96068 24.2044 10.6213C24.72 11.2819 25.0001 12.0959 25 12.934V20C25 21.0609 24.5786 22.0783 23.8284 22.8284C23.0783 23.5786 22.0609 24 21 24H9C7.93913 24 6.92172 23.5786 6.17157 22.8284C5.42143 22.0783 5 21.0609 5 20V12.934C4.99992 12.0959 5.27998 11.2819 5.79564 10.6213C6.31131 9.96068 7.033 9.49138 7.846 9.288C8.19111 9.20178 8.50466 9.01938 8.75019 8.76198C8.99572 8.50459 9.16315 8.18279 9.233 7.834V7.834Z"
                                                  stroke="white" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M15 20C17.2091 20 19 18.2091 19 16C19 13.7909 17.2091 12 15 12C12.7909 12 11 13.7909 11 16C11 18.2091 12.7909 20 15 20Z"
                                                  stroke="white" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M14 8H16" stroke="white" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="col-8 white-bold-text">
                                        +<?php echo \frontend\modules\user\models\Posts::countPhoto($post['id']) ?> фото
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3 rating-icon-block">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a class="black-gradient" target="_blank" href="/post/<?php echo $post['id'] ?>"></a>
            <div class="bottom-info">

                <div class="post-marc-block">
                    <?php if ($post['category'] == 1) : ?>
                        <div class="indi-marc post-marc position-relative">
                            <div class="position-absolute indi-title marck-title">Индивидуалка</div>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="10" fill="#FF9900"/>
                                <path d="M14.7344 14C17.4958 14 19.7344 11.7614 19.7344 9C19.7344 6.23858 17.4958 4 14.7344 4C11.973 4 9.73438 6.23858 9.73438 9C9.73438 11.7614 11.973 14 14.7344 14Z"
                                      stroke="white" stroke-width="2"/>
                                <path d="M19.7344 24H8.00044C7.71682 24.0001 7.43643 23.9398 7.17788 23.8232C6.91933 23.7066 6.68854 23.5364 6.50081 23.3238C6.31309 23.1112 6.17272 22.8611 6.08904 22.5901C6.00536 22.3191 5.98027 22.0334 6.01544 21.752L6.40544 18.628C6.49613 17.9022 6.84885 17.2346 7.39727 16.7506C7.94568 16.2667 8.65201 15.9997 9.38344 16H9.73444"
                                      stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.7344 18L20.9844 20L24.7344 16" stroke="white" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    <?php else : ?>
                        <div class="indi-marc post-marc ">
                            <div class="position-absolute salon-title marck-title">Салон</div>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="10" fill="#F74952"/>
                                <path d="M25 21.2487V13.4227C25.0001 12.8782 24.889 12.3395 24.6735 11.8394C24.458 11.3394 24.1428 10.8886 23.747 10.5147L16.374 3.54669C16.0027 3.19561 15.511 3 15 3C14.489 3 13.9973 3.19561 13.626 3.54669L6.253 10.5147C5.85722 10.8886 5.54195 11.3394 5.3265 11.8394C5.11104 12.3395 4.99994 12.8782 5 13.4227V21.2487C5 21.7791 5.21071 22.2878 5.58579 22.6629C5.96086 23.038 6.46957 23.2487 7 23.2487H23C23.5304 23.2487 24.0391 23.038 24.4142 22.6629C24.7893 22.2878 25 21.7791 25 21.2487Z"
                                      stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <?php if ($post['check_photo_status'] == 1) : ?>
                        <div class="indi-marc post-marc ">
                            <div class="position-absolute chec-title marck-title">Фото проверенно</div>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="10" fill="#17CA29"/>
                                <path d="M25.5586 6.9428C25.4612 6.83162 25.342 6.74173 25.2083 6.67875C25.0746 6.61577 24.9293 6.58107 24.7816 6.5768C22.4866 6.5168 19.5826 4.0628 17.6626 3.0998C16.4766 2.5068 15.6936 2.1158 15.1056 2.0128C14.9862 1.9954 14.8649 1.99574 14.7456 2.0138C14.1576 2.1168 13.3746 2.5078 12.1896 3.1008C10.2696 4.0628 7.3656 6.5168 5.0706 6.5768C4.92277 6.58129 4.77744 6.61609 4.64361 6.67904C4.50978 6.742 4.39031 6.83178 4.2926 6.9428C4.09008 7.17194 3.98558 7.47141 4.0016 7.7768C4.4946 17.7998 8.0896 24.0028 14.3976 27.6078C14.5616 27.7008 14.7436 27.7488 14.9246 27.7488C15.1056 27.7488 15.2876 27.7008 15.4526 27.6078C21.7606 24.0028 25.3546 17.7998 25.8486 7.7768C25.8656 7.47146 25.7613 7.17176 25.5586 6.9428ZM20.5426 10.8848L15.2196 18.7398C15.0286 19.0218 14.7286 19.2088 14.4316 19.2088C14.1336 19.2088 13.8026 19.0458 13.5936 18.8368L9.8416 15.0838C9.71911 14.9608 9.65033 14.7944 9.65033 14.6208C9.65033 14.4472 9.71911 14.2808 9.8416 14.1578L10.7686 13.2288C10.8918 13.1068 11.0582 13.0383 11.2316 13.0383C11.405 13.0383 11.5714 13.1068 11.6946 13.2288L14.1346 15.6688L18.3736 9.4118C18.4717 9.26862 18.6224 9.17006 18.7929 9.13765C18.9634 9.10523 19.1398 9.1416 19.2836 9.2388L20.3686 9.9748C20.5119 10.0727 20.6107 10.2234 20.6433 10.3939C20.6759 10.5644 20.6397 10.7409 20.5426 10.8848Z"
                                      fill="white"/>
                            </svg>

                        </div>
                    <?php endif; ?>

                    <?php if ($post['video']) : ?>

                        <div class="indi-marc post-marc ">
                            <div class="position-absolute video-title marck-title">Есть видео</div>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="10" fill="#495AF7"/>
                                <path d="M13 18.0097V11.2003L18.2878 14.5078L13 18.0097Z" fill="white" stroke="white"
                                      stroke-width="2"/>
                                <mask id="path-3-inside-1" fill="white">
                                    <path d="M6.75 4C5.75544 4 4.80161 4.39509 4.09835 5.09835C3.39509 5.80161 3 6.75544 3 7.75V21.25C3 22.2446 3.39509 23.1984 4.09835 23.9016C4.80161 24.6049 5.75544 25 6.75 25H23.25C24.2446 25 25.1984 24.6049 25.9016 23.9016C26.6049 23.1984 27 22.2446 27 21.25V7.75C27 6.75544 26.6049 5.80161 25.9016 5.09835C25.1984 4.39509 24.2446 4 23.25 4H6.75ZM4.5 7.75C4.5 7.15326 4.73705 6.58097 5.15901 6.15901C5.58097 5.73705 6.15326 5.5 6.75 5.5H23.25C23.8467 5.5 24.419 5.73705 24.841 6.15901C25.2629 6.58097 25.5 7.15326 25.5 7.75V21.25C25.5 21.8467 25.2629 22.419 24.841 22.841C24.419 23.2629 23.8467 23.5 23.25 23.5H6.75C6.15326 23.5 5.58097 23.2629 5.15901 22.841C4.73705 22.419 4.5 21.8467 4.5 21.25V7.75Z"/>
                                </mask>
                                <path d="M6.75 4C5.75544 4 4.80161 4.39509 4.09835 5.09835C3.39509 5.80161 3 6.75544 3 7.75V21.25C3 22.2446 3.39509 23.1984 4.09835 23.9016C4.80161 24.6049 5.75544 25 6.75 25H23.25C24.2446 25 25.1984 24.6049 25.9016 23.9016C26.6049 23.1984 27 22.2446 27 21.25V7.75C27 6.75544 26.6049 5.80161 25.9016 5.09835C25.1984 4.39509 24.2446 4 23.25 4H6.75ZM4.5 7.75C4.5 7.15326 4.73705 6.58097 5.15901 6.15901C5.58097 5.73705 6.15326 5.5 6.75 5.5H23.25C23.8467 5.5 24.419 5.73705 24.841 6.15901C25.2629 6.58097 25.5 7.15326 25.5 7.75V21.25C25.5 21.8467 25.2629 22.419 24.841 22.841C24.419 23.2629 23.8467 23.5 23.25 23.5H6.75C6.15326 23.5 5.58097 23.2629 5.15901 22.841C4.73705 22.419 4.5 21.8467 4.5 21.25V7.75Z"
                                      fill="white"/>
                                <path d="M3 7.75H1H3ZM6.75 5.5V3.5V5.5ZM25.5 21.25H27.5H25.5ZM23.25 23.5V25.5V23.5ZM6.75 23.5V25.5V23.5ZM6.75 2C5.22501 2 3.76247 2.6058 2.68414 3.68414L5.51256 6.51256C5.84075 6.18437 6.28587 6 6.75 6V2ZM2.68414 3.68414C1.6058 4.76247 1 6.22501 1 7.75H5C5 7.28587 5.18437 6.84075 5.51256 6.51256L2.68414 3.68414ZM1 7.75V21.25H5V7.75H1ZM1 21.25C1 22.775 1.6058 24.2375 2.68414 25.3159L5.51256 22.4874C5.18437 22.1592 5 21.7141 5 21.25H1ZM2.68414 25.3159C3.76247 26.3942 5.22501 27 6.75 27V23C6.28587 23 5.84075 22.8156 5.51256 22.4874L2.68414 25.3159ZM6.75 27H23.25V23H6.75V27ZM23.25 27C24.775 27 26.2375 26.3942 27.3159 25.3159L24.4874 22.4874C24.1592 22.8156 23.7141 23 23.25 23V27ZM27.3159 25.3159C28.3942 24.2375 29 22.775 29 21.25H25C25 21.7141 24.8156 22.1592 24.4874 22.4874L27.3159 25.3159ZM29 21.25V7.75H25V21.25H29ZM29 7.75C29 6.22501 28.3942 4.76247 27.3159 3.68414L24.4874 6.51256C24.8156 6.84075 25 7.28587 25 7.75H29ZM27.3159 3.68414C26.2375 2.6058 24.775 2 23.25 2V6C23.7141 6 24.1592 6.18437 24.4874 6.51256L27.3159 3.68414ZM23.25 2H6.75V6H23.25V2ZM6.5 7.75C6.5 7.6837 6.52634 7.62011 6.57322 7.57322L3.7448 4.7448C2.94777 5.54183 2.5 6.62283 2.5 7.75H6.5ZM6.57322 7.57322C6.62011 7.52634 6.6837 7.5 6.75 7.5V3.5C5.62283 3.5 4.54183 3.94777 3.7448 4.7448L6.57322 7.57322ZM6.75 7.5H23.25V3.5H6.75V7.5ZM23.25 7.5C23.3163 7.5 23.3799 7.52634 23.4268 7.57322L26.2552 4.7448C25.4582 3.94777 24.3772 3.5 23.25 3.5V7.5ZM23.4268 7.57322C23.4737 7.62011 23.5 7.6837 23.5 7.75H27.5C27.5 6.62283 27.0522 5.54182 26.2552 4.7448L23.4268 7.57322ZM23.5 7.75V21.25H27.5V7.75H23.5ZM23.5 21.25C23.5 21.3163 23.4737 21.3799 23.4268 21.4268L26.2552 24.2552C27.0522 23.4582 27.5 22.3772 27.5 21.25H23.5ZM23.4268 21.4268C23.3799 21.4737 23.3163 21.5 23.25 21.5V25.5C24.3772 25.5 25.4582 25.0522 26.2552 24.2552L23.4268 21.4268ZM23.25 21.5H6.75V25.5H23.25V21.5ZM6.75 21.5C6.6837 21.5 6.62011 21.4737 6.57322 21.4268L3.7448 24.2552C4.54183 25.0522 5.62283 25.5 6.75 25.5V21.5ZM6.57322 21.4268C6.52634 21.3799 6.5 21.3163 6.5 21.25H2.5C2.5 22.3772 2.94777 23.4582 3.7448 24.2552L6.57322 21.4268ZM6.5 21.25V7.75H2.5V21.25H6.5Z"
                                      fill="white" mask="url(#path-3-inside-1)"/>
                            </svg>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>

        <?php if ($post['phone']) : ?>

            <div data-id="<?php echo $post['id'] ?>"

                <?php if (!$post['fake'] and $post['city_id'] == 1) : ?>

                    onclick="get_fake_phone(this)"
                    data-id="<?php echo $post['id'] ?>"
                    data-city="<?php echo $post['city_id'] ?>"
                    data-price="<?php echo $post['price'] ?>"

                <?php else : ?>

                    <?php $targetPrice = \frontend\components\helpers\PriceTargetHelper::target($post['price']) ?>
                    onclick="add_phone_view(this);ym(70919698,'reachGoal','call'); <?php if ($post['partnerId']) : ?>
                            ym(70919698,'reachGoal','<?php echo $post['partnerId']['partner_id'] ?>');  <?php endif; ?>
                    <?php echo $targetPrice ?>"

                <?php endif; ?>

                 data-tel="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>"
                 href="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>"
                 data-number="<?php echo $post['phone'] ?>"
                 class="price d-block ">Показать номер
            </div>

        <?php endif; ?>

    </article>
</div>
