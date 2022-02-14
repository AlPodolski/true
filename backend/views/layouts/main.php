<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\AdminLteAsset;
use common\assets\FontAwesomeAsset;

AppAsset::register($this);
AdminLteAsset::register($this);
FontAwesomeAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue sidebar-mini wrapper sidebar-collapse">
<?php $this->beginBody() ?>
<header>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
</header>
<div class="wrap">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i> <p>Меню</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Главная</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/posts/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Анкеты</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/meta-template/index" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Мета теги</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/advert/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Объявления</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/chat?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Тикеты</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/history/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Платежи</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/claim/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Обратная связь</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/anket-claim/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Жалобы на анкету</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Пользователи</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/link/index" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Быстрые ссылки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/review/index?sort=-id" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Комментарии</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/filter-params/index" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Параметры фильтров</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/redirect/index" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Редиректы</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/site/drop-cache" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Удалить кеш</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
