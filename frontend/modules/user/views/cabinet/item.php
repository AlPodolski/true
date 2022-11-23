<?php

/* @var $post \frontend\modules\user\models\Posts */
/* @var $tarifList \common\models\Tarif[] */

use frontend\widgets\PhotoWidget;
use frontend\modules\user\helpers\ViewCountHelper;
use frontend\modules\user\models\Posts;

?>

<div class="col-12 col-md-4 col-lg-6 col-sm-6 cabinet-item">

    <?php

    $postStatus = [];

    switch ($post['status']) {
        case Posts::POST_ON_MODARATION_STATUS:
            $postStatus['key'] = 'mod';
            $postStatus['value'] = 'Анкета на модерации';
            break;
        case Posts::POST_ON_PUPLICATION_STATUS:
            $postStatus['key'] = 'pub';
            $postStatus['value'] = 'Остановить публикацию';
            break;
        case Posts::POST_DONT_PUBLICATION_STATUS:
            $postStatus['key'] = 'stop';
            $postStatus['value'] = 'Поставить на публикацию';
            break;
        case Posts::RETURNED_FOR_REVISION:
            $postStatus['key'] = 'return';
            $postStatus['value'] = 'Анкету вернули на доработку';
            break;
    }

    ?>

    <div class="white-cabinet-block cabinet-nav-block d-flex items-center nav-cabinet-block">

        <div class="anket-info publication-info">

            <input data-id="<?php echo $post['id'] ?>" onclick="check_checbox()"
                   type="checkbox" class="checbox checbox-publication">

            <a data-id="<?php echo $post['id'] ?>" onclick="publication(this)"
                  data-key="<?php echo $postStatus['key'] ?>"
                  class="cursor-pointer table-d-none publication-btn <?php echo $postStatus['key'] ?>"><?php echo $postStatus['value'] ?></a>
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

        <div class="name-publication-wrap d-flex">

            <a class="user-name-full" href="/cabinet/post/edit/<?= $post['id'] ?>">
                <?= $post['name'] ?>
            </a>

            <div class="anket-info">
                <a data-id="<?php echo $post['id'] ?>" onclick="publication(this)"
                   data-key="<?php echo $postStatus['key'] ?>"
                   class="cursor-pointer publication-btn <?php echo $postStatus['key'] ?>"><?php echo $postStatus['value'] ?></a>
            </div>

        </div>

        <div class="edit-block margin-top-20">

            <a href="/cabinet/post/edit/<?= $post['id'] ?>" class="edit-anket edit-block-item d-flex items-center">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.531 0L2.62518 13.9058L0 22L8.0942 19.3749L22 5.46902L16.531 0ZM20.177 5.46902L18.354 7.29205L14.7079 3.64603L16.5309 1.82299L20.177 5.46902ZM3.47888 15.452L6.54801 18.5212L5.17146 18.9676L3.03239 16.8285L3.47888 15.452ZM4.10197 14.2521L13.7964 4.55757L15.1637 5.92483L5.46919 15.6193L4.10197 14.2521ZM6.38069 16.5308L16.0752 6.83624L17.4425 8.20351L7.74795 17.8981L6.38069 16.5308ZM2.58599 18.2051L3.79496 19.4141L2.00565 19.9943L2.58599 18.2051Z"
                          fill="white"/>
                </svg>
            </a>

            <?php if ($post['status'] == Posts::POST_ON_PUPLICATION_STATUS or $post['status'] == Posts::POST_DONT_PUBLICATION_STATUS) : ?>

                <a href="/cabinet/up/<?= $post['id'] ?>" class="edit-anket position-relative up-anket edit-block-item d-flex items-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(.clip0)">
                            <path d="M7.14072 8.07527V7.57527H6.64072H4.56939L12.0002 0.539654L19.4313 7.57527H17.3599H16.8599V8.07527V14.8138H7.14072V8.07527Z"
                                  stroke="white"/>
                            <path d="M7.14071 20.1567H16.8599V20.6045H7.14071V20.1567Z" stroke="white"/>
                            <path d="M16.8599 17.709H7.14071V17.2612H16.8599V17.709Z" stroke="white"/>
                            <path d="M7.14071 23.0522H16.8599V23.5H7.14071V23.0522Z" stroke="white"/>
                        </g>
                        <defs>
                            <clipPath class="clip0">
                                <rect width="24" height="24" fill="white" transform="translate(24) rotate(90)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>

            <?php endif; ?>

            <div class="delete-item edit-block-item" data-name="<?= $post['name'] ?>" onclick="delete_item(this)"
                 data-id="<?= $post['id'] ?>">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(.clip0_576_92)">
                        <path d="M11.4826 6.52148C11.2497 6.52148 11.061 6.71019 11.061 6.94303V14.9102C11.061 15.1429 11.2497 15.3318 11.4826 15.3318C11.7154 15.3318 11.9041 15.1429 11.9041 14.9102V6.94303C11.9041 6.71019 11.7154 6.52148 11.4826 6.52148Z"
                              fill="white"/>
                        <path d="M6.50846 6.52148C6.27562 6.52148 6.08691 6.71019 6.08691 6.94303V14.9102C6.08691 15.1429 6.27562 15.3318 6.50846 15.3318C6.7413 15.3318 6.93001 15.1429 6.93001 14.9102V6.94303C6.93001 6.71019 6.7413 6.52148 6.50846 6.52148Z"
                              fill="white"/>
                        <path d="M2.88329 5.35877V15.7447C2.88329 16.3586 3.10839 16.9351 3.50161 17.3487C3.89302 17.7635 4.43774 17.999 5.00781 18H12.9836C13.5538 17.999 14.0985 17.7635 14.4898 17.3487C14.883 16.9351 15.1081 16.3586 15.1081 15.7447V5.35877C15.8897 5.15129 16.3963 4.39614 16.2917 3.59405C16.187 2.79213 15.5038 2.19225 14.6949 2.19209H12.5367V1.66516C12.5391 1.22204 12.3639 0.796544 12.0502 0.483514C11.7365 0.170649 11.3104 -0.00356726 10.8673 5.53875e-05H7.12409C6.68098 -0.00356726 6.25482 0.170649 5.94113 0.483514C5.62745 0.796544 5.45224 1.22204 5.45471 1.66516V2.19209H3.29644C2.4876 2.19225 1.8044 2.79213 1.69967 3.59405C1.59511 4.39614 2.10162 5.15129 2.88329 5.35877ZM12.9836 17.1569H5.00781C4.28707 17.1569 3.72638 16.5378 3.72638 15.7447V5.39582H14.265V15.7447C14.265 16.5378 13.7043 17.1569 12.9836 17.1569ZM6.2978 1.66516C6.295 1.44566 6.38129 1.23439 6.53706 1.07944C6.69267 0.924489 6.90443 0.839357 7.12409 0.843144H10.8673C11.0869 0.839357 11.2987 0.924489 11.4543 1.07944C11.6101 1.23423 11.6964 1.44566 11.6936 1.66516V2.19209H6.2978V1.66516ZM3.29644 3.03517H14.6949C15.114 3.03517 15.4537 3.37488 15.4537 3.79395C15.4537 4.21303 15.114 4.55273 14.6949 4.55273H3.29644C2.87736 4.55273 2.53766 4.21303 2.53766 3.79395C2.53766 3.37488 2.87736 3.03517 3.29644 3.03517Z"
                              fill="white"/>
                        <path d="M8.99576 6.52148C8.76293 6.52148 8.57422 6.71019 8.57422 6.94303V14.9102C8.57422 15.1429 8.76293 15.3318 8.99576 15.3318C9.2286 15.3318 9.41731 15.1429 9.41731 14.9102V6.94303C9.41731 6.71019 9.2286 6.52148 8.99576 6.52148Z"
                              fill="white"/>
                    </g>
                    <defs>
                        <clipPath class="clip0_576_92">
                            <rect width="18" height="18" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>

        </div>

        <div class="alert-small-text table-d-none">

            <?php if ($post['message']) : ?>

                <?php echo count($post['message']) . ' ' . getNumEnding(count($post['message']), ['Сообщение', 'Сообщения', 'Сообщений']); ?>

            <?php endif; ?>

        </div>


        <div class="alert-small-text table-d-none">

            Просмотров
            анкеты(Детальной страницы): <?php echo ViewCountHelper::countView($post['id'] , Yii::$app->params['redis_post_single_view_count_key']) ?? 0 ?>

        </div>

        <div class="alert-small-text margin-top-10 table-d-none">
            Просмотров
            телефона: <?php echo ViewCountHelper::countView($post->id, Yii::$app->params['redis_view_phone_count_key']) ?? 0 ?>
        </div>


        <?php if ($post['status'] == Posts::POST_ON_PUPLICATION_STATUS or $post['status'] == Posts::POST_DONT_PUBLICATION_STATUS) : ?>

            <div class="anket-info send-to-telegram table-d-none">
                <span onclick="send_to_telegram(this)" data-id="<?php echo $post['id'] ?>" class="cursor-pointer">
                    Опубликовать в телегам канале (<?php echo Yii::$app->params['publication_telegram_cost'] ?>р.)
                </span>
            </div>

        <?php endif; ?>

        <div class="tarif-wrap w-100" >
            <select onchange="update_tarif(this)"
                     data-id="<?php echo $post['id'] ?>"
                    class="form-control" name="tarif" id="tarif-<?php echo $post['id'] ?>">

                <?php foreach ($tarifList as $tarif) : ?>

                    <option
                            <?php if ($tarif->id == $post['tarif_id']) echo 'selected' ?>
                            value="<?php echo $tarif->id ?>"><?php echo $tarif->value ?> - <?php echo $tarif->sum ?>р.</option>

                <?php endforeach; ?>

            </select>
        </div>

    </div>

</div>
