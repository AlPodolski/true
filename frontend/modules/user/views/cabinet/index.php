<?php

/* @var $user \common\models\User */
/* @var $posts \frontend\modules\user\models\Posts[] */
/* @var $this \yii\web\View */

/* @var $viewType string|null */

use frontend\widgets\PhotoWidget;
use frontend\modules\chat\components\helpers\GetDialogsHelper;

$this->registerJsFile('/js/jquery.maskedinput.js', ['depends' => [yii\web\YiiAsset::className()]]);

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
                        <span class="black-text font-weight-bold">

                            Мои анкеты <?php if ($posts) {
                                echo '(' . count($posts) . ')';
                            } ?>

                        </span>


                    <div class="order-block">
                        <select class="metro-select" name="limit" id="sort-select" onchange="setView()">

                            <option value="default">Вид</option>

                            <option value="default">По умолчанию</option>
                            <option <?php if ($viewType == 'table') echo 'selected' ?> value="table">Таблица
                            </option>

                        </select>
                    </div>

                </div>

                <div class="nav-posts d-flex col-12">
                    <div class="change-tarif-active" data-type="start" onclick="start_all(this)">Включить все
                        анкеты
                    </div>
                    <div class="change-tarif-active" data-type="stop" onclick="start_all(this)">Выключит все
                        анкеты
                    </div>
                </div>

                <div class="nav-posts select-all d-flex col-12">
                    <div data-type="start"
                         onclick="set_selected_all(this)">
                        Выделить все
                    </div>
                </div>

                <div class="nav-posts post-publication-nav d-flex col-12">

                    <div data-type="start"
                         onclick="get_phone_modal(this)">
                        Сменить номер
                    </div>

                    <div data-type="start"
                         onclick="start_all_selected(this)">
                        Включить выделенные
                    </div>

                    <div data-type="stop" onclick="start_all_selected(this)">
                        Выключит выделенные
                    </div>
                    <div data-type="stop" class="start-all" onclick="up_all_selected()">
                        Поднять выделенные (<?php echo Yii::$app->params['up_anket_cost'] ?>р. анкета)
                    </div>

                    <div class="w-100">
                        <div class="update_tarif-wrap">
                            <label for="update_tarif">Сменить тариф на выбранных анкетах</label>
                            <select name="update_tarif" class="update_tarif form-control" id="update_tarif" disabled>
                                <?php foreach ($tarifList as $tarif) : ?>
                                    <?php /* @var $tarif \common\models\Tarif */ ?>
                                    <option value="<?php echo $tarif->id ?>"><?php echo $tarif->value ?>
                                        - <?php echo $tarif->sum ?> р/час
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <?php if ($statData) : ?>

                    <div class="col-12">
                        <div class="stat-post white-cabinet-block d-flex">
                            <div class="stat-post-item d-flex">
                                <img src="/img/phone-call-svgrepo-com.svg" alt="">
                                <div class="info d-flex">
                                    <div class="stat-top-info">Просмотров телефона</div>
                                    <div class="stat-bottom-info"><?php echo $statData['phone_view'] ?></div>
                                </div>
                            </div>
                            <div class="stat-post-item d-flex">
                                <img src="/img/1915454.svg" alt="">
                                <div class="info d-flex">
                                    <div class="stat-top-info">Просмотров анкет</div>
                                    <div class="stat-bottom-info"><?php echo $statData['post_view'] ?></div>
                                </div>
                            </div>
                            <div class="stat-post-item d-flex">
                                <img src="/img/pc-computer-with-monitor_icon-icons.com_56249.svg" alt="">
                                <div class="info d-flex">
                                    <div class="stat-top-info">Показов на сайте</div>
                                    <div class="stat-bottom-info"><?php echo $statData['post_show'] ?></div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endif; ?>

                <div class="col-12 black-text font-weight-bold">
                    <?php if ($posts) {

                        $sum = 0;

                        foreach ($posts as $post) {

                            if ($post->status == \frontend\modules\user\models\Posts::POST_ON_PUPLICATION_STATUS) {

                                $sum = $sum + $post->tarif->sum;

                            }

                        }

                        if ($sum) echo 'Стоимость публикации включенных анкет в час ' . $sum . 'р.';

                    } ?>
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

<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phoneModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-close-wrap">
                <svg data-dismiss="modal" aria-label="Close" width="34" height="34" viewBox="0 0 34 34" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.0282 4.97991C22.399 -1.64923 11.6092 -1.64923 4.98005 4.97991C1.76888 8.19234 0 12.4625 0 17.0039C0 21.5454 1.76888 25.8155 4.98005 29.0267C8.29529 32.3419 12.6497 33.9989 17.0041 33.9989C21.3585 33.9989 25.713 32.3419 29.0281 29.0267C35.6573 22.3976 35.6573 11.6103 29.0282 4.97991ZM27.1657 27.1643C21.5627 32.7673 12.4455 32.7673 6.84243 27.1643C4.12918 24.451 2.63423 20.8421 2.63423 17.0039C2.63423 13.1658 4.12918 9.55687 6.84243 6.84229C12.4455 1.23921 21.5627 1.24054 27.1657 6.84229C32.7675 12.4454 32.7675 21.5625 27.1657 27.1643Z"
                          fill="#0F2C93"/>
                    <path d="M22.6797 20.6411L18.9509 16.9176L22.6797 13.1941C23.1933 12.6804 23.1933 11.8467 22.681 11.3316C22.166 10.8153 21.3323 10.8166 20.8173 11.3303L17.0859 15.0564L13.3545 11.3303C12.8395 10.8166 12.0058 10.8153 11.4908 11.3316C10.9771 11.8466 10.9771 12.6803 11.4921 13.1941L15.2209 16.9176L11.4921 20.6411C10.9771 21.1547 10.9771 21.9885 11.4908 22.5035C11.7477 22.7616 12.0861 22.8894 12.4233 22.8894C12.7606 22.8894 13.0977 22.7603 13.3546 22.5048L17.086 18.7786L20.8174 22.5048C21.0742 22.7616 21.4114 22.8894 21.7486 22.8894C22.0858 22.8894 22.4243 22.7603 22.6811 22.5035C23.1947 21.9885 23.1947 21.1547 22.6797 20.6411Z"
                          fill="#0F2C93"/>
                </svg>
            </div>
            <div class="modal-body phone-modal-body">
                <div class="claim__modal">
                    <p class="phone-heading">Введите новый номер</p>
                    <div class="form-group field-posts-phone required">
                        <input type="text" id="posts-phone-update"
                               class="form-control" name="phone" value="">
                    </div>
                </div>
                <div class="btn btn-success d-block" onclick="updatePhone(this)">Изменить</div>
            </div>
        </div>
    </div>
</div>
