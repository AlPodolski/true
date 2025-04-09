<?php

/* @var $post array */
/* @var $postsByPhone \cabinet\modules\user\models\Posts[] */
/* @var $viewPosts \cabinet\modules\user\models\Posts[] */
/* @var $serviceList array */
/* @var $serviceListReview array */
/* @var $cityInfo array */
/* @var $this \yii\web\View */
/* @var $id integer */
/* @var $productShema string */
/* @var $phoneComments array */

/* @var $backUrl string */
/* @var $refererCategory string|null */

/* @var $first bool */

use kartik\icons\FontAwesomeAsset;
use cabinet\assets\RateAsset;

\cabinet\assets\GalleryAsset::register($this);

$this->registerJsFile('/js/single.js?v=22', ['depends' => ['yii\web\YiiAsset']]);
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends' => ['yii\web\YiiAsset']]);


$price = \cabinet\helpers\PostPriceHelper::getMinAndMaxPrice($post['sites']);

$title = 'Проститутка ' . $post['name'] . ' из ' . $cityInfo['city2'];

if (isset($post['metro'][0]['value'])) $title .= ' у метро ' . $post['metro'][0]['value'];

$title .= ' скрасит  твой  досуг  за ' . $post['price'] . ' руб/час ' . ' Анкета номер ' . $post['id'];

$this->title = $title;

$des = 'Индивидуалка ' . $post['name'];

if ($post['breast']) $des .= ' красавица c ' . $post['breast'] . ' размером груди ';

if ($post['service']) $des .= ' ,  нравится ' . $post['service'][0]['service']['value'];

if ($post['place']) {

    foreach ($post['place'] as $item) {

        if ($item['url'] == 'v-sayne') $des .= ' возможен выезд в сауну или баню ';
        if ($item['url'] == 'appartamentu') $des .= ' есть аппартаменты ';

    }

}

$des .= ' , остальная информация в анкете сексуальной проститутки.';


$des .= ' Анкета номер ' . $post['id'];


Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

echo \cabinet\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://' . $_SERVER['HTTP_HOST'] . $post['avatar']['file'],
]);


$this->params['breadcrumbs'][] = array(
    'label' => $post['name'],
);

if ($productShema) echo $productShema;

?>
    <div class="container custom-container single-content">

        <?php echo $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
            'post' => $post,
            'cityInfo' => $cityInfo,
            'serviceListReview' => $serviceListReview,
            'viewPosts' => $viewPosts,
            'phoneComments' => $phoneComments,
            'first' => $first,
            'backUrl' => $backUrl,
            'refererCategory' => $refererCategory,
            'price' => $price
        ]); ?>
        <?php echo \cabinet\widgets\HelperWidget::widget() ?>

        <?php if ($postsByPhone) : ?>

            <div class="red-bold-text text-center">Анкеты с этим номером</div>

            <div class="view-posts d-flex">
                <?php foreach ($postsByPhone as $post) : ?>
                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $post,
                    ]); ?>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

        <?php if ($viewPosts) : ?>

            <div class="red-bold-text text-center">Просмотренные анкеты</div>

            <div class="view-posts d-flex">
                <?php foreach ($viewPosts as $viewPost) : ?>
                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $viewPost,
                    ]); ?>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

        <p class="big-red-text">Похожие анкеты</p>
    </div>

    <svg class="filter" version="1.1">
        <defs>
            <filter id="gooeyness">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10"
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
        <div class="col-12 pager <?php if (isset($first) and $first) : ?>
         first
         <?php endif; ?>"
            <?php if (isset($refererCategory) and $refererCategory) : ?>
                data-ref="<?php echo $refererCategory ?>"
            <?php endif; ?>
             data-price="<?php echo $post['price'] ?>"
             data-pol="<?php echo $post['pol_id'] ?>"
             data-national="<?php echo $post['nacionalnost'][0]['id'] ?>"
             data-single="1" <?php if ($post['id']) : ?>
            data-url="/post/<?php echo $post['id'] ?>" <?php endif; ?>></div>
    </div>

<?php


?>