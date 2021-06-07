<?php

/* @var $user \common\models\User */
/* @var $posts \frontend\modules\user\models\Posts[] */

use frontend\widgets\PhotoWidget;
use frontend\modules\chat\components\helpers\GetDialogsHelper;

$this->title = 'Кабинет';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container margin-top-20">

    <?php if (Yii::$app->user->identity['status'] == \common\models\User::STATUS_INACTIVE) : ?>

        <div class="alert-success alert alert-dismissible"> Для добавления анкеты нужно активировать почту</div>

    <?php endif; ?>

    <?php if (!$user['telegram']) : ?>

        <div class="alert alert-info">
            Активировать <?php echo \yii\helpers\Html::a('Телеграм', '/cabinet/telegram') ?>
        </div>

    <?php endif; ?>

    <div class="row">

        <?php echo \frontend\modules\user\widgets\SidebarWidget::widget(['user' => $user]) ?>

        <div class="col-12 col-md-12 col-lg-6 col-xl-7">
            <div class="row">

                <div class="col-12 black-text font-weight-bold">
                    Мои анкеты
                </div>

                <?php if (Yii::$app->user->identity['status'] == \common\models\User::STATUS_ACTIVE) : ?>

                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="white-cabinet-block cabinet-nav-block margin-top-20 d-flex items-center nav-cabinet-block">

                            <div class="plus-wrap d-flex items-center">
                                <a href="/cabinet/post/add">
                                <span class="plus d-flex items-center">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4 5.4H6.60004V0.599963C6.60004 0.268835 6.3312 0 5.99996 0C5.66884 0 5.4 0.268835 5.4 0.599963V5.4H0.599963C0.268835 5.4 0 5.66884 0 5.99996C0 6.3312 0.268835 6.60004 0.599963 6.60004H5.4V11.4C5.4 11.7312 5.66884 12 5.99996 12C6.3312 12 6.60004 11.7312 6.60004 11.4V6.60004H11.4C11.7312 6.60004 12 6.3312 12 5.99996C12 5.66884 11.7312 5.4 11.4 5.4Z" fill="white"/>
                                    </svg>
                                </span>
                                </a>
                            </div>
                            <div class="red-text text-center margin-top-20">
                                <a class="red-text" href="/cabinet/post/add">
                                    Добавить <br> анкету
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endif; ?>

                <?php foreach ($posts as $post) : ?>

                    <div class="col-6 col-md-4 col-lg-6 col-sm-6">

                        <?php

                        $postStatus = [];

                        switch ($post['status']) {
                            case \frontend\modules\user\models\Posts::POST_ON_MODARATION_STATUS:
                                $postStatus['key'] = 'mod';
                                $postStatus['value'] = 'Анкета на модерации';
                                break;
                            case \frontend\modules\user\models\Posts::POST_ON_PUPLICATION_STATUS:
                                $postStatus['key'] = 'pub';
                                $postStatus['value'] = 'Анкета на публикации';
                                break;
                            case \frontend\modules\user\models\Posts::POST_DONT_PUBLICATION_STATUS:
                                $postStatus['key'] = 'stop';
                                $postStatus['value'] = 'Анкета не публикуется';
                                break;
                            case \frontend\modules\user\models\Posts::RETURNED_FOR_REVISION:
                                $postStatus['key'] = 'return';
                                $postStatus['value'] = 'Анкету вернули на доработку';
                                break;
                        }

                        ?>

                        <div class="white-cabinet-block cabinet-nav-block margin-top-20 d-flex items-center nav-cabinet-block">

                            <div class="anket-info">
                                <span class="<?php echo $postStatus['key']?>"><?php echo $postStatus['value'] ?></span>
                            </div>


                            <a href="/cabinet/post/edit/<?= $post['id'] ?>">

                                <?php echo PhotoWidget::widget([
                                    'path' => $post['avatar']['file'],
                                    'size' => '100_100',
                                    'options' => [
                                        'class' => 'img user-img cabinet-img',
                                        'loading' => 'lazy',
                                        'alt' => $post['name'],
                                    ],
                                ]); ?>

                            </a>

                            <div class="user-name-full">

                                <a class="user-name-full" href="/cabinet/post/edit/<?= $post['id'] ?>">
                                    <?= $post['name'] ?>
                                </a>
                            </div>

                            <div class="edit-block margin-top-20">

                                <a href="/cabinet/post/edit/<?= $post['id'] ?>" class="edit-anket edit-block-item d-flex items-center">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.531 0L2.62518 13.9058L0 22L8.0942 19.3749L22 5.46902L16.531 0ZM20.177 5.46902L18.354 7.29205L14.7079 3.64603L16.5309 1.82299L20.177 5.46902ZM3.47888 15.452L6.54801 18.5212L5.17146 18.9676L3.03239 16.8285L3.47888 15.452ZM4.10197 14.2521L13.7964 4.55757L15.1637 5.92483L5.46919 15.6193L4.10197 14.2521ZM6.38069 16.5308L16.0752 6.83624L17.4425 8.20351L7.74795 17.8981L6.38069 16.5308ZM2.58599 18.2051L3.79496 19.4141L2.00565 19.9943L2.58599 18.2051Z" fill="white"/>
                                    </svg>
                                </a>
                                <a href="/cabinet/up/<?= $post['id'] ?>" class="edit-anket up-anket edit-block-item d-flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                            <path d="M7.14072 8.07527V7.57527H6.64072H4.56939L12.0002 0.539654L19.4313 7.57527H17.3599H16.8599V8.07527V14.8138H7.14072V8.07527Z" stroke="white"/>
                                            <path d="M7.14071 20.1567H16.8599V20.6045H7.14071V20.1567Z" stroke="white"/>
                                            <path d="M16.8599 17.709H7.14071V17.2612H16.8599V17.709Z" stroke="white"/>
                                            <path d="M7.14071 23.0522H16.8599V23.5H7.14071V23.0522Z" stroke="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0">
                                                <rect width="24" height="24" fill="white" transform="translate(24) rotate(90)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>

                            </div>

                            <div class="alert-small-text">

                                <?php if($post['message']) : ?>

                                    <?php echo count($post['message']) .' '. getNumEnding(count($post['message']), ['Сообщение', 'Сообщения', 'Сообщений']); ?>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    </div>
</div>
<?php
