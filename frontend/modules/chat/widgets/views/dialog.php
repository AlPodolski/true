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

    <div class="chat-wrap-overlow overflow-hidden">
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

                                                <?php echo date("Y-m-d H:i:s", $item['created_at']) ?>

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

    <?php echo PhotoWidget::widget([
        'path' => $user['userAvatarRelations']['file'],
        'size' => 'dialog',
        'options' => [
            'class' => 'img d-none user-img',
            'loading' => 'lazy',
            'alt' => $user['username'],
        ],
    ]  ); ?>

    <?php echo PhotoWidget::widget([
        'path' => $userTo['userAvatarRelations']['file'],
        'size' => 'dialog',
        'options' => [
            'class' => 'img d-none user-img user-to',
            'loading' => 'lazy',
            'alt' => $userTo['username'],
        ],
    ]  ); ?>

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
