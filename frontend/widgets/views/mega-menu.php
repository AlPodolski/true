<?php

/* @var $hairColorList \common\models\HairColor[] */
/* @var $nationalList \common\models\National[] */
/* @var $placeList \common\models\Place[] */
/* @var $rayon \common\models\Rayon[] */
/* @var $metro \frontend\models\Metro[] */

use yii\helpers\Html;

?>
<div class="mega-menu-widget position-relative">
    <div class="menu-heading-wrap">
        <svg class="m-right-15" width="20" height="20" viewBox="0 0 20 20" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M20 14.4444H0V16.6667H20V14.4444Z" fill="#F74952"></path>
            <path d="M20 8.88892H0V11.1112H20V8.88892Z" fill="#F74952"></path>
            <path d="M20 3.33334H0V5.55558H20V3.33334Z" fill="#F74952"></path>
        </svg>
        <span class="m-right-15 metro-search-btn ">Выбрать анкету</span>
        <svg class="m-left-25" width="19" height="10" viewBox="0 0 32 20" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_114_4)">
                <path d="M1.60863 3.72732L3.98258 1.19739L16.6432 14.0472L28.9869 0.892589L31.4218 3.36389L19.0781 16.5185L16.7042 19.0485L1.60863 3.72732Z"
                      fill="#F74952"/>
            </g>
            <defs>
                <clipPath id="clip0_114_4">
                    <rect width="18" height="30" fill="white" transform="translate(1.12793 19.197) rotate(-90.6984)"/>
                </clipPath>
            </defs>
        </svg>
    </div>
    <div class="drop-menu-list position-absolute">
        <div class="drop-menu-list-item">
            Поиск по параметрам
            <svg class="m-left-25" width="10" height="15" viewBox="0 0 10 15" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_114_4)">
                    <path d="M2.24979 14.6416L1.00721 13.4744L7.25699 7.18819L0.796085 1.11916L1.99805 -0.0898235L8.45895 5.97921L9.70153 7.14642L2.24979 14.6416Z"
                          fill="#5C5C5C"/>
                </g>
                <defs>
                    <clipPath id="clip0_114_4">
                        <rect width="8.79882" height="14.8248" fill="white"
                              transform="translate(9.81274 14.8432) rotate(179.021)"/>
                    </clipPath>
                </defs>
            </svg>
            <div class="drop-menu-list-sub-menu">

                <?php if ($hairColorList) : ?>

                    <div class="sub-menu-block">

                        <div class="sub-menu-block-heading">
                            Волосы
                        </div>

                        <?php foreach ($hairColorList as $hairColorItem) {

                            echo Html::a($hairColorItem['value'], '/cvet-volos-' . $hairColorItem['url'], [
                                'class' => 'sub-menu-block-item'
                            ]);

                        } ?>

                    </div>

                <?php endif; ?>

                <div class="sub-menu-block">

                    <div class="sub-menu-block-heading">
                        Цена:
                    </div>

                    <?php $tempData = array(
                        array('url' => 'do-1500', 'value' => 'До 1500 руб.'),
                        array('url' => 'ot-1500-do-2000', 'value' => 'От 1500 до 2000 руб.'),
                        array('url' => 'ot-2000-do-3000', 'value' => 'От 2000 до 3000 руб.'),
                        array('url' => 'ot-3000-do-6000', 'value' => 'От 3000 до 6000 руб.'),
                        array('url' => 'ot-6000', 'value' => 'От 6000 руб.'),
                    ); ?>

                    <?php foreach ($tempData as $hairColorItem) {

                        echo Html::a($hairColorItem['value'], '/cena-' . $hairColorItem['url'], [
                            'class' => 'sub-menu-block-item'
                        ]);

                    } ?>

                </div>

                <?php if ($placeList) : ?>

                    <div class="sub-menu-block">

                        <div class="sub-menu-block-heading">
                            Место встречи:
                        </div>

                        <?php foreach ($placeList as $hairColorItem) {

                            echo Html::a($hairColorItem['value'], '/mesto-' . $hairColorItem['url'], [
                                'class' => 'sub-menu-block-item'
                            ]);

                        } ?>

                    </div>

                <?php endif; ?>

                <div class="sub-menu-block">

                    <div class="sub-menu-block-heading">
                        Возраст
                    </div>

                    <a class="sub-menu-block-item" href="/vozrast-18-20">От 18 до 20 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-21-25">От 21 до 25 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-26-30">От 26 до 30 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-31-35">От 31 до 35 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-36-40">От 36 до 40 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-40-50">От 40 до 50 лет</a>
                    <a class="sub-menu-block-item" href="/vozrast-50-75">От 50 до 75 лет</a>

                </div>

                <?php if ($nationalList) : ?>

                    <div class="sub-menu-block big-sub-menu-block">

                        <div class="sub-menu-block-heading">
                            Национальность:
                        </div>

                        <?php foreach ($nationalList as $hairColorItem) {

                            echo Html::a($hairColorItem['value'], '/nacionalnost-' . $hairColorItem['url'], [
                                'class' => 'sub-menu-block-item'
                            ]);

                        } ?>

                    </div>

                <?php endif; ?>

            </div>
        </div>
        <?php if ($metro) : ?>
            <div data-type="metro" onclick="get_data(this)" class="drop-menu-list-item">
                <a >Метро</a>
            </div>
        <?php endif; ?>
        <?php if ($rayon) : ?>
            <div data-type="rayon" onclick="get_data(this)" class="drop-menu-list-item">
                <a >Район</a>
            </div>
        <?php endif; ?>
        <div data-type="usluga" onclick="get_data(this)" class="drop-menu-list-item">
            <a >Услуги</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/proverennye">Проверенные</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/cena-do-1500">Дешевые</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/favorite/list">Избранное</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/cena-ot-6000">Элитные</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/video">С Видео</a>
        </div>
        <div class="drop-menu-list-item">
            <a href="/mesto-viezd">На выезд</a>
        </div>
        <div class="drop-menu-list-item">
           <a class="small-red-text" href="/novie">Новые анкеты</a>
        </div>
        <?php if (Yii::$app->requestedParams['city'] == 'moskva') : ?>
            <div class="drop-menu-list-item">
                <a class="small-red-text" itemprop="url" href="/salon">Интим салоны</a>
            </div>
        <?php endif; ?>

    </div>
</div>