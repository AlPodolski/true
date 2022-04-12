<?php

/* @var $advert array */
/* @var $this yii\web\View */

use frontend\widgets\PhotoWidget;
use frontend\widgets\CommentsFormWidget;

$commentsForm = new \frontend\models\forms\AddCommentForm();

if (isset($advert['title']) and !empty($advert['title'])) $this->title = mb_substr($advert['title'], 0, 125);
else $this->title = mb_substr($advert['text'], 0, 125);

$this->title .= ' id '.$advert['id'];


$this->registerMetaTag([
        'name' => 'description',
        'content' =>  mb_substr($advert['text'], 0, 255) . ' id '.$advert['id'],
]);

if (isset($isCabinet) and $isCabinet){

    $this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
    $this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => '/cabinet/advert'];
    $this->params['breadcrumbs'][] = $this->title;

}


?>
<div class="container">
    <div class="row">

        <div class="col-12 col-xl-12 advert-wrap-items">

            <div class="anket advert-view advert-item">

                <?php if ($advert['userRelations']) : ?>

                    <div class="col-12">
                        <div class="row user-info">
                            <div class="col-3 col-sm-2 col-md-1 ">
                                <div class="dialog-photo">
                                    <a class="name">
                                        <?php echo PhotoWidget::widget([
                                            'path' => $advert['userRelations']['avatar']['file'],
                                            'size' => '59',
                                            'options' => [
                                                'class' => 'img',
                                                'loading' => 'lazy',
                                                'alt' => $advert['userRelations']['username'],
                                            ],
                                        ]); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-9 col-sm-10 col-md-11">
                                <div class="name">
                                    <a class="name red-text">
                                        <?php echo  $advert['userRelations']['username'] ?>
                                    </a>
                                </div>
                                <div class="created">
                                    <?php

                                    $day = time() - $advert['created_at'];

                                    $day = (intdiv($day, 3600 * 24));

                                    ?>

                                    <?php echo $day ?> <?php echo getNumEnding($day, ['день','дня', 'дней']); ?>

                                    назад
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($advert['category']) : ?>

                    <?php echo \yii\helpers\Html::a($advert['category']['value'],
                        '/cabinet/advert?category='.$advert['category']['id'],
                        ['class' => 'category-link popular-btn']
                    )
                    ?>

                <?php endif; ?>

                <div class="col-12 advert-item-text">
                    <div class="advert-item-title">
                        <?php echo $advert['title']; ?>
                    </div>
                    <div class="text-ab">

                        <?php echo $advert['text']; ?>

                    </div>
                </div>

                <div class="comments-list col-12">

                    <?php if (!empty($advert['comments'])) : ?>
                        <?php /*комментарии к записи*/ ?>

                        <?php foreach ($advert['comments'] as $comment) : ?>

                            <?php echo $this->renderFile('@app/views/comment/comment-item.php', [
                                'comment' => $comment
                            ]); ?>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>

                <div class="comment-block comment-wall-form col-12 position-relative">
                    <?php

                    echo CommentsFormWidget::widget([
                        'classRelatedModel' => \frontend\modules\advert\models\Advert::class,
                        'classCss' => 'form-horizontal form-wall-comment-' . $advert['id'],
                        'idCss' => 'wall-form',
                        'relatedId' => $advert['id'],
                    ]);

                    ?>
                </div>

            </div>

        </div>

    </div>
</div>
