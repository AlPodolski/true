<?php

/* @var $post array */
/* @var $serviceList array */
/* @var $serviceListReview array */
/* @var $cityInfo array */
/* @var $this \yii\web\View */
/* @var $id integer */
/* @var $backUrl string */

use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);

$this->registerJsFile('/js/owl.carousel.js', ['depends' => ['yii\web\YiiAsset']]);
$this->registerJsFile('https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js', ['depends' => ['yii\web\YiiAsset']]);
$this->registerCssFile('/css/owl.carousel.min.css');
$this->registerCssFile('/css/owl.theme.default.min.css');
$this->registerCssFile('https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css');
$this->registerJsFile('/js/single.js?v=2', ['depends' => ['yii\web\YiiAsset']]);

$price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

$title = 'Проститутка '.$post['name'] .' из '.$cityInfo['city2'].' ждет твоего звонка на '.Yii::$app->request->hostName;

$this->title = $title;

if($post['about']) $des = $post['about'];

else $des = 'Проститутка '.$post['name'].' ждет Вашего звонка. Цена от '.$price['min'];


Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

$this->params['breadcrumbs'][] = array(
    'label'=> $post['name'],
);

?>
<div class="container custom-container single-content">

    <?php echo $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
            'post'           => $post,
        'cityInfo'           => $cityInfo,
         'serviceListReview' => $serviceListReview,
                     'price' => $price
    ]); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="info-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="selfy-modal" tabindex="-1" role="dialog" aria-labelledby="selfy-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $imgs = array(); ?>

                <?php foreach ($post['allPhoto'] as $item) : ?>

                    <?php

                    if ($item['type'] == \frontend\models\Files::SELPHY_TYPE) $imgs[] = $item['file']

                    ?>


                <?php endforeach; ?>

                <div data-img="<?php echo implode(',' , $imgs) ?>" id="selfy-imgs"></div>

            </div>
        </div>
    </div>
</div>

