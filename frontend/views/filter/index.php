<?php

/* @var $this \yii\web\View */
/* @var $posts array */
/* @var $more_posts array */
/* @var  $topPostList array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $param string */
/* @var $postsWithVideo \frontend\modules\user\models\Posts[] */

/* @var $pages \yii\data\Pagination */

use frontend\modules\user\helpers\ViewCountHelper;
use yii\bootstrap4\LinkPager;

if (Yii::$app->request->get('page')) {

    $des .= ' | Страница ' . Yii::$app->request->get('page');

    $title .= ' | Страница ' . Yii::$app->request->get('page');

}

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

echo \frontend\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://' . Yii::$app->params['site_addr'] . '/img/logo.png',
]);

?>

<div class="filter__catalog">
    <div class="container">
        <div class="row filter__bottom">
            <div class="filter-sort__left">
                <h1 class="filter-sort__title"> <?php echo $h1 ?> </h1>
                <div class="filter-sort__btn" data-filter-btn>
                    <svg>
                        <use xlink:href='/svg/dest/stack/sprite.svg#filter'></use>
                    </svg>
                    Фильтр
                </div>
            </div>

            <?php echo \frontend\widgets\SortingWidget::widget() ?>

        </div>
    </div>
</div>
<div class="catalog">
    <div class="container">

        <div class="row">
            <div data-url="<?php echo Yii::$app->request->url ?>" class="col-12"></div>
        </div>

        <?php if ($postsWithVideo) : ?>

            <div class="popular-list d-flex">

                <?php foreach ($postsWithVideo as $item) : ?>
                    <?php $thumbSrc = Yii::$app->imageCache->thumbSrc($item->avatar->file, '77'); ?>
                    <a data-video
                       href="<?php echo $item->video ?>"
                       data-link="/post/<?php echo $item->id ?>"
                       data-img="<?php echo $thumbSrc ?>"
                       class="popular-list-item">

                        <img src="<?php echo $thumbSrc ?>" alt="">
                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <div class="row catalog__items first-content">

            <?php if ($topPostList) {

                foreach ($topPostList as $post) {

                    echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $post,
                        'advertising' => true,
                    ]);

                }

                unset($post);

            } ?>

            <?php if ($posts) foreach ($posts as $post) : ?>

                <?php if (isset($post['id'])) : ?>

                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $post,
                    ]); ?>

                <?php elseif (isset($post['block'])) : ?>

                    <?php if (isset($post['block']['header'])) : ?>

                        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), [
                            'post' => $post['block'],
                            'promo' => true,
                        ]); ?>

                    <?php else : ?>

                        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                            'post' => $post['block']['post'],
                            'promo' => true,
                        ]); ?>

                    <?php endif; ?>

                <?php endif; ?>

            <?php endforeach; ?>

        </div>

        <div class="row content-post catalog__items"></div>

        <?php if ($more_posts) : ?>

            <div class="col-12">
                <p>Рекомендуем посмотреть:</p>
            </div>

            <div class="row catalog__items">

                <?php foreach ($more_posts as $post) : ?>

                    <?php ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']); ?>

                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <div class="row">
            <div class="col-12 pager" data-page="<?php echo Yii::$app->request->get('page') ?? 1 ?>"
                 data-adress="<?php echo Yii::$app->request->url ?>"
                 data-reqest="<?php echo Yii::$app->request->url ?>"></div>
        </div>

        <?php if ($pages) {

            $pagination = LinkPager::widget([
                'pagination' => $pages,
            ]);

            echo str_replace('http:', 'https:', $pagination);

        } ?>

    </div>
</div>
<div class="modal-video">
    <div class="modal-video__header">
        <div class="modal-video__close">
            <svg>
                <use xlink:href='svg/dest/stack/sprite.svg#close'></use>
            </svg>
        </div>
    </div>
    <div class="modal-video__body">
        <a class="video-link" href="">
            <img class="video-img" src="" alt="">
            Просмотреть профиль</a>
        <video src="" controls></video>
    </div>
</div>