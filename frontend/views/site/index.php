<?php

/* @var $this yii\web\View */
/* @var $prPosts array */
/* @var $newPosts array */
/* @var $checkPosts array */
/* @var $webmaster array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $topPostList array */
/* @var $cityInfo array */

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

if (isset($webmaster))

    Yii::$app->view->registerMetaTag([
        'name' => 'yandex-verification',
        'content' => $webmaster['tag']
    ]);

if (isset($microdataForMainPage)) echo $microdataForMainPage;

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
            <div data-url="/" class="col-12"></div>
        </div>

        <div class="row catalog__items first-content">

            <?php

            $i = 0;

            if ($topPostList) {
                foreach ($topPostList as $post) {
                    echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $post,
                        'advertising' => true,
                        'i' => $i,
                    ]);

                    $i++;

                }
            }

            ?>

            <?php foreach ($prPosts as $post) : ?>

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

        <?php if (Yii::$app->requestedParams['city'] == 'moskva' and !Yii::$app->request->get('page')) : ?>

            <h2>Как найти проститутку в Москве?</h2>
            <p>Найти проститутку в Москве можно на нашем сайте, у нас представлены анкеты проверенных индивидуалок в широком
                спектре цен. Смотрите анкеты и звоните по номерам шлюх</p>

            <h2>Как вызвать индивидуалку в Москве?</h2>
            <p>Для того что бы вызвать индивидуалку нужно найти инкету со стикером "индивидуалка" и позвонить по номеру в анкете</p>

            <h2>Где найти проститутку в Москве?</h2>
            <p>В основном девушки размещают свой рекламу в интернете но могут и стоять на улицах</p>

            <h2>Когда звонить проститутке в Москве?</h2>
            <p>У каждой девушки свой график работы</p>

        <?php endif; ?>

    </div>
</div>
