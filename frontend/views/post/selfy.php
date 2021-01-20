<?php

 /* @var $data array */

$files = \yii\helpers\ArrayHelper::getColumn($data, 'file')

?>

<div class="img-grids" data-img="<?php echo implode(',' , $files) ?>" id="selfy-imgs"></div>
