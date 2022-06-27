<?php

/* @var $this \yii\web\View */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $posts \frontend\modules\user\models\Posts[] */

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);


$result = [];

foreach ($posts as $post) {

    if (isset($post['metro'][0]['x']) and $post['metro'][0]['x'] and $post['avatar']) {

        $post['name'] = preg_replace('/[^ a-zа-яё\d]/ui', '',$post['name'] );

        $result[] = $post;

    }

}

?>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>

<div class="map-data d-none">
    <?php echo json_encode($result) ?>
</div>

<div class="container map-page">

    <h1> <?php echo $h1 ?> </h1>

    <?php echo \frontend\widgets\MapFilterWidget::widget() ?>

    <div id="map">
        <img src="/img/spinner.gif" alt="">
    </div>

</div>

<?php $this->registerJsFile('/js/map_page.js?v=5', ['depends' => \frontend\assets\AppAsset::class]);
