<?php

/* @var $events \common\models\Event */

use frontend\widgets\PhotoWidget;

$this->title = 'Уведомления';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <div class="row">

        <div class="col-12">

            <div class="white-cabinet-block cabinet-nav-block margin-top-20">

                <h1><?php echo $this->title ?></h1>

                <?php foreach ($events as $event) : ?>

                    <div class="row">

                        <div class="col-12">

                            <div class="event-item">

                                <?php

                                switch ($event['type']) {

                                    case \common\models\Event::POST_RETURNED_FOR_REVISION : ?>

                                        <div class="row">

                                            <div class="col-3 col-sm-2 col-md-2 col-lg-1">

                                                <a class="position-relative"
                                                   href="/cabinet/post/edit/<?php echo $event['post']['id'] ?>">

                                                    <?php echo PhotoWidget::widget([
                                                        'path' => $event['post']['avatar']['file'],
                                                        'size' => '59',
                                                        'options' => [
                                                            'class' => 'img',
                                                            'loading' => 'lazy',
                                                            'alt' => $event['post']['name'],
                                                        ],
                                                    ]); ?>

                                                </a>

                                            </div>

                                            <div class="col-9 d-flex align-center event-content" >

                                                <div class="small-text">

                                                    Анкету
                                                    <a href="/cabinet/post/edit/<?php echo $event['post']['id'] ?>">
                                                        <?php echo $event['post']['name'] ?>
                                                    </a>
                                                    вернули на доработку
                                                    <br>
                                                    <span class="event-date">
                                                        <?php

                                                            if ($event['created_at']){

                                                                if (date('Ymd', $event['created_at']) == date('Ymd', time()) ){

                                                                    echo 'Сегодня '.date('H:m', $event['created_at']);

                                                                }else{

                                                                    echo date('Y-m-d H:i:s', $event['created_at']);

                                                                }

                                                            }

                                                        ?>
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                        <?php break;

                                    case \common\models\Event::POST_ON_PUPLICATION_STATUS : ?>

                                        <div class="row">

                                            <div class="col-3 col-sm-2 col-md-2 col-lg-1">

                                                <a class="position-relative"
                                                   href="/cabinet/post/edit/<?php echo $event['post']['id'] ?>">

                                                    <?php echo PhotoWidget::widget([
                                                        'path' => $event['post']['avatar']['file'],
                                                        'size' => '59',
                                                        'options' => [
                                                            'class' => 'img',
                                                            'loading' => 'lazy',
                                                            'alt' => $event['post']['name'],
                                                        ],
                                                    ]); ?>

                                                </a>

                                            </div>

                                            <div class="col-9 d-flex align-center event-content" >

                                                <div class="small-text">

                                                    Анкета
                                                    <a href="/cabinet/post/edit/<?php echo $event['post']['id'] ?>">
                                                        <?php echo $event['post']['name'] ?>
                                                    </a>
                                                    одобрена и публикуется
                                                    <br>
                                                    <span class="event-date">
                                                        <?php

                                                            if ($event['created_at']){

                                                                if (date('Ymd', $event['created_at']) == date('Ymd', time()) ){

                                                                    echo 'Сегодня '.date('H:m', $event['created_at']);

                                                                }else{

                                                                    echo 'Сегодня '.date('Y-m-d H:i:s', $event['created_at']);

                                                                }

                                                            }

                                                        ?>
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                        <?php break;

                                }

                                ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</div>

