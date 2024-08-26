<?php

/* @var $this yii\web\View */
/* @var $payCountWeek \common\models\CashCount[] */
/* @var $registerCountWeek \common\models\PostCount[] */
/* @var $blockData \common\models\CityBlock */
/* @var $registerUserCountWeek \common\models\UserCountRegister[] */
/* @var $ipPhoneViewCount \backend\models\IpPhoneCount[] */
/* @var $monthCash int */
/* @var $monthRegister int */
/* @var $monthUserRegister int */
/* @var $realPostCount int */
/* @var $postOnPublication int */

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Сайты</p>

                        <?php if ($sites) foreach ($sites as $item) {

                            echo \yii\helpers\Html::tag('p', $item->domain);

                        } ?>

                    </div>

                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Пополнения</p>

                        <?php if ($payCountWeek) foreach ($payCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                        <?php if ($monthCash) : ?>

                            <p>Месяц <?php echo $monthCash ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Списания</p>

                        <?php if ($spisaniyaCountWeek) foreach ($spisaniyaCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                        <?php if ($monthCashSpis) : ?>

                            <p>Месяц <?php echo $monthCashSpis ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Анкеты</p>

                        <?php if ($registerCountWeek) foreach ($registerCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                        <?php if ($monthRegister) : ?>

                            <p>Месяц <?php echo $monthRegister ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Пользователи</p>

                        <?php if ($registerUserCountWeek) foreach ($registerUserCountWeek as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                        <?php if ($monthUserRegister) : ?>

                            <p>Месяц <?php echo $monthUserRegister ?></p>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Просмотр телефонов через апи</p>

                        <?php if ($ipPhoneViewCount) foreach ($ipPhoneViewCount as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Просмотр телефонов</p>

                        <?php if ($totalPhoneView) foreach ($totalPhoneView as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Просмотр телефонов реальных пользователей</p>

                        <?php if ($userPhoneView) foreach ($userPhoneView as $item) {

                            echo \yii\helpers\Html::tag('p', $item->date . ' - ' . $item->count);

                        } else echo '-' ?>

                    </div>

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">

                        <p>Настоящих анкет</p>

                        <?php echo $realPostCount ?>

                        <p>Настоящих анкет на публикации</p>

                        <?php echo $postOnPublication ?>

                    </div>

                </div>
            </div>

            <div class="col-12">

                <?php if ($blockDomains) : ?>

                <h2>Блокировки доменов</h2>

                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Домен</th>
                            <th scope="col">Дата обнаружения</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($blockDomains as $item) : ?>

                            <tr>
                                <th scope="row"><?php echo $item->id ?> </th>
                                <td>
                                    <?php echo $item->domain ?>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d H', $item->created_at)  ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                <?php endif; ?>

            </div>

            <div class="col-12">

                <?php if ($blockData) : ?>

                <h2>Блокировки</h2>

                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Старый урл</th>
                            <th scope="col">Новый урл</th>
                            <th scope="col">Ид города</th>
                            <th scope="col">Дата обнаружения</th>
                            <th scope="col">Статус</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($blockData as $item) : ?>

                            <tr>
                                <th scope="row"><?php echo $item->id ?> </th>
                                <td>
                                    <?php echo $item->old_city ?>
                                </td>
                                <td>
                                    <?php echo $item->new_city ?>
                                </td>
                                <td>
                                    <?php echo $item->city_id ?>
                                </td>

                                <td>
                                    <?php echo date('Y-m-d H:i:s', $item->created_at )  ?>
                                </td>

                                <td>
                                    <?php if ($item->check->actual_city and $item->check->actual_city == $item->new_city ) : ?>

                                        Проверенно

                                    <?php else : ?>

                                        <div onclick="checkCity(this)" data-id="<?php echo $item->check->id ?>"
                                             data-new="<?php echo $item->new_city ?>" class="check-city">Проверить</div>

                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                <?php endif; ?>

            </div>

        </div>

    </div>
</div>
