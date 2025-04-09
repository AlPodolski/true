<?php

 /* @var $data array */

$files = \yii\helpers\ArrayHelper::getColumn($data, 'file')

?>

<div class="aniimated-thumbnials">

    <?php foreach ($files as $file) : ?>

        <a href="<?php echo $file?>">
            <img src="<?php echo $file?>" alt="">
        </a>

    <?php endforeach; ?>

</div>
