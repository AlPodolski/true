<?php

/* @var $this \yii\web\View */
/* @var $posts array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */

$this->title = $title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);


?>

<h1> <?php echo $h1 ?> </h1>

<div class="row">

    <?php foreach ($posts as $post) : ?>

        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

    <?php endforeach; ?>

</div>