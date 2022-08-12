<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */

$this->title = $user->username;

?>

<div class="container">
    <h1 class=""><?php echo $user->username ?></h1>
    <p class="">Дата регистрации - <?php echo date("Y-m-d", $user->created_at )  ?></p>
    <p class="big-red-text ">Отзывы к анкетам</p>
    <div class="d-flex flex-wrap">

        <?php foreach ($user->review as $item) {
            echo $this->renderFile(Yii::getAlias('@app/views/profile/article-review.php'),
                [
                    'post' => $item['article'],
                    'item' => $item,
                ]
            );
        }?>
    </div>


</div>
