<?php

/* @var $user \common\models\User */
/* @var $posts \frontend\modules\user\models\Posts[] */
/* @var $this \yii\web\View */
/* @var $viewType string|null */

use frontend\widgets\PhotoWidget;
use frontend\modules\chat\components\helpers\GetDialogsHelper;

$this->title = 'Кабинет';

$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container margin-top-20">

        <?php echo $this->renderFile(Yii::getAlias('@user-view/cabinet/info.php'), compact('user')) ?>

        <div class="row">

            <?php echo \frontend\modules\user\widgets\SidebarWidget::widget(['user' => $user]) ?>

            <div class="col-12 col-md-12 col-lg-6 col-xl-7 <?php echo $viewType ?>">

                <div class="row">

                    <div class="col-12 d-flex head-view-wrap">
                        <span class="black-text font-weight-bold">Мои анкеты (<?php if ($posts) echo count($posts)?>)</span>
                        <div class="order-block">
                            <select class="metro-select" name="limit" id="sort-select" onchange="setView()">

                                <option value="default">Вид</option>

                                <option value="default">По умолчанию</option>
                                <option <?php if ($viewType == 'table') echo 'selected'?> value="table">Таблица</option>

                            </select>
                        </div>
                    </div>


                    <div class="col-12 col-md-4 col-lg-6 cabinet-item">
                        <div class="white-cabinet-block cabinet-nav-block d-flex items-center nav-cabinet-block">

                            <div class="plus-wrap d-flex items-center">
                                <a href="/cabinet/post/add">
                                <span class="plus d-flex items-center">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4 5.4H6.60004V0.599963C6.60004 0.268835 6.3312 0 5.99996 0C5.66884 0 5.4 0.268835 5.4 0.599963V5.4H0.599963C0.268835 5.4 0 5.66884 0 5.99996C0 6.3312 0.268835 6.60004 0.599963 6.60004H5.4V11.4C5.4 11.7312 5.66884 12 5.99996 12C6.3312 12 6.60004 11.7312 6.60004 11.4V6.60004H11.4C11.7312 6.60004 12 6.3312 12 5.99996C12 5.66884 11.7312 5.4 11.4 5.4Z"
                                              fill="white"/>
                                    </svg>
                                </span>
                                </a>
                            </div>

                            <div class="red-text add-anket text-center margin-top-20">
                                <a class="red-text" href="/cabinet/post/add">
                                    Добавить <br> анкету
                                </a>
                            </div>

                            <div class="text-center add-anket-table">
                                <a class="red-text" href="/cabinet/post/add">
                                    Добавить анкету
                                </a>
                            </div>

                        </div>
                    </div>


                    <?php foreach ($posts as $post) {

                        echo $this->renderFile(
                            Yii::getAlias('@app/modules/user/views/cabinet/item.php'),
                            compact('post', 'tarifList')
                        );

                    } ?>

                </div>

            </div>

        </div>
    </div>
<?php
