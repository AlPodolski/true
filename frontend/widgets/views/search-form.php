<?php

/* @var $placeholder string */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$searchName = new \frontend\models\SearchNameForm();

?>

<div class="search-wrap position-relative" itemscope itemtype="https://schema.org/WebSite">

    <meta itemprop="url" content="https://<?php echo \Yii::$app->params['site_addr'] ?>"/>

    <?php

    $form = ActiveForm::begin([
        'action' => '/search/name',
        'method' => 'get',
        'options' => [
            'itemscope' => '',
            'itemtype' => 'https://schema.org/SearchAction',
        ]
    ])

    ?>
    <meta itemprop="target"
          content="https://<?php echo \Yii::$app->params['site_addr'] ?>/search/name?SearchNameForm[name]={name}"/>


    <?= $form->field($searchName, 'name')
        ->textInput([
            'class' => 'search',
            'itemprop' => 'query-input',
            'placeholder' => $placeholder
        ])
        ->label(false) ?>

    <?= Html::button('<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.8962 15.8946L11.9579 10.9563C12.8945 9.79989 13.4583 8.32978 13.4583 6.72919C13.4583 3.01873 10.4396 0 6.72916 0C3.0187 0 0 3.01873 0 6.72919C0 10.4396 3.01873 13.4584 6.72919 13.4584C8.32978 13.4584 9.79989 12.8945 10.9563 11.9579L15.8946 16.8963C16.033 17.0346 16.2572 17.0346 16.3955 16.8963L16.8963 16.3955C17.0346 16.2572 17.0346 16.0329 16.8962 15.8946ZM6.72919 12.0417C3.79971 12.0417 1.41668 9.65868 1.41668 6.72919C1.41668 3.79971 3.79971 1.41668 6.72919 1.41668C9.65868 1.41668 12.0417 3.79971 12.0417 6.72919C12.0417 9.65868 9.65868 12.0417 6.72919 12.0417Z" fill="#F74952"/>
                                </svg>', ['type' => 'submit']) ?>

    <?php ActiveForm::end() ?>

</div>
