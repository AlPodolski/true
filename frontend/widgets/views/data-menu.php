<?php

/* @var $data array */
/* @var $url string */

$cssClass = 'city-list';

if (count($data) < 20) $cssClass.= ' list-one-column';

if ($data){
    echo '<div class="'.$cssClass.'">';
    foreach ($data as $item){
        echo \yii\helpers\Html::a($item['value'], '/'.$url.'-'.$item['url'], ['class' => 'red-link']);
    }
    echo '</div>';
}

