<?php

/* @var $this \yii\web\View */
/* @var $requestCalls array */

$this->title = 'Обратный звонок';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">

    <div class="row">

        <div class="col-12">

            <div class="white-cabinet-block cabinet-nav-block margin-top-20">

                <h1><?php echo $this->title ?></h1>

                <?php foreach ($requestCalls as $call) : ?>

                    <div class="row">

                        <div class="col-12">

                            <div class="event-item">

                                <div class="row">


                                    <div class="col-12 d-flex align-center event-content">

                                        <div class="small-text">

                                            <?php

                                            switch ($call['status']) {
                                                case \common\models\RequestCall::REQUEST_NOT_VIEW:
                                                    echo "Новая заявка на звонок";
                                                    break;
                                                case \common\models\RequestCall::REQUEST_VIEW:
                                                    echo "Заявка на звонок";
                                                    break;
                                            }

                                            ?>

                                            <?php echo \yii\helpers\Html::a($call['phone'], 'tel:+' . $call['phone']) ?>
                                            .
                                            <?php if ($call['text']) echo 'Комментарий к заявке: ' . $call['text'] ?>

                                            <br>

                                            <span class="event-date">
                                                Создана :
                                                        <?php

                                                        if ($call['created_at']) {

                                                            if (date('Ymd', $call['created_at']) == date('Ymd', time())) {

                                                                echo 'Сегодня ' . date('H:m', $call['created_at']);

                                                            } else {

                                                                echo date('Y-m-d H:i:s', $call['created_at']);

                                                            }

                                                        }

                                                        if ($call['created_at'] != $call['updated_at']) {

                                                            echo ' Просмотрена: ';

                                                            echo date('Y-m-d H:i:s', $call['updated_at']);

                                                        }

                                                        ?>
                                            </span>

                                            <br>

                                            <div class="action-btns">
                                                <span class="get-num-info-btn" onclick="check_number(this)" data-number="<?php echo $call['phone'] ?>">
                                                    Проверить номер
                                                </span>
                                                
                                                <span class="get-num-info-btn">
                                                    <a class="get-num-info-btn" href="/cabinet/phone/add-review?phone=<?php echo $call['phone'] ?>">Добавить отзыв</a>
                                                </span>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</div>