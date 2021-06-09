<?php /* @var $dialog array */ ?>
<?php /* @var $user array */ ?>
<?php /* @var $recepient integer */ ?>
<?php /* @var $userTo array */ ?>
<?php /* @var $dialog_id integer */ ?>
<?php /* @var $limitExist boolean */ ?>

<?php

use yii\widgets\ActiveForm;
use frontend\widgets\PhotoWidget;

$messageForm = new \frontend\modules\chat\models\forms\SendMessageForm();
$this->registerJsFile('/files/js/chat.js', ['depends' => [\frontend\assets\AppAsset::className()]]);

$photoModel = new \frontend\modules\chat\models\forms\SendPhotoForm();

?>

<div class="page-block chat-block " data-to="<?php echo $userTo['id']?>">
    <div class="dialog-name red-text text-center"><?php echo ($userTo['username']); ?></div>
    <div class="chat-wrap-overlow overflow-hidden">

        <div class="close-chat" onclick="close_chat(this)">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)">
                    <path d="M7.24033 14.1768L21.1162 0.33925C21.5708 -0.113854 22.3069 -0.113092 22.7608 0.341594C23.2143 0.796221 23.2131 1.53268 22.7584 1.98614L9.70847 15.0001L22.7589 28.0139C23.2135 28.4674 23.2147 29.2034 22.7612 29.6581C22.5337 29.886 22.2356 30 21.9376 30C21.6403 30 21.3434 29.8868 21.1163 29.6604L7.24033 15.8233C7.02137 15.6054 6.8985 15.309 6.8985 15.0001C6.8985 14.6911 7.02172 14.395 7.24033 14.1768Z" fill="#F74952"/>
                </g>
                <defs>
                    <clipPath id="clip0">
                        <rect width="30" height="30" fill="white" transform="matrix(-1 0 0 1 30 0)"/>
                    </clipPath>
                </defs>
            </svg>

        </div>

        <div class="chat-wrap" data-read="">

            <div class="chat ">

                <?php if (isset($dialog['message'])) : foreach ($dialog['message'] as $item) : ?>

                        <div class="wall-tem <?php if (Yii::$app->user->id == $item['author']['id']) echo 'right-message' ?>">

                            <div class="post_header">

                                <div class="post_header_info">

                                    <div class="post-text">

                                        <span class="message-wrap">

                                            <?php echo $item['message'] ?>

                                            <span class="message-date">

                                                <?php echo date("H:i", $item['created_at']) ?>

                                            </span>

                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div style="clear: both">
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<div  class="comment-wall-form page-block comment-wall-form-<?php echo $item['id'] ?>">

    <?php

    $form = ActiveForm::begin([
        'action' => '#',
        'id' => 'message-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'options' => ['class' => 'form-horizontal d-flex'],
    ]) ?>
    <?= $form->field($messageForm, 'chat_id',['options' => ['class' => 'd-none']])->hiddenInput(['value' => $dialog['dialog_id']])->label(false) ?>

    <?php if ($recepient) :?>

        <?= $form->field($messageForm, 'user_id',['options' => ['class' => 'd-none']])->hiddenInput(['value' => $recepient])->label(false) ?>
        <?= $form->field($messageForm, 'from_id',['options' => ['class' => 'd-none']])->hiddenInput(['value' => $user['id']])->label(false) ?>

    <?php endif; ?>

    <?= $form->field($messageForm, 'text' , ['options' => ['class' => 'form-otvet']])->textarea(['placeholder' => 'Напишите что то'])->label(false) ?>

    <span
          data-name="<?php echo $user['username'];  ?>"
          data-user-id="<?php echo $user['id'];  ?>"
          data-user-id-to="<?php echo $userTo['id']; ?>"
          data-name-to="<?php echo $userTo['username']; ?>"
          data-dialog-id="<?php echo $dialog_id; ?>"
          onclick="send_message(this)"
          data-id="<?php echo $item['id']; ?>"
          class="message-send-btn orange-btn">
        Отправить
</span>

    <?php ActiveForm::end() ?>

</div>
