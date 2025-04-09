<?php
/* @var $this yii\web\View */
/* @var $user_id integer */

use cabinet\widgets\UserSideBarWidget;
use cabinet\modules\chat\widgets\MessageListWidget;

$this->registerJsFile('/files/js/prev.js', ['depends' => [\cabinet\assets\AppAsset::className()]]);

$this->title = 'Диалоги';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">

        <div class="col-12 col-xl-12 margin-top-20">

            <div class="dialog_list-wrap">

                <?php

                    echo MessageListWidget::widget(['user_id' => $user_id]);

                ?>

            </div>

        </div>

    </div>
</div>
