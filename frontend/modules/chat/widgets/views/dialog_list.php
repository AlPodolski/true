<?php /* @var $dialogs array */ ?>
<?php /* @var $user_id integer */ ?>
<?php /* @var $this \yii\web\View */ ?>
<?php $notVipDialogs = array() ?>


<div class="dialog_list ">

    <?php if (!empty($dialogs)) : ?>

        <ul class="dialog_item_ul">

            <?php foreach ($dialogs as $dialog) : ?>

            <?php if ($dialog['lastMessage']['status'] == \frontend\modules\chat\models\Message::MESSAGE_NOT_READ
                    and $dialog['lastMessage']['to'] == Yii::$app->user->id) : ?>

                <?php echo $this->renderFile(Yii::getAlias('@frontend/modules/chat/widgets/views/dialog_list_item.php'), [
                    'dialog' => $dialog,
                    'user_id' => $user_id
                ]);

                unset($dialog);

                endif;

                ?>

            <?php endforeach; ?>

            <?php foreach ($dialogs as $dialog) : ?>

                <?php echo $this->renderFile(Yii::getAlias('@frontend/modules/chat/widgets/views/dialog_list_item.php'), [
                    'dialog' => $dialog,
                    'user_id' => $user_id
                ]);

                unset($dialog);

                ?>

            <?php endforeach; ?>

        </ul>

    <?php else : ?>

        <p>У Вас пока нет диалогов</p>

    <?php endif; ?>

</div>

<div class="dialog">

</div>