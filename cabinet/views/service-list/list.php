<?php

/* @var $dataList array */
/* @var $url string */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $cityInfo \common\models\City */

use yii\helpers\ArrayHelper;
use cabinet\modules\user\models\Posts;
use yii\helpers\Html;

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

?>

<div class="container">

    <h1> <?php echo $h1 ?> </h1>

    <div class="row">

        <div class="col-12 data-list">
            <?php

            foreach ($dataList as $item){

                echo Html::a($item['value'], $url .'-'. $item['url'], ['class' => 'red-link']);

            }

            ?>
        </div>

    </div>
</div>