<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $model \frontend\modules\user\models\forms\ObmenkaPayForm */
/* @var $this \yii\web\View */

$this->title = 'Баланс';

?>

<div class="row">

    <div class="col-12 col-xl-9 content">

        <h1 class="mb-4"><?php echo $this->title ?></h1>

        <div class="pay-from-wrap">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
            ]) ?>

            <?= $form->field($model, 'sum')->textInput(['value' => 300]) ?>


            <?= $form->field($model, 'currency')
                ->radioList(ArrayHelper::map(\common\models\ObmenkaCurrency::find()->all(), 'id', 'name'),
                    [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $chec = '';
                        $return = '<span>';
                        if ($index == 0) $chec = 'checked';
                        $return .= '<input '.$chec.' id="'.mb_strtolower($label).'_label-id" type="radio" name="' . $name . '" value="' . $value . '" tabindex="'.$index.'">';
                        $return .= '<label for="'.mb_strtolower($label).'_label-id" class="modal-radio '.mb_strtolower($label).'_label img-label-radio">';
                        $return .= '</label>';
                        $return .= '</span>';

                        return $return;
                    }
                ])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'type-btn']) ?>
            </div>

            <?php ActiveForm::end() ?>

        </div>

    </div>

</div>
