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
<div class="popular-btn-block">
    <a href="/cena-do-1500" class="popular-btn">Дешевые</a>
    <a class="popular-btn" href="/video">С видео</a>
    <a class="popular-btn" href="/cena-ot-6000">Элитные</a>
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

        <?php foreach ($prPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

        <?php endforeach; ?>

    </div>

    <div class="row">
        <div class="col-12">
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

        <?php foreach ($checkPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), ['post' => $post]); ?>

        <?php endforeach; ?>

        <div class="red-btn-wrap col-12">
            <a class="red-btn" href="/proverennye">Перейти<img src="/img/up-arrow1.png"></a>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <p class="big-red-text">
                Новые анкеты индивидуалок
            </p>
            <p class="black-text">
                Самый свежак номеров которые только появились на сайте
            </p>
        </div>
    </div>

    <div class="row">

        <?php foreach ($newPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), ['post' => $post]); ?>

        <?php endforeach; ?>

        <div class="red-btn-wrap col-12">
            <a class="red-btn" href="/">Перейти<img src="/img/up-arrow1.png"></a>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <p class="big-red-text">
                Индивидуалки рядом
                со мной
            </p>
        </div>
    </div>
    <article class="post map">
        <div class="post-img position-relative">
            <img src="/img/map.png" alt="">
            <div class="post-rating">
                <div class="geo-bg">
                </div>
            </div>
            <div class="pin-wrap">
                <div class="pin" style="top: 250px;left: 100px;">
                    <img src="/img/pin.png" alt="">
                </div>
                <div class="pin" style="top: 367px;left: 100px;">
                    <img src="/img/pin.png" alt="">
                </div>
                <div class="pin" style="top: 357px;left: 130px;">
                    <img src="/img/pin.png" alt="">
                </div>
                <div class="pin" style="top: 315px;left: 130px;">
                    <img src="/img/pin.png" alt="">
                </div>
            </div>
            <div class="user-on-map position-absolute d-flex">
                <div class="user-map-img">
                    <img src="/img/small-girl-map.png" alt="">
                </div>
                <div class="user-map-info">
                    <div class="name">Лариса</div>
                    <div class="post-address">
                        <div class="geo-icon icon">
                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.50001 0C2.84583 0 1.5 1.34583 1.5 3.00001C1.5 3.49659 1.62415 3.98895 1.86018 4.42566L4.33595 8.90332C4.36891 8.96302 4.43172 9 4.50001 9C4.5683 9 4.6311 8.96302 4.66406 8.90332L7.14075 4.42419C7.37586 3.98895 7.50001 3.49657 7.50001 2.99999C7.50001 1.34583 6.15418 0 4.50001 0ZM4.50001 4.5C3.67292 4.5 3.00001 3.82709 3.00001 3.00001C3.00001 2.17292 3.67292 1.50001 4.50001 1.50001C5.32709 1.50001 6 2.17292 6 3.00001C6 3.82709 5.32709 4.5 4.50001 4.5Z" fill="white"/>
                            </svg>
                        </div>м. Авиамоторная</div>
                </div>
            </div>
        </div>
        <div class="red-btn-wrap">
            <a class="red-btn" href="#">Поиск<img src="/img/up-arrow1.png" alt=""></a>
        </div>
    </article>