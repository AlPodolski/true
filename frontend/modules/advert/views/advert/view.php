<?php

/* @var $advert array */
/* @var $this yii\web\View */

use frontend\widgets\SidebarWidget;
use frontend\widgets\UserSideBarWidget;
use frontend\widgets\PhotoWidget;
use frontend\widgets\CommentsFormWidget;

$commentsForm = new \frontend\models\forms\AddCommentForm();

if (isset($advert['title']) and !empty($advert['title'])) $this->title = mb_substr($advert['title'], 0, 125);
else $this->title = mb_substr($advert['text'], 0, 125);


$this->registerMetaTag([
        'name' => 'description',
        'content' =>  mb_substr($advert['text'], 0, 255),
]);

?>
<div class="row">

    <div class="col-3 filter-sidebar">

        <?php if (!Yii::$app->user->isGuest) : ?>

            <?php echo UserSideBarWidget::Widget()?>

        <?php endif; ?>

        <?php

            echo SidebarWidget::Widget()

        ?>
    </div>



    <div class="col-12 col-xl-9">

        <div class="anket advert-view advert-item">

            <?php if ($advert['userRelations']) : ?>

                <div class="col-12">
                    <div class="row user-info">
                        <div class="col-3 col-sm-2 col-md-1 ">
                            <div class="dialog-photo">
                                <a class="name" href="/user/<?php echo $advert['userRelations']['id'] ?>">
                                    <?php echo PhotoWidget::widget([
                                        'path' => $advert['userRelations']['userAvatarRelations']['file'],
                                        'size' => 'dialog',
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
                                <a class="name" href="/user/<?php echo $advert['userRelations']['id'] ?>">
                                    <?php echo  $advert['userRelations']['username'] ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <div class="col-12 advert-item-text">
                <div >
                        <?php echo $advert['title']; ?>
                </div>
                <div class="text-ab">

                        <?php echo $advert['text']; ?>

                </div>
            </div>

            <div class="comment-count-block">

                <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.8906 0.203125H2.10938C0.946289 0.203125 0 1.14941 0 2.3125V13.5625C0 14.7256 0.946289 15.6719 2.10938 15.6719H4.26562V19.1875C4.26562 19.7689 4.93048 20.0952 5.39062 19.75L10.8281 15.6719H21.8906C23.0537 15.6719 24 14.7256 24 13.5625V2.3125C24 1.14941 23.0537 0.203125 21.8906 0.203125ZM22.5938 13.5625C22.5938 13.9501 22.2783 14.2656 21.8906 14.2656H10.5938C10.4416 14.2656 10.2936 14.3151 10.1719 14.4062L5.67188 17.7812V14.9688C5.67188 14.5804 5.35712 14.2656 4.96875 14.2656H2.10938C1.72174 14.2656 1.40625 13.9501 1.40625 13.5625V2.3125C1.40625 1.92487 1.72174 1.60938 2.10938 1.60938H21.8906C22.2783 1.60938 22.5938 1.92487 22.5938 2.3125V13.5625Z" fill="#486BEF"/>
                </svg>
                <?php if (!empty($advert['comments'])) echo count($advert['comments']) ; else echo 0 ?>
            </div>

            <div class="comments-list">

                <?php if (!empty($advert['comments'])) : ?>
                    <?php /*комментарии к записи*/ ?>

                    <?php foreach ($advert['comments'] as $comment) : ?>

                        <?php echo $this->renderFile('@app/views/comment/comment-item.php', [
                            'comment' => $comment
                        ]); ?>

                    <?php endforeach; ?>

                <?php endif; ?>
            </div>

            <div class="comment-block comment-wall-form">
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