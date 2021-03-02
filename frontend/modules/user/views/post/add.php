<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */


$this->title = 'Добавить анкету';

\yii\helpers\Html::tag('h1', 'Редактирование анкеты');

echo $this->renderFile(Yii::getAlias('@user-view/post/_form.php'), [
    'post' => $post,
    'city' => $city,
]);