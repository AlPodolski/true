<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Жалобы на анкету';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anket-claim-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'post_id',
            [
                'attribute' => 'post_id',
                'format' => 'raw',
                'value' => function ($claim) {
                    /* @var $claim \common\models\AnketClaim */
                    $claim->getPost();

                    $img = Html::img('http://moskva.'.Yii::$app->params['site_name'] .$claim['post']['avatar']['file'], ['width' => '50px']);

                    return Html::a($img, 'http://moskva.'.Yii::$app->params['site_name'].'/post/'.$claim['post']['id'], ['target' => '_blank']) ;
                },
            ],
            [
                'attribute' => 'reason_id',
                'format' => 'raw',
                'value' => function ($claim) {

                    /* @var $claim \common\models\AnketClaim */

                    $claim->getReason();

                    return $claim['reason']['value'];

                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($claim) {

                    /* @var $claim \common\models\AnketClaim */

                    return date('Y-m-d H:i:s', $claim->created_at );

                },
            ],

            'text',
            'email',
            'ip',

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

    <?php Pjax::end(); ?>

</div>
