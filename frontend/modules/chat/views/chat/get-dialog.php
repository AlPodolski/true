<?php

/* @var $dialog_id integer */
/* @var $recepient integer */
/* @var $user array */
/* @var $userTo array */
/* @var $limitExist boolean */

use frontend\modules\chat\widgets\DialogWidget;

echo DialogWidget::widget([
    'dialog_id' => $dialog_id,
    'user' => $user,
    'recepient' => $recepient,
    'userTo' => $userTo,
    'limitExist' => $limitExist,
]);