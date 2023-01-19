<?php

/* @var $model \frontend\modules\user\models\forms\PayForm */
/* @var $this \yii\web\View */
/* @var $searchModel backend\models\History */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


$this->title = 'Пополнить баланс';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="container">

    <div class="row">

        <div class="col-12">
            <h1 class="margin-top-20">Пополнить баланс</h1>
        </div>

        <?php if ($model->hasErrors()) : ?>

            <div class="alert alert-success">

            </div>

        <?php endif; ?>

        <div class="col-12 col-lg-4 col-md-6  ">
            <div class="balance-card">
                <div class="white-bold-text">Баланс</div>
                <div class=" big-white-text margin-top-20"><?php echo Yii::$app->user->identity['cash'] ?></div>
            </div>
        </div>

        <div class="col-12 col-lg-8 col-md-6">

            <div class="pay-form-wrap">

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]) ?>

                <p>Бонус <?php echo Yii::$app->params['pay_bonus_percent']?>% при пополнении от <?php echo Yii::$app->params['start_sum_for_bonus']?></p>

                <p>Средства могут зачисляться с задержкой, на отправку уведомления с платежной системы нужно немного времени</p>

                <?= $form->field($model, 'sum')->textInput(['value' => 500]) ?>


                <?= $form->field($model, 'currency')
                    ->radioList(ArrayHelper::map(\common\models\ObmenkaCurrency::find()->all(), 'id', 'name'),
                        [
                            'item' => function($index, $label, $name, $checked, $value) {
                                $chec = '';
                                $return = '<span>';
                                if ($index == 0) $chec = 'checked';
                                $return .= '<input '.$chec.' id="'.mb_strtolower($label).'_label-id" type="radio" name="' . $name . '" value="' . $value . '" tabindex="'.$index.'">';
                                $return .= '<label for="'.mb_strtolower($label).'_label-id" class="modal-radio '.mb_strtolower($label).'_label image-label-radio">';
                                $return .= '</label>';
                                $return .= '</span>';

                                return $return;
                            }
                        ])
                ?>

                <script defer src='https://www.google.com/recaptcha/api.js'></script>
                <div class="g-recaptcha" data-sitekey="6Lc6v2UiAAAAABk1eJQmDiW8N3FK8mDDxTSTr7bU"></div>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'orange-btn d-block']) ?>
                </div>

                <?php ActiveForm::end() ?>

            </div>

        </div>

        <div class="col-12">
            <h1 class="margin-top-20">История денежных операций</h1>
        </div>

        <div class="col-12 margin-top-20 table-history-pay">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'sum',
                    'balance',
                    [
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function ($history) {
                            /* @var $history \common\models\History */
                            switch ($history['type']) {
                                case \common\models\History::BALANCE_REPLENISHMENT:
                                    return  "Пополнение баланса";
                                case \common\models\History::UP_ANKET:
                                    return  "Поднятие анкеты";
                                case \common\models\History::BUY_VIEW:
                                    return  "Покупка просмотров";
                                case \common\models\History::POST_PUBLICATION:
                                    return  "Публикация анкеты";
                                case \common\models\History::POST_PUBLICATION_TELEGRAM:
                                    return  "Публикация в телеграм";
                            }

                            return 'Ошибка';

                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function ($history) {
                            /* @var $history \common\models\History */

                            return date('Y-m-d H:i:s', $history['created_at']);

                        },
                    ],

                ],
            ]); ?>
        </div>

    </div>

</div>


