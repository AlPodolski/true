<?php

/* @var $this \yii\web\View */
/* @var $prPosts array */
/* @var $name string */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */

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

        <div class="row catalog__items first-content">

            <?php if ($prPosts) : foreach ($prPosts as $post) : ?>

                <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

            <?php endforeach; ?>

            <?php else : ?>

                <div class="col-12">
                    <p class="alert alert-info">По вашему запросу ничего не найдено попробуйте поискать другое имя</p>
                </div>

            <?php endif; ?>

        </div>

        <div class="row content-post catalog__items"></div>

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

        }?>

    </div>
</div>
