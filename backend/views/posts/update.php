<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Posts */
/* @var $postMessageModel \common\models\PostMessage */

$this->title = 'Обновить анкету: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="posts-update">

    <h1>Обновить анкету: <?php echo Html::a($model->name,
            'http://moskva.'.Yii::$app->params['site_name'] .'/post/'.$model->id,
            ['target' => '_blank']) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'postMessageModel' => $postMessageModel,
    ]) ?>

</div>
