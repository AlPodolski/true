<?php

/* @var $this yii\web\View */
/* @var $payCountWeek \common\models\CashCount[] */
/* @var $monthCash int */

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Пополнения</p>

                        <?php if ($payCountWeek) foreach ($payCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date.'-'.$item->count);

                        }else echo '-'?>

                        <p>Месяц <?php echo $monthCash ?></p>

                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
