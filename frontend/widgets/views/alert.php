<?php

/* @var $flashes array */
/* @var $session \yii\web\Session */

if ($flashes) {

    echo '<div class="container alert-wrap">';

    foreach ($flashes as $key => $value) {

        echo '<div class="alert-item">';

        echo $value;

        echo '</div>';

        $session->removeFlash($key);

    }

    echo '</div>';

}

