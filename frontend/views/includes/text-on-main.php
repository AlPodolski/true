<?php

/* @var $cityInfo array */

if (Yii::$app->requestedParams['city'] == 'moskva' and !isset($_COOKIE['tele'])) : ?>

    <div class="alert alert-warning">
        <a rel="nofollow" href="https://t.me/indi_tut">Проститутки в телеграм</a>
        <div class="close" onclick="close_text()">
            <button  class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

<?php endif; ?>