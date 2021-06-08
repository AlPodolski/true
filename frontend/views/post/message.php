<?php

use frontend\modules\chat\widgets\DialogWidget;

/* @var $data array */

echo DialogWidget::widget([
    'dialog_id' => $data['dialog_id'],
    'user' => $data['user'],
    'recepient' => $data['userTo']['id'],
    'userTo' => $data['userTo'],
]);