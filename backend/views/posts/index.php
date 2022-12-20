<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Posts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анкеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div onclick="start_all()" class="start-all btn btn-success">Одобрить все(На странице)</div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?php \yii\widgets\Pjax::begin([
        'id' => 'my_pjax',
        'options' => [
            'data-pjax-push-state' => 'my_pjax',
            'data-pjax-container' => 'my_pjax',
        ]
    ]); ?>

    <?= GridView::widget([
        'layout' => "{summary}\n{pager}\n{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    switch ($user['status']) {
                        case \frontend\modules\user\models\Posts::POST_ON_MODARATION_STATUS:
                            $data = '<div class="check-text start-post" data-id="' . $user['id'] . '" onclick="check_anket(this)">Ожидает проверки</div>';
                            return $data;
                        case \frontend\modules\user\models\Posts::POST_ON_PUPLICATION_STATUS:
                            return "Публикуется";
                        case \frontend\modules\user\models\Posts::POST_DONT_PUBLICATION_STATUS:
                            return "Не публикуется";
                        case \frontend\modules\user\models\Posts::RETURNED_FOR_REVISION:
                            return "Анкета на доработке";
                    }

                    return 'Ошибка';

                },
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    $user->getCity();
                    return Html::a($user['name'],
                        'http://' . $user->city->url . '.' . Yii::$app->params['site_name'] . '/post/' . $user['id'],
                        ['target' => '_blank']
                    );
                },
            ],
            [
                'attribute' => 'city_id',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    $user->getCity();
                    return $user->city->city;
                },
            ],

            [
                'attribute' => 'Аватар',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    $file = $user->avatar->file;
                    return Html::img('http://moskva.' . Yii::$app->params['site_name'] . $file,
                        ['width' => '50px', 'loading' => 'lazy']
                    );
                },
            ],

            [
                'attribute' => 'П. фото',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    if (isset($user->checkPhoto->file))
                    return Html::img('http://moskva.' . Yii::$app->params['site_name'] . $user->checkPhoto->file,
                        ['width' => '50px', 'loading' => 'lazy']
                    );
                },
            ],

            'phone',
            'price',
            'user_id',
            'advert_phone_view_count',
            [
                'attribute' => 'КПН',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $user \frontend\modules\user\models\Posts */
                    return \frontend\modules\user\helpers\ViewCountHelper::countView($user->id, Yii::$app->params['redis_view_phone_count_key']);
                },
            ],

            [
                'class' => 'backend\components\ActionColumnExtends',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash">
<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 5.5C4.77614 5.5 5 5.72386 5 6V12C5 12.2761 4.77614 12.5 4.5 12.5C4.22386 12.5 4 12.2761 4 12V6C4 5.72386 4.22386 5.5 4.5 5.5Z" fill="black"/>
                    <path d="M7 5.5C7.27614 5.5 7.5 5.72386 7.5 6V12C7.5 12.2761 7.27614 12.5 7 12.5C6.72386 12.5 6.5 12.2761 6.5 12V6C6.5 5.72386 6.72386 5.5 7 5.5Z" fill="black"/>
                    <path d="M10 6C10 5.72386 9.77614 5.5 9.5 5.5C9.22386 5.5 9 5.72386 9 6V12C9 12.2761 9.22386 12.5 9.5 12.5C9.77614 12.5 10 12.2761 10 12V6Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 3C13.5 3.55228 13.0523 4 12.5 4H12V13C12 14.1046 11.1046 15 10 15H4C2.89543 15 2 14.1046 2 13V4H1.5C0.947715 4 0.5 3.55228 0.5 3V2C0.5 1.44772 0.947715 1 1.5 1H5C5 0.447715 5.44772 0 6 0H8C8.55229 0 9 0.447715 9 1H12.5C13.0523 1 13.5 1.44772 13.5 2V3ZM3.11803 4L3 4.05902V13C3 13.5523 3.44772 14 4 14H10C10.5523 14 11 13.5523 11 13V4.05902L10.882 4H3.11803ZM1.5 3V2H12.5V3H1.5Z" fill="black"/>
                    </svg>
</span>', false, [
                            'class' => 'pjax-delete-link',
                            'delete-url' => $url,
                            'onclick' => 'delete_item(this)',
                            'pjax-container' => 'my_pjax',
                            'title' => Yii::t('yii', 'Delete')
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>


</div>
