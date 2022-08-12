<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */

$this->title = $user->username;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $user->username
]);

?>

<div class="container">
    <h1 class=""><?php echo $user->username ?></h1>
    <p class="">Дата регистрации - <?php echo date("Y-m-d", $user->created_at) ?></p>

    <?php if (Yii::$app->user != $user['id'] or Yii::$app->user->isGuest) : ?>

        <p class="white-btn video-btn" onclick="get_modal(this);ym(70919698,'reachGoal','message')"
           data-target="message" data-id="<?php echo $user['id'] ?>">Написать сообщение</p>

    <?php endif; ?>

    <p class="big-red-text ">Отзывы к анкетам</p>
    <?php if ($user->review) : ?>
        <div class="d-flex flex-wrap">
            <?php foreach ($user->review as $item) {
                echo $this->renderFile(Yii::getAlias('@app/views/profile/article-review.php'),
                    [
                        'post' => $item['article'],
                        'item' => $item,
                    ]
                );
            } ?>
        </div>
    <?php endif; ?>

</div>
