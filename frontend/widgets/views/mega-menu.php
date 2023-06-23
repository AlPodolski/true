<?php

/* @var $hairColorList \common\models\HairColor[] */
/* @var $nationalList \common\models\National[] */
/* @var $placeList \common\models\Place[] */
/* @var $rayon \common\models\Rayon[] */
/* @var $metro \frontend\models\Metro[] */
/* @var $timeList \common\models\Time[] */
/* @var $rostList \common\models\Rost[] */

/* @var $ves \common\models\Rost[] */

use yii\helpers\Html;

?>

<div class="row filter__top">
    <div class="filter__search-params filter-search-params">
        <div class="filter-search-params__text">
            <span>Поиск по параметрам</span>
            <svg>
                <use xlink:href='/svg/dest/stack/sprite.svg#arrow-nav'></use>
            </svg>
        </div>
        <div class="filter__close" data-filter-btn>
            <svg>
                <use xlink:href='/svg/dest/stack/sprite.svg#close-icon'></use>
            </svg>
        </div>
        <div class="filter-search-params__drop">
            <div class="filter-search-params__drop-mob">
                <div class="filter-search-params__drop-mob-close" data-params-btn>
                    <svg>
                        <use xlink:href='/svg/dest/stack/sprite.svg#close-icon'></use>
                    </svg>
                </div>
                <div class="filter-search-params__drop-mob-title">
                    Каталог
                </div>
            </div>
            <div class="filter-search-params__left">
                <div class="filter-search-params__title">
                    Поиск по акетам
                    <svg>
                        <use xlink:href='/svg/dest/stack/sprite.svg#arrow-nav'></use>
                    </svg>
                </div>
                <ul class="filter-search-params__main-list">
                    <li data-params-tab-title class="active">
                        Параметры
                        <svg>
                            <use xlink:href='/svg/dest/stack/sprite.svg#arrow-nav'></use>
                        </svg>
                    </li>
                    <?php if ($metro) : ?>
                        <li data-params-tab-title>
                            <a href="/metro">Метро</a>
                        </li>
                    <?php endif; ?>

                    <li data-params-tab-title>
                        <?php if ($rayon) : ?>
                            <a href="/rayon">Район</a>
                        <?php endif; ?>

                    </li>
                    <li data-params-tab-title>
                        <a href="/usluga">Услуги</a>
                    </li>

                    <li data-params-tab-title>
                        <a href="/deshevye-prostitutki">Дешевые</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/favorite/list">Избранное</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/elitnye-prostitutki">Элитные</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/phone">Телефоны</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/mesto-viezd">На выезд</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/novie">Новые анкеты</a>
                    </li>
                    <li data-params-tab-title>
                        <a href="/salon">Интим салоны</a>
                    </li>
                </ul>
            </div>
            <div class="filter-search-params__right">
                <div class="filter-search-params__tab active" data-params-tab-content>
                    <div class="filter-search-params__right-top">
                        <ul class="filter-search-params__list">
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">Волосы</div>
                                <ul class="filter-search-params__item-list">

                                    <?php foreach ($hairColorList as $hairColorItem) {

                                        echo '<li>';

                                        echo Html::a($hairColorItem['value'], '/cvet-volos-' . $hairColorItem['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>

                                </ul>
                            </li>
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">Цена</div>
                                <ul class="filter-search-params__item-list">

                                    <?php $tempData = array(
                                        array('url' => 'do-1500', 'value' => 'До 1500 руб.'),
                                        array('url' => 'ot-3000-do-6000', 'value' => 'От 3000 до 6000 руб.'),
                                        array('url' => 'ot-6000', 'value' => 'От 6000 руб.'),
                                    ); ?>

                                    <?php

                                    echo Html::a('Дешевые(до 3000)', '/deshevye-prostitutki', [
                                        'class' => 'sub-menu-block-item'
                                    ]);

                                    foreach ($tempData as $hairColorItem) {

                                        echo '<li>';

                                        echo Html::a($hairColorItem['value'], '/cena-' . $hairColorItem['url']);

                                        echo '</li>';

                                    } ?>

                                </ul>
                            </li>
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">Место встречи:</div>
                                <ul class="filter-search-params__item-list">
                                    <?php foreach ($placeList as $hairColorItem) {

                                        echo '<li>';

                                        echo Html::a($hairColorItem['value'], '/mesto-' . $hairColorItem['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>

                                </ul>
                            </li>
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">Возраст</div>
                                <ul class="filter-search-params__item-list">
                                    <li><a class="sub-menu-block-item" href="/vozrast-18-20">От 18 до 20 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-21-25">От 21 до 25 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-26-30">От 26 до 30 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-31-35">От 31 до 35 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-36-40">От 36 до 40 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-40-50">От 40 до 50 лет</a></li>
                                    <li><a class="sub-menu-block-item" href="/vozrast-50-75">От 50 до 75 лет</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-search-params__right-bottom">
                        <ul class="filter-search-params__list filter-search-params__list--horz">
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">
                                    Время:
                                </div>
                                <ul class="filter-search-params__item-list">

                                    <?php foreach ($timeList as $item) {

                                        echo '<li>';

                                        echo Html::a($item['value'], '/vremya-' . $item['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>

                                </ul>
                            </li>
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">
                                    Рост:
                                </div>
                                <ul class="filter-search-params__item-list">

                                    <?php foreach ($rostList as $item) {

                                        echo '<li>';

                                        echo Html::a($item['value'], '/rost-' . $item['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>

                                </ul>
                            </li>
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">
                                    Вес:
                                </div>
                                <ul class="filter-search-params__item-list">
                                    <?php foreach ($ves as $item) {

                                        echo '<li>';

                                        echo Html::a($item['value'], '/ves-' . $item['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>
                                </ul>
                            </li>
                        </ul>
                        <ul class="filter-search-params__list filter-search-params__list--str">
                            <li class="filter-search-params__item">
                                <div class="filter-search-params__item-title">
                                    Национальность:
                                </div>
                                <ul class="filter-search-params__item-list">

                                    <?php foreach ($nationalList as $hairColorItem) {

                                        echo '<li>';

                                        echo Html::a($hairColorItem['value'], '/nacionalnost-' . $hairColorItem['url'], [
                                            'class' => 'sub-menu-block-item'
                                        ]);

                                        echo '</li>';

                                    } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo \frontend\widgets\FilterWidget::widget(['dataGet' => Yii::$app->request->get()]); ?>

</div>