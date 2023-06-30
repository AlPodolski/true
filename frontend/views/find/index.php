<?php

/* @var $this \yii\web\View */
/* @var $posts array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $param string */

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
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
            <?php echo '<div data-url="/'.$param.'" class="col-12"></div>'; ?>
        </div>

        <div class="row catalog__items first-content">

            <?php if (is_array($posts) and $posts) : ?>

                <?php foreach ($posts as $post) : ?>

                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

                <?php endforeach; ?>

            <?php else : ?>

                <div class="col-12">
                    <p class="alert alert-info">по таким параметрам ничего нет  измените  начтройки  фильтра</p>
                </div>

            <?php endif; ?>

        </div>

        <?php if ($posts and count($posts) > 6) : ?>

        <div class="row content-post catalog__items"></div>

        <div class="row">
            <div class="col-12 pager" data-page="1"
                 data-url="<?php echo Yii::$app->request->url ?>"
                 data-adress="<?php echo Yii::$app->request->url ?>"
                 data-reqest="<?php echo Yii::$app->request->url ?>"></div>
        </div>

        <?php endif; ?>

    </div>
</div>