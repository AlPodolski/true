<?php

/* @var $post array */
/* @var $postsByPhone \frontend\modules\user\models\Posts[] */
/* @var $viewPosts \frontend\modules\user\models\Posts[] */
/* @var $recomendPost \frontend\modules\user\models\Posts[] */
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

$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends' => ['yii\web\YiiAsset']]);

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

echo \frontend\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://' .$_SERVER['HTTP_HOST']. $post['avatar']['file'],
]);


$this->params['breadcrumbs'][] = array(
    'label' => $post['name'],
);

if ($productShema) echo $productShema;

?>

<div class="single">
    <div class="container">

        <?php echo $this->renderFile(Yii::getAlias('@app/views/post/item.php'), [
            'post' => $post,
            'cityInfo' => $cityInfo,
            'serviceListReview' => $serviceListReview,
            'phoneComments' => $phoneComments,
            'first' => $first,
            'backUrl' => $backUrl,
            'serviceList' => $serviceList,
        ]); ?>

        <div class="profile__about-sim profile__about-block  profile__tab" id="profileServices">
            <ul class="profile__about-sim-tabs">
                <li class="profile__about-sim-tabs-item active" id="rec">
                    Рекомендации
                </li>
            </ul>
            <?php if ($recomendPost) ?>
            <div class="profile__about-sim-items active row" id="rec">
                <?php foreach ($recomendPost as $viewPostItem)
                    echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $viewPostItem,
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>
