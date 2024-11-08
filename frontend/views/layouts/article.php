<?php

/* @var $post array */
/* @var $i integer */
/* @var $countPost integer */
/* @var $advertising bool | null */

/* @var $promo bool | null */

/* @var $this \yii\web\View */

use frontend\helpers\LikeHelper;

echo \frontend\components\helpers\MicroHelper::image($post);

?>

<div data-link="/post/<?php echo $post['id'] ?>" class="catalog__item catalog-item <?php echo isset($countPost) ? 'post-num-' . $countPost : ""; ?>"
     data-post-id="<?php echo $post['id'] ?>">
    <div class="catalog-item__header">
        <?php if ((isset($advertising) and $advertising) or (isset($promo) and $promo)) : ?>
            <div class="check-label rek-block">
                Реклама
            </div>
        <?php endif ?>
        <div class="catalog-item-gallery">
            <?php
            $path = Yii::getAlias('@frontend/views/includes/article-photo.php');

            if ($i == 0) $lazy = false;
            else $lazy = true;

            echo $this->renderFile($path, [
                'file' => $post['avatar']['file'],
                'name' => $post['name'],
                'lazy' => $lazy,
                'cssClass' => 'listing-slick',
                'onClick' => 'openSingle(this)',
            ]);

            if ($post['galleryForListing']) {

                foreach ($post['galleryForListing'] as $item) {

                    echo $this->renderFile($path, [
                        'file' => $item['file'],
                        'name' => $post['name'],
                        'cssClass' => 'listing-slick',
                        'onClick' => 'openSingle(this)',
                    ]);

                }

            }

            ?>
        </div>


        <div class="tarif tarif_<?php echo $post['tarif_id'] ?>">
        </div>

        <div class="catalog-item__content">
            <div class="catalog-item__content-top">
                <div class="catalog-item__title">
                    <a class="catalog-item__name" href="/post/<?php echo $post['id'] ?>">
                        <?php echo $post['name'] ?>, <?php echo $post['age'] ?>
                    </a>
                    <div class="catalog-item__icons">

                        <?php if ($post['check_photo_status']) : ?>

                            <img src="/images/icons/verify.svg" alt="">

                        <?php endif; ?>

                        <?php if ($post['video']) : ?>

                            <img src="/images/icons/video.svg" alt="">

                        <?php endif; ?>

                        <?php if ($post['place']) : ?>

                            <?php foreach ($post['place'] as $placeItem) : ?>

                                <?php if ($placeItem['id'] == 2) : ?>

                                    <img src="/images/icons/car.svg" alt="">

                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="catalog-item__content-bottom">

                <?php if (isset($post['metro'][0]['value'])) : ?>
                    <div class="catalog-item__address">
                        м.
                        <a href="/metro-<?php echo $post['metro'][0]['url'] ?>"><?php echo $post['metro'][0]['value'] ?></a>
                    </div>
                <?php endif; ?>

                <div class="catalog-item__price">
                    <?php echo $post['price'] ?>р/час
                </div>
            </div>
        </div>

    </div>
    <div class="catalog-item__body">
        <div class="catalog-item__characters catalog-item-characters">
            <ul class="catalog-item-characters__list">
                <li class="catalog-item-characters__item">
                    <div class="catalog-item-characters__cur">
                        <?php echo $post['rost'] ?? '∞' ?>
                    </div>
                    <div class="catalog-item-characters__name">
                        рост
                    </div>
                </li>
                <li class="catalog-item-characters__item">
                    <div class="catalog-item-characters__cur">
                        <?php echo $post['ves'] ?? '∞' ?>
                    </div>
                    <div class="catalog-item-characters__name">
                        вес
                    </div>
                </li>
                <li class="catalog-item-characters__item">
                    <div class="catalog-item-characters__cur">
                        <?php echo $post['breast'] ?? '∞' ?>
                    </div>
                    <div class="catalog-item-characters__name">
                        грудь
                    </div>
                </li>
            </ul>
        </div>

        <?php echo $this->renderFile('@app/views/includes/tags.php', compact('post')) ?>

    </div>

    <div class="catalog-item__footer">

        <?php if ($post['phone']) : ?>

            <div data-id="<?php echo $post['id'] ?>"
                 data-city="<?php echo $post['city_id'] ?>"
                 data-price="<?php echo $post['price'] ?>"
                 data-age="<?php echo $post['age'] ?>"
                 data-rayon="<?php if (isset($post['rayon'][0]['id'])) echo $post['rayon'][0]['id'] ?>"

                <?php $targetPrice = \frontend\components\helpers\PriceTargetHelper::target($post['price']) ?>
                 onclick="getPhone(this);ym(70919698,'reachGoal','call'); <?php if ($post['partnerId']) : ?>
                         ym(70919698,'reachGoal','<?php echo $post['partnerId']['partner_id'] ?>');  <?php endif; ?>
                 <?php echo $targetPrice ?>"

                 class="catalog-item__phone">Показать номер
            </div>

        <?php endif; ?>

    </div>
</div>