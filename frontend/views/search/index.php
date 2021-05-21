<?php

/* @var $this \yii\web\View */
/* @var $prPosts array */
/* @var $name string */

?>


<div class="container custom-container">
    <h1 class="margin-top-20"> Поиск по имени : <?php echo $name ?></h1>
    <div class="row">

        <?php if ($prPosts) : foreach ($prPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

        <?php endforeach; ?>

        <?php else : ?>

        <div class="col-12">
            <p class="alert alert-info">По вашему запросу ничего не найдено попробуйте поискать другое имя</p>
        </div>

        <?php endif; ?>

    </div>
</div>
