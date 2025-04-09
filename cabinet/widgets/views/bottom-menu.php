<?php

use yii\helpers\Html;

/* @var $hairColorList \common\models\HairColor[] */
/* @var $nationalList \common\models\National[] */
/* @var $placeList \common\models\Place[] */
/* @var $rayon \common\models\Rayon[] */
/* @var $metro \cabinet\models\Metro[] */
/* @var $timeList \common\models\Time[] */
/* @var $rostList \common\models\Rost[] */
/* @var $ves \common\models\Rost[] */

?>
<div class="col-12 d-flex bottom-menu-wrap">

    <?php if ($hairColorList) : ?>

        <div class="sub-menu-block">

            <div class="sub-menu-block-heading">
                Цвет волос
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

    <?php if ($timeList) : ?>

        <div class="sub-menu-block big-sub-menu-block">

            <div class="sub-menu-block-heading">
                Время:
            </div>

            <?php foreach ($timeList as $item) {

                echo Html::a($item['value'], '/vremya-' . $item['url'], [
                    'class' => 'sub-menu-block-item'
                ]);

            } ?>

        </div>

    <?php endif; ?>

    <?php if ($rostList) : ?>

        <div class="sub-menu-block big-sub-menu-block">

            <div class="sub-menu-block-heading">
                Рост:
            </div>

            <?php foreach ($rostList as $item) {

                echo Html::a($item['value'], '/rost-' . $item['url'], [
                    'class' => 'sub-menu-block-item'
                ]);

            } ?>

        </div>

    <?php endif; ?>

    <?php if ($ves) : ?>

        <div class="sub-menu-block big-sub-menu-block">

            <div class="sub-menu-block-heading">
                Вес:
            </div>

            <?php foreach ($ves as $item) {

                echo Html::a($item['value'], '/ves-' . $item['url'], [
                    'class' => 'sub-menu-block-item'
                ]);

            } ?>

        </div>

    <?php endif; ?>

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

    <?php if ($metro) : ?>

        <div class="sub-menu-block big-sub-menu-block">

            <div class="sub-menu-block-heading">
                Метро:
            </div>

            <?php foreach ($metro as $hairColorItem) {

                if ($hairColorItem != end($metro)) $hairColorItem['value'].= ',';

                echo Html::a($hairColorItem['value'], '/metro-' . $hairColorItem['url'], [
                    'class' => 'sub-menu-block-item'
                ]);

            } ?>

        </div>

    <?php endif; ?>

    <?php if ($rayon) : ?>

        <div class="sub-menu-block big-sub-menu-block">

            <div class="sub-menu-block-heading">
                Район:
            </div>

            <?php foreach ($rayon as $hairColorItem) {

                if ($hairColorItem != end($rayon)) $hairColorItem['value'].= ',';

                echo Html::a($hairColorItem['value'], '/rayon-' . $hairColorItem['url'], [
                    'class' => 'sub-menu-block-item'
                ]);

            } ?>

        </div>

    <?php endif; ?>

</div>
