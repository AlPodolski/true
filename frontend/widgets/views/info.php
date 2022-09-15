<?php

/* @var $showCashInfo bool*/
/* @var $showBonusInfo bool*/
/* @var $showAdvertInfo bool*/

?>

<div class="info-wrap">

    <?php if (!$showCashInfo) : ?>

        <div class="alert alert-danger danger-info">Не переводите деньги заранее ВАС ОБМАНУТ
            <button data-type="cash" type="button" onclick="rememberClose(this)" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>

    <?php if (Yii::$app->user->isGuest and !$showBonusInfo) : ?>

    <div class="alert alert-success">Регистрируйся и получи деньги для первых публикаций
        <button data-type="bonus" onclick="rememberClose(this)" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php endif; ?>

</div>

