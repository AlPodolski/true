<?php /* @var $dialog array */ ?>
<?php /* @var $user array */ ?>
<?php /* @var $recepient integer */ ?>
<?php /* @var $userTo array */ ?>
<?php /* @var $dialog_id integer */ ?>
<?php /* @var $limitExist boolean */ ?>

<?php

use yii\widgets\ActiveForm;
use cabinet\widgets\PhotoWidget;

$messageForm = new \cabinet\modules\chat\models\forms\SendMessageForm();
$sendPhotoForm = new \cabinet\modules\chat\models\forms\SendPhotoForm();

$this->registerJsFile('/files/js/chat.js', ['depends' => [\cabinet\assets\AppAsset::className()]]);

$photoModel = new \cabinet\modules\chat\models\forms\SendPhotoForm();

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

                                        if (strpos($messagePhoto['file'], '.pdf'))
                                            echo \yii\helpers\Html::a('Смотреть', $messagePhoto['file']);
                                        else  echo \yii\helpers\Html::img( $messagePhoto['file']);

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

        <svg version="1.1" width="28px" height="28px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 477.875 477.875" style="enable-background:new 0 0 477.875 477.875;" xml:space="preserve">
<g>
    <g>
        <path fill="#D134C2 " d="M329.622,142.691c6.517-6.517,6.517-17.283,0-24.083c-6.517-6.517-17.283-6.517-24.083,0L127.322,296.825
			c-21.25,21.25-21.25,56.1,0,77.35s56.1,21.25,77.35,0l186.717-186.717c1.7-0.85,3.4-1.983,5.1-3.4
			c24.933-24.933,91.233-91.233,27.483-154.983c-24.367-24.367-53.55-33.717-84.433-26.917c-25.217,5.383-51.283,21.533-77.35,47.6
			l-202.3,202.3c-24.083,24.083-36.833,57.517-35.417,94.067c1.417,34.85,15.867,68.85,39.95,92.933s57.517,37.967,92.083,38.817
			c0.85,0,1.7,0,2.833,0c34.567,0,66.3-13.033,89.817-36.55l199.467-199.467c6.517-6.517,6.517-17.283,0-24.083
			c-6.517-6.517-17.283-6.517-24.083,0L225.072,417.241c-17.567,17.567-41.65,26.917-68,26.633
			c-25.783-0.567-50.717-11.05-68.567-28.9c-38.25-38.25-40.233-103.133-4.533-138.833l202.3-202.3
			c20.967-20.967,41.933-34.283,60.35-38.25c19.55-4.25,37.117,1.417,53.267,17.85c15.867,15.867,20.4,30.6,14.733,48.45
			c-3.967,12.75-13.033,26.917-28.333,43.917c-1.133,0.85-2.55,1.7-3.4,2.55L180.872,350.375c-7.933,7.933-21.25,7.933-29.183,0
			c-7.933-7.933-7.933-21.25,0-29.183L329.622,142.691z"/>
    </g>
    </g>
</svg>
    </label>

    <?php $params = ['maxlength' => true, 'accept' => '.jpg, .jpeg, .pdf, .png ', 'required' => true, 'onchange' => 'send_photo()']; ?>

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
