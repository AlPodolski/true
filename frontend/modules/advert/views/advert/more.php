<?php
/* @var $advertList Advert */
/* @var $this View */

use frontend\modules\advert\models\Advert;
use yii\web\View;

?>

<?php foreach ($advertList as $advert) : ?>

<?php echo $this->renderFile('@app/modules/advert/views/advert/item.php' , [
        'advert' => $advert
    ]) ?>

<?php endforeach; ?>
