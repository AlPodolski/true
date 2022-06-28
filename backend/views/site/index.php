<?php

/* @var $this yii\web\View */
/* @var $payCountWeek \common\models\CashCount[] */
/* @var $registerCountWeek \common\models\PostCount[] */
/* @var $monthCash int */
/* @var $monthRegister int */

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Пополнения</p>

                        <?php if ($payCountWeek) foreach ($payCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date.' - '.$item->count);

                        }else echo '-'?>

                        <?php if ($monthCash) : ?>

                            <p>Месяц <?php echo $monthCash ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Анкеты</p>

                        <?php if ($registerCountWeek) foreach ($registerCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date.' - '.$item->count);

                        }else echo '-'?>

                        <?php if ($monthRegister) : ?>

                            <p>Месяц <?php echo $monthRegister ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
