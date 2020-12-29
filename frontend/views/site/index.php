<?php

/* @var $this yii\web\View */
/* @var $prPosts array */
/* @var $newPosts array */
/* @var $checkPosts array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */

$this->title = $title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

?>
<div class="container custom-container">
<div class="popular-btn-block">
    <a href="/cena-do-1500" class="popular-btn">Дешевые</a>
    <a class="popular-btn" href="/video">С видео</a>
    <a class="popular-btn" href="/mesto-viezd">Выезд</a>
</div>
<div class="row">
    <div class="col-12">
        <div class="text-block">
            Внимание!!! Мы создали портал который обеденяет
            всех любителей индивидуалок и поможет отличить
            фейковые анкеты от нормальных. Присоеденяйтесь
            к нам и делитесь проверенной информацией о
            телефонах и анкетах. Вместе мы сделаем этот рынок
            честным. Если вы первый раз на сайте прочитайте
            статьи котрые мы для вас подготовили.
        </div>
    </div>
</div>
<h1> Проститутки Москвы </h1>

    <div class="row">

        <div data-url="/" class="col-12"></div>

        <?php $i = 0 ?>

        <?php foreach ($prPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post'  => $post,
                'countPost' => $i,
            ]); ?>

            <?php $i++?>

        <?php endforeach; ?>

    </div>

    <div class="row">
        <div class="col-12 main-text">
            <p class="big-red-text">
                Проверенные проститутки с
                высоким рейтингом
            </p>

            <p class="black-text">
                Рейтинг составляется на основе алгоритма
                и ручной модерации мы выбираем только
                качественные анкеты со всего интернета
                что бы показать их вам.
            </p>
        </div>
    </div>

    <div class="row">

        <?php $i = 0 ?>

        <?php foreach ($checkPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), [
                    'post'      => $post,
                    'countPost' => $i,
            ]); ?>

            <?php $i++?>

        <?php endforeach; ?>

        <div class="red-btn-wrap col-12">
            <a class="red-btn" href="/proverennye">Перейти<img src="/img/up-arrow1.png"></a>
        </div>

    </div>

    <div class="row">
        <div class="col-12 main-text">
            <p class="big-red-text">
                Новые анкеты индивидуалок
            </p>
            <p class="black-text">
                Самый свежак номеров которые только появились на сайте
            </p>
        </div>
    </div>

    <div class="row">

        <?php $i = 0 ?>

        <?php foreach ($newPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), [
                        'post'  => $post,
                    'countPost' => $i,
            ]); ?>

            <?php $i++?>

        <?php endforeach; ?>

        <div class="red-btn-wrap col-12">
            <a class="red-btn" href="/novie">Перейти<img src="/img/up-arrow1.png"></a>
        </div>

    </div>


    <div class="row content"></div>
    <svg class="filter" version="1.1">
        <defs>
            <filter id="gooeyness">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10" result="gooeyness" />
                <feComposite in="SourceGraphic" in2="gooeyness" operator="atop" />
            </filter>
        </defs>
    </svg>
    <div class="dots">
        <div class="dot mainDot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="row">
        <div class="col-12 pager" data-page="1" data-url="<?php echo Yii::$app->request->url ?>" data-reqest="<?php echo Yii::$app->request->url ?>"></div>
    </div>

</div>