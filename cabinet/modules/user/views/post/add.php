<?php

/* @var $this \yii\web\View */
/* @var $post \cabinet\modules\user\models\Posts */
/* @var $city array */
/* @var $cityList \common\models\City[] */

use cabinet\modules\user\models\UserService;
use yii\base\BaseObject;
use cabinet\modules\user\models\forms\CheckPhotoForm;

$videoForm = new \cabinet\modules\user\models\forms\VideoForm();
$selphiForm = new \cabinet\modules\user\models\forms\SelphiForm();
$avatarForm = new \cabinet\modules\user\models\forms\AvatarForm();
$photoForm = new \cabinet\modules\user\models\forms\PhotoForm();
$userNational = new \cabinet\modules\user\models\UserNational();
$userMetro = new \cabinet\models\UserMetro();
$userPlace = new \cabinet\modules\user\models\UserPlace();
$userOsobenosti = new \cabinet\modules\user\models\UserOsobenosti();
$userService = new \cabinet\modules\user\models\UserService();
$checkPhotoForm = new CheckPhotoForm();
$userTime = new \cabinet\modules\user\models\UserTime();

$this->title = 'Добавить анкету';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

if (isset($add_more)){

    $userMetro =  new \cabinet\models\UserMetro();

    $userMetro->metro_id = \yii\helpers\ArrayHelper::getColumn(\cabinet\models\UserMetro::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'metro_id');


    $userPlace = new \cabinet\modules\user\models\UserPlace();

    $userPlace->place_id = \yii\helpers\ArrayHelper::getColumn(\cabinet\modules\user\models\UserPlace::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'place_id');

    $userOsobenosti = new \cabinet\modules\user\models\UserOsobenosti();

    $userOsobenosti->param_id = \yii\helpers\ArrayHelper::getColumn(\cabinet\modules\user\models\UserOsobenosti::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

    $userService = UserService::find()->where(['post_id' => $post['id']])->asArray()->all();

    $userTime = new \cabinet\modules\user\models\UserTime();

    $userTime->param_id = \yii\helpers\ArrayHelper::getColumn(\cabinet\modules\user\models\UserTime::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

}

?>
    <div class="container">
        <div class="row">
            <div class="col-12 margin-top-20">
                <?php echo \yii\helpers\Html::tag('h1', 'Добавить анкету'); ?>
            </div>
        </div>
    </div>

<?php


echo $this->renderFile(Yii::getAlias('@user-view/post/_form.php'), [
    'post' => $post,
    'city' => $city,
    'videoForm' => $videoForm,
    'avatarForm' => $avatarForm,
    'photoForm' => $photoForm,
    'userMetro' => $userMetro,
    'userPlace' => $userPlace,
    'userOsobenosti' => $userOsobenosti,
    'userService' => $userService,
    'checkPhotoForm' => $checkPhotoForm,
    'userTime' => $userTime,
    'selphiForm' => $selphiForm,
    'cityList' => $cityList,
    'add_more' => $add_more,
]);