<?php

/* @var $showCashInfo bool*/
/* @var $showBonusInfo bool*/
/* @var $showAdvertInfo bool*/

?>

<div class="info-wrap">

    <?php if (!$showCashInfo) : ?>

        <div class="alert alert-info">Не переводите деньги заранее и скажите что
            звоните с сайта <?php echo Yii::$app->request->serverName?>
            <button data-type="cash" type="button" onclick="rememberClose(this)" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>

    <?php if (Yii::$app->user->isGuest and !$showBonusInfo) : ?>

    <div class="alert alert-success">Бонус за регистрацию 100р!
        <button data-type="bonus" onclick="rememberClose(this)" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php endif; ?>

</div>

