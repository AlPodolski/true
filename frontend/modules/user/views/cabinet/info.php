<?php

/* @var $user \common\models\User */

?>

<?php if (Yii::$app->user->identity['status'] == \common\models\User::STATUS_INACTIVE) : ?>

    <div class="alert-success alert alert-dismissible"> Что бы получать уведомления нужно активировать почту
    </div>

<?php endif; ?>

<?php if (!$user['telegram']) : ?>

    <div class="alert alert-info">
        Подключите <?php echo \yii\helpers\Html::a('Телеграм', '/cabinet/telegram') ?>
        и пользуйтесь всеми функциями нашего бота, получайте уведомления о сообщениях и будьте вкурсе всего
    </div>

<?php endif; ?>