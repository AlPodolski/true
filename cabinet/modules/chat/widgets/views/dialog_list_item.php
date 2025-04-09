<?php
use cabinet\modules\chat\components\helpers\GetDialogsHelper;

/* @var $dialog array */
/* @var $user_id integer */

?>
<li onclick="get_dialog(this)" data-to="<?php echo $dialog['companion']['user_id'] ?>"
    data-dialog-id="<?php echo $dialog['lastMessage']['chat_id']; ?>"
    class="dialog_item <?php if ($dialog['lastMessage']['status'] == 0 and $dialog['lastMessage']['from'] != $user_id)
        echo 'not-read-dialog'; ?> ">
    <div class="row">
        <div class="col-3 col-md-2 col-lg-1 dialog-photo-wrap">
            <div class="dialog-photo ">

                <?php if (file_exists(Yii::getAlias('@webroot') . $dialog['companion']['author']['avatar']['file']) and $dialog->companion['author']['avatar']['file']) : ?>

                    <img loading="lazy" class="img"
                         srcset="<?= Yii::$app->imageCache->thumbSrc($dialog['companion']['author']['avatar']['file'], '59') ?>"
                         alt="">

                <?php else : ?>

                    <img class="img" src="/img/no-photo-user.png" alt="">

                <?php endif; ?>

            </div>
        </div>
        <div class="col-9 col-md-10 col-lg-11 nim-dialog--content position-relative">
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

                                        <?php if (isset($dialog['lastMessage']['class'])) : ?>

                                            <?php if ($dialog['lastMessage']['class'] == \cabinet\models\Files::class) : ?>

                                                <svg version="1.1" width="23px" height="23px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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

                                            <?php endif; ?>

                                        <?php else : ?>

                                            <?php echo $dialog['lastMessage']['message'] ?>

                                        <?php endif; ?>

                                    </span>

                                </a>

                                <?php

                                if ($notReadCount = GetDialogsHelper::getCountNotRead($dialog['lastMessage']['chat_id'], $dialog['companion']['author']['id'])) : ?>

                                    <span class="red-text"> +<?php echo $notReadCount ?></span>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>