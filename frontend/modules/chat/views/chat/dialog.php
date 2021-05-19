<?php
/* @var $this yii\web\View */
/* @var $dialog_id integer */
/* @var $user array */
/* @var $userTo array */
/* @var $limitExist boolean */

use frontend\widgets\UserSideBarWidget;
use frontend\modules\chat\widgets\DialogWidget;

$this->registerJsFile('/files/js/prev.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerJsFile('/files/js/cabinet.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->title = 'Диалог';
?>
<div class="row">

    <div class="col-12 col-xl-9 dialog">
        <div class="detal-dialog-wrap">
            <?php
                echo DialogWidget::widget(['dialog_id' => $dialog_id, 'user' => $user, 'userTo' => $userTo, 'limitExist' => $limitExist]);
            ?>
        </div>
    </div>
</div>