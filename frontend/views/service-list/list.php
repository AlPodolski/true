<?php

/* @var $dataList array */
/* @var $url string */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $cityInfo \common\models\City */

use yii\helpers\ArrayHelper;
use frontend\modules\user\models\Posts;
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

                $urlText = $item['value'].' - '.Posts::find()
                        ->where(['in', 'id', ArrayHelper::getColumn($item['posts'], 'post_id')])
                        ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
                        ->andWhere(['city_id' => $cityInfo['id']])
                        ->count();

                echo Html::a($urlText, $url .'-'. $item['url'], ['class' => 'red-link']);

            }

            ?>
        </div>

    </div>
</div>