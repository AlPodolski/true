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
$sendPhotoForm = new \frontend\modules\chat\models\forms\SendPhotoForm();

$this->registerJsFile('/files/js/chat.js', ['depends' => [\frontend\assets\AppAsset::className()]]);

$photoModel = new \frontend\modules\chat\models\forms\SendPhotoForm();

?>

<div class="page-block chat-block " data-to="<?php echo $userTo['id'] ?>">
    <div class="dialog-name red-text text-center"><?php echo($userTo['username']); ?></div>
    <div class="chat-wrap-overlow overflow-hidden">

        <div class="close-chat" onclick="close_chat(this)">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(.clip0)">
                    <path d="M7.24033 14.1768L21.1162 0.33925C21.5708 -0.113854 22.3069 -0.113092 22.7608 0.341594C23.2143 0.796221 23.2131 1.53268 22.7584 1.98614L9.70847 15.0001L22.7589 28.0139C23.2135 28.4674 23.2147 29.2034 22.7612 29.6581C22.5337 29.886 22.2356 30 21.9376 30C21.6403 30 21.3434 29.8868 21.1163 29.6604L7.24033 15.8233C7.02137 15.6054 6.8985 15.309 6.8985 15.0001C6.8985 14.6911 7.02172 14.395 7.24033 14.1768Z"
                          fill="#0F2C93"/>
                </g>
                <defs>
                    <clipPath class="clip0">
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

                                    <?php if ($item['class'] == \frontend\models\Files::class) {

                                        $messagePhoto = \frontend\models\Files::find()
                                            ->where(['id' => $item['related_id']])->asArray()->one();

                                        echo \yii\helpers\Html::img($messagePhoto['file']);

                                    }

                                    else {

                                    ?>

                                        <span class="message-wrap">

                                            <?php echo $item['message'] ?>

                                            <span class="message-date">

                                                <?php echo date("H:i", $item['created_at']) ?>

                                            </span>

                                        </span>

                                    <?php } ?>

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

<div class="comment-wall-form page-block comment-wall-form-">

    <?php

    $form = ActiveForm::begin([
        'action' => '#',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'options' => ['class' => 'send_photo_form', 'enctype' => 'multipart/form-data', 'id' => 'send-message-photo-form'],
    ]) ?>

    <label for="sendphotoform-file" class="file-input">
        <svg width="28" height="28" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M21.2681 5.04C20.8289 4.57993 20.2224 4.30806 19.5323 4.30806H16.0608V4.26624C16.0608 3.74343 15.8517 3.24152 15.4962 2.90692C15.1407 2.55141 14.6597 2.34229 14.1369 2.34229H7.86312C7.31939 2.34229 6.8384 2.55141 6.48289 2.90692C6.12738 3.26244 5.91825 3.74343 5.91825 4.26624V4.30806H2.46768C1.77757 4.30806 1.1711 4.57993 0.731939 5.04C0.292776 5.47917 0 6.10654 0 6.77575V17.1902C0 17.8803 0.271863 18.4868 0.731939 18.9259C1.1711 19.3651 1.79848 19.6579 2.46768 19.6579H19.5323C20.2224 19.6579 20.8289 19.386 21.2681 18.9259C21.7072 18.4868 22 17.8594 22 17.1902V6.77575C22 6.08563 21.7281 5.47917 21.2681 5.04ZM20.9125 17.1902H20.8916C20.8916 17.5666 20.7452 17.9012 20.4943 18.1522C20.2433 18.4031 19.9087 18.5495 19.5323 18.5495H2.46768C2.09125 18.5495 1.75665 18.4031 1.5057 18.1522C1.25475 17.9012 1.10837 17.5666 1.10837 17.1902V6.77575C1.10837 6.39932 1.25475 6.06472 1.5057 5.81377C1.75665 5.56282 2.09125 5.41643 2.46768 5.41643H6.5038C6.81749 5.41643 7.06844 5.16548 7.06844 4.85179V4.24533C7.06844 4.01529 7.15209 3.80616 7.29848 3.65978C7.44487 3.51339 7.65399 3.42974 7.88403 3.42974H14.1369C14.3669 3.42974 14.576 3.51339 14.7224 3.65978C14.8688 3.80616 14.9525 4.01529 14.9525 4.24533V4.85179C14.9525 5.16548 15.2034 5.41643 15.5171 5.41643H19.5532C19.9297 5.41643 20.2643 5.56282 20.5152 5.81377C20.7662 6.06472 20.9125 6.39932 20.9125 6.77575V17.1902Z"
                      fill="#D134C2 "/>
                <path d="M11 6.83838C9.5779 6.83838 8.28133 7.42393 7.36117 8.34408C6.42011 9.28515 5.85547 10.5608 5.85547 11.9829C5.85547 13.4049 6.44102 14.7015 7.36117 15.6216C8.30224 16.5627 9.5779 17.1274 11 17.1274C12.422 17.1274 13.7186 16.5418 14.6387 15.6216C15.5798 14.6806 16.1444 13.4049 16.1444 11.9829C16.1444 10.5608 15.5589 9.26423 14.6387 8.34408C13.7186 7.42393 12.422 6.83838 11 6.83838ZM13.8441 14.8479C13.1121 15.5589 12.1083 16.019 11 16.019C9.89159 16.019 8.88779 15.5589 8.15585 14.8479C7.42391 14.1159 6.98475 13.1121 6.98475 12.0038C6.98475 10.8954 7.44482 9.89161 8.15585 9.15967C8.88779 8.42773 9.89159 7.98857 11 7.98857C12.1083 7.98857 13.1121 8.44864 13.8441 9.15967C14.576 9.89161 15.0152 10.8954 15.0152 12.0038C15.0361 13.1121 14.576 14.1159 13.8441 14.8479Z"
                      fill="#D134C2 "/>
                <path d="M18.4446 8.86681C19.0106 8.86681 19.4694 8.40803 19.4694 7.8421C19.4694 7.27616 19.0106 6.81738 18.4446 6.81738C17.8787 6.81738 17.4199 7.27616 17.4199 7.8421C17.4199 8.40803 17.8787 8.86681 18.4446 8.86681Z"
                      fill="#D134C2 "/>
            </g>
            <defs>
                <clipPath id="clip0">
                    <rect width="22" height="22" fill="white"/>
                </clipPath>
            </defs>
        </svg>
    </label>

    <?php $params = ['maxlength' => true, 'accept' => '.jpg, .jpeg', 'required' => true, 'onchange' => 'send_photo()']; ?>

    <?= $form->field($sendPhotoForm, 'file')
        ->fileInput($params)
        ->label(false) ?>

    <?= $form->field($messageForm, 'chat_id', ['options' => ['class' => 'd-none']])
        ->hiddenInput(['value' => $dialog['dialog_id']])->label(false) ?>

    <?= $form->field($sendPhotoForm, 'to', ['options' => ['class' => 'd-none']])
        ->hiddenInput(['value' => 240])->label(false) ?>

    <?= $form->field($sendPhotoForm, 'user_id', ['options' => ['class' => 'd-none']])
        ->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

    <?php ActiveForm::end() ?>

    <?php

    $form = ActiveForm::begin([
        'action' => '#',
        'id' => 'message-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'options' => ['class' => 'form-horizontal d-flex'],
    ]) ?>

    <?= $form->field($messageForm, 'chat_id', ['options' => ['class' => 'd-none']])->hiddenInput(['value' => $dialog['dialog_id']])->label(false) ?>

    <?php if ($recepient) : ?>

        <?= $form->field($messageForm, 'user_id', ['options' => ['class' => 'd-none']])->hiddenInput(['value' => $recepient])->label(false) ?>
        <?= $form->field($messageForm, 'from_id', ['options' => ['class' => 'd-none']])->hiddenInput(['value' => $user['id']])->label(false) ?>

    <?php endif; ?>

    <?= $form->field($messageForm, 'text', ['options' => ['class' => 'form-otvet']])->textarea(['placeholder' => 'Напишите что то'])->label(false) ?>

    <span
            data-name="<?php echo $user['username']; ?>"
            data-user-id="<?php echo $user['id']; ?>"
            data-user-id-to="<?php echo $userTo['id']; ?>"
            data-name-to="<?php echo $userTo['username']; ?>"
            data-dialog-id="<?php echo $dialog_id; ?>"
            onclick="send_message(this)"
            class="message-send-btn orange-btn">
        Отправить
</span>

    <?php ActiveForm::end() ?>

</div>
