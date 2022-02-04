<?php

/* @var $post array */
/* @var $serviceList array */
/* @var $serviceListReview array */
/* @var $cityInfo array */
/* @var $this \yii\web\View */
/* @var $id integer */

/* @var $backUrl string */

use kartik\icons\FontAwesomeAsset;
use frontend\assets\RateAsset;

\frontend\assets\GalleryAsset::register($this);

$this->registerJsFile('/js/single.js?v=9', ['depends' => ['yii\web\YiiAsset']]);


$price = \frontend\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

$title = 'Проститутка ' . $post['name'] . ' из ' . $cityInfo['city2'] . ' номер телефона ' . $post['phone'];

if (isset($post['metro'][0]['value'])) $title .= ' у метро ' . $post['metro'][0]['value'];

$title .= ' скрасит  твой  досуг  за ' . $post['price'] . ' руб/час ' . ' ID ' . $post['id'];

$this->title = $title;

$des = 'Индивидуалка ' . $post['name'];

if ($post['breast']) $des .= ' красавица c ' . $post['breast'] . ' размером груди ';

if ($post['service']) $des .= ' ,  нравится ' . $post['service'][0]['value'];

if ($post['place']) {

    foreach ($post['place'] as $item) {

        if ($item['url'] == 'v-sayne') $des .= ' возможен выезд в сауну или баню ';
        if ($item['url'] == 'appartamentu') $des .= ' есть аппартаменты ';

    }

}

$des .= ' , остальная информация в анкете сексуальной проститутки.';


$des .= ' Мой номер ' . $post['phone'] . ' ID ' . $post['id'];


Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

echo \frontend\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://'.Yii::$app->request->serverName.$post['avatar']['file'],
]);


$this->params['breadcrumbs'][] = array(
    'label' => $post['name'],
);

?>
<div class="container custom-container single-content">

    <?php echo $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
        'post' => $post,
        'cityInfo' => $cityInfo,
        'serviceListReview' => $serviceListReview,
        'price' => $price
    ]); ?>
    <p class="big-red-text">Вас может заинтересовать</p>
</div>

<svg class="filter" version="1.1">
    <defs>
        <filter id="gooeyness">
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10"
                           result="gooeyness"/>
            <feComposite in="SourceGraphic" in2="gooeyness" operator="atop"/>
        </filter>
    </defs>
</svg>
<div class="dots">
    <div class="dot mainDot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div class="row">
    <div class="col-12 pager" data-page="1" data-adress="/post/more" data-single="1"
         data-reqest="<?php echo Yii::$app->request->url ?>"></div>
</div>
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

                <?php foreach ($post['gal'] as $item) : ?>

                    <?php

                    if ($item['type'] == \frontend\models\Files::SELPHY_TYPE) $imgs[] = $item['file']

                    ?>


                <?php endforeach; ?>

                <div data-img="<?php echo implode(',', $imgs) ?>" id="selfy-imgs"></div>

            </div>
        </div>
    </div>
</div>

<?php

$this->registerJs(
    "init_yandex();",
    $this::POS_READY,
    'my-button-handler'
);


?>