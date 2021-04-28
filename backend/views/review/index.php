<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            [
                'attribute' => 'post_id',
                'format' => 'raw',
                'value' => function ($review) {

                    /* @var $review \frontend\modules\user\models\Review */

                    $post = \frontend\modules\user\models\Posts::find()
                        ->where(['id' => $review->post_id])
                        ->with('avatar')
                        ->limit(1)
                        ->one();

                    $file = $post['avatar']['file'];

                    $img = Html::img('http://moskva.' . Yii::$app->params['site_name'] . $file, ['width' => '50px']);

                    return Html::a($img,
                        'http://moskva.' . Yii::$app->params['site_name'] . '/post/' . $post['id'],
                        ['target' => '_blank']
                    );

                },
            ],
            'author',
            [
                'attribute' => 'text',
                'format' => 'raw',
                'value' => function ($review) {

                    /* @var $review \frontend\modules\user\models\Review */

                    if (mb_strlen($review->text) > 122) return mb_substr($review->text, 0, 122) . '...';

                    return $review->text;

                },
            ],
            'photo_marc',
            'total_marc',
            'clean',
            /*            [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function ($review) {

                                return date("Y-m-d H:i:s", $review->created_at);

                            },
                        ],*/
            [
                'attribute' => 'is_moderate',
                'format' => 'raw',
                'value' => function ($review) {

                    /* @var $review \frontend\modules\user\models\Review */

                    switch ($review->is_moderate) {

                        case \frontend\modules\user\models\Review::ON_MODARATE :
                            return '<span data-id="' . $review->id . '" onclick="check_review(this)" class="check-text">Подтвердить</span>';

                        case \frontend\modules\user\models\Review::MODARATE :
                            return 'Проверен';

                    }

                },
            ],

            [
                'attribute' => 'Удалить',
                'format' => 'raw',
                'value' => function ($review) {

                    /* @var $review \frontend\modules\user\models\Review */

                    return '<span data-id="' . $review->id . '" onclick="remove_review(this)" class="remove-text">Удалить</span>';

                },
            ],

            ['class' => 'backend\components\ActionColumnExtends'],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>


</div>
