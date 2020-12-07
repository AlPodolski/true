<?php

/* @var $this \yii\web\View */
/* @var $posts array */

?>

<h1> Заголовок </h1>

<div class="row">

    <?php foreach ($posts as $post) : ?>

        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

    <?php endforeach; ?>

</div>