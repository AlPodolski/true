<?php

/* @var $links array */

?>

<div class="popular-btn-block">

<?php foreach ($links as $link) { ?>

    <?php echo \yii\helpers\Html::a($link['text'], $link['link'], ['class' => 'popular-btn' ])?>

<?php } ?>

</div>
