<?php

/* @var $dialog array */
/* @var $user_id integer */

?>
<li onclick="get_dialog(this)" data-to="<?php echo $dialog['companion']['user_id'] ?>" data-dialog-id="<?php echo $dialog->lastMessage['chat_id']; ?>"
    class="dialog_item <?php if ($dialog->lastMessage['status'] == 0 and $dialog['lastMessage']['from'] != $user_id)
        echo 'not-read-dialog'; ?> " >
    <div class="row">
        <div class="col-2 col-md-1 dialog-photo-wrap">
            <div class="dialog-photo ">

                <?php if (file_exists(Yii::getAlias('@webroot') . $dialog->companion['author']['avatar']['file']) and $dialog->companion['author']['avatar']['file']) : ?>

                    <img loading="lazy" class="img"
                         srcset="<?= Yii::$app->imageCache->thumbSrc($dialog->companion['author']['avatarRelation']['file'], 'dialog') ?>"
                         alt="">

                <?php else : ?>

                    <img class="img" src="/img/no-photo-user.png" alt="">

                <?php endif; ?>

            </div>
        </div>
        <div class="col-10 col-md-11 nim-dialog--content position-relative">
            <div class="dialog-text">
                <div class="row">
                    <div class="col-12">
                        <div class="dialog-name">
                            <a class="red-text">
                                <?php echo $dialog['companion']['author']['username'] ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dialog-prewiew">
                            <div class="text-preview">
                                <a class="grey-text">

                                    <span class="nim-dialog--inner-text <?php if ($dialog->lastMessage['status'] != 0) echo 'read-dialog'; ?> ">
                                        <?php if (isset($dialog->lastMessage['class'])) : ?>

                                            <?php if ($dialog->lastMessage['class'] == \frontend\models\Files::class) : ?>

                                                <i class="fas fa-camera"></i>

                                            <?php endif; ?>

                                        <?php else : ?>

                                            <?php echo $dialog->lastMessage['message'] ?>

                                        <?php endif; ?>

                                    </span>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>