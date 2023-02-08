<?php
/* @var $advertList Advert[] */
/* @var $this View */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $isCabinet bool|null */

/* @var $category array|null */

use frontend\modules\advert\models\Advert;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = ' Частные интим объявления в Москве , доска объявлений интима на сайте sex-true ';

if ($isCabinet) $this->title = 'Объявления';

if ($isCabinet) Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
else Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => 'Доска секс объявлений Москвы, поиск интим объявлений в Москве на сайте sex-true. Частные интим объявления на секс форуме '
]);

if ($isCabinet) $this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];

if ($category) {

    $this->title = $category['value'];

    $this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => '/cabinet/advert'];

}

if ($isCabinet) {
    $h1 = $this->title;
} else $h1 = 'Доска интим объявлений';

$this->params['breadcrumbs'][] = 'Объявления';

?>
<div class="container">
    <div class="row">
        <div data-url="<?php echo Yii::$app->request->url ?>" class="col-12"></div>
    </div>
    <div class="row">

        <div class="col-12">

            <div class="anket content advert-page">

                <h1><?php echo $h1 ?></h1>

                <div class="add-advert-wrap" <?php if (Yii::$app->user->isGuest) : ?>
                    data-toggle="modal" data-target="#addAdvertModal"
                <?php else : ?>
                    data-toggle="modal" data-target="#addAdvertModal"
                <?php endif; ?>
                >
                    <div class="add-advert-btn">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1199 7.1875H9.8125V1.88008C9.8125 1.18691 9.22598 0.625 8.5 0.625C7.77402 0.625 7.1875 1.18691 7.1875 1.88008V7.1875H1.88008C1.18691 7.1875 0.625 7.77402 0.625 8.5C0.625 9.22598 1.18691 9.8125 1.88008 9.8125H7.1875V15.1199C7.1875 15.8131 7.77402 16.375 8.5 16.375C9.22598 16.375 9.8125 15.8131 9.8125 15.1199V9.8125H15.1199C15.8131 9.8125 16.375 9.22598 16.375 8.5C16.375 7.77402 15.8131 7.1875 15.1199 7.1875Z"
                                  fill="white"/>
                        </svg>
                    </div>
                </div>

                <?php if ($advertList) : foreach ($advertList as $advert) : ?>

                    <?php echo $this->renderFile('@app/modules/advert/views/advert/item.php', [
                        'advert' => $advert,
                        'isCabinet' => $isCabinet,
                    ]) ?>

                <?php endforeach; ?>

                <?php else : ?>

                    <a class="black-text font-weight-bold d-block text-center padding-top-0">
                        Пока нет объявлений</a>

                <?php endif; ?>

            </div>

        </div>

        <div id="addAdvertModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 14.75L14.75 1.25" stroke="black" stroke-width="2"/>
                                <path d="M1.25 1.25L14.75 14.75" stroke="black" stroke-width="2"/>
                            </svg>
                        </button>
                    </div>

                    <div class="modal-body modal-city-search">

                        <?php if (Yii::$app->user->isGuest) : ?>

                            <div class="col-12">

                                <div class="authorisation-block d-flex items-center">
                                    <a class="black-text font-weight-bold d-block text-center padding-top-0">
                                        Для добавления объявления требуется авторизация</a>
                                </div>

                            </div>

                        <?php else: ?>

                            <?php $advertForm = ActiveForm::begin(
                                ['action' => '/forum/add']
                            ); ?>

                            <?php $modelAdvert = new \frontend\modules\advert\models\Advert() ?>

                            <div class="col-12">

                                <p class="name heading-anket red-text">Создать объявление</p>

                                <?= $advertForm->field($modelAdvert, 'title')
                                    ->textInput(['placeholder' => 'Заголовок темы', 'id' => ''])
                                    ->label(false) ?>

                                <?php if ($isCabinet) : ?>

                                    <?= $advertForm->field($modelAdvert, 'type')
                                        ->hiddenInput(['value' => Advert::PRIVATE_CABINET_TYPE])
                                        ->label(false) ?>

                                    <?= $advertForm->field($modelAdvert, 'category_id')
                                        ->dropDownList(ArrayHelper::map(\common\models\AdvertCategory::find()->all(), 'id', 'value'))
                                        ->label('Категория') ?>

                                <?php else : ?>

                                    <?= $advertForm->field($modelAdvert, 'type')
                                        ->hiddenInput(['value' => Advert::PUBLIC_TYPE])
                                        ->label(false) ?>

                                <?php endif; ?>

                                <?= $advertForm->field($modelAdvert, 'text')
                                    ->textarea(['placeholder' => 'Описание', 'id' => ''])->label(false) ?>

                                <p>
                                    Стоимость объявления
                                    <?php echo Yii::$app->params['advert_price']?>
                                    руб.
                                </p>

                            </div>

                            <script defer src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_"></div>

                            <div class="col-12">

                                <div class="form-group text-center">

                                    <?= Html::submitButton('Сохранить', ['class' => 'type-btn add-button orange-btn']) ?>

                                </div>

                            </div>

                            <?php ActiveForm::end() ?>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <?php if ($isCabinet) : ?>

            <div class="col-12 pager" data-url="/cabinet/more-adverds" data-page="1"></div>

        <?php else : ?>

            <div class="col-12 pager" data-page="<?php echo Yii::$app->request->get('page') ?? 1 ?>"
                 data-adress="<?php echo Yii::$app->request->url ?>"
                 data-reqest="<?php echo Yii::$app->request->url ?>"></div>

        <?php endif; ?>

        <?php if ($pages) echo \yii\bootstrap4\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>


    </div>

</div>



