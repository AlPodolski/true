<?php

/* @var $this yii\web\View */

/* @var $posts array */

use cabinet\modules\user\helpers\ViewCountHelper;

$this->title = 'Избранное';

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => 'Избранное'
]);

?>
<div class="container custom-container">

    <h1 class="margin-top-20"> <?php echo $this->title ?> </h1>

    <div class="row">

        <?php if ($posts) : ?>

            <?php foreach ($posts as $post) : ?>

                <?php ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']); ?>

                <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post' => $post,
                ]); ?>

            <?php endforeach; ?>

        <?php else : ?>

        <div class="col-12">
            <div class="alert alert-success">Пока ничего нет в избранном</div>
        </div>



        <?php endif; ?>

    </div>


</div>