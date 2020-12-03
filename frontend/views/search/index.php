<?php

/* @var $this \yii\web\View */
/* @var $prPosts array */
/* @var $name string */

?>

<h1> Поиск по имени : <?php echo $name ?></h1>

<div class="row">

    <?php foreach ($prPosts as $post) : ?>

        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

    <?php endforeach; ?>

</div>