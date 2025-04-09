<?php /* @var $prPosts \cabinet\modules\user\models\Posts[] */ ?>

<?php if ($prPosts) : foreach ($prPosts as $post) : ?>

    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

<?php endforeach; ?>

<?php endif; ?>