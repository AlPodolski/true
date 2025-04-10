<?php

/* @var $this \yii\web\View */
/* @var $post \cabinet\modules\user\models\Posts */
/* @var $city array */
/* @var $cityList \common\models\City[] */

use frontend\modules\user\models\UserService;
use yii\base\BaseObject;
use frontend\modules\user\models\forms\CheckPhotoForm;

$videoForm = new \frontend\modules\user\models\forms\VideoForm();
$selphiForm = new \frontend\modules\user\models\forms\SelphiForm();
$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();
$photoForm = new \frontend\modules\user\models\forms\PhotoForm();
$userNational = new \frontend\modules\user\models\UserNational();
$userMetro = new \frontend\models\UserMetro();
$userPlace = new \frontend\modules\user\models\UserPlace();
$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
$userService = new \frontend\modules\user\models\UserService();
$checkPhotoForm = new CheckPhotoForm();
$userTime = new \frontend\modules\user\models\UserTime();

$this->title = 'Добавить анкету';

$this->params['breadcrumbs'][] = $this->title;

if (isset($add_more)){

    $userMetro =  new \frontend\models\UserMetro();

    $userMetro->metro_id = \yii\helpers\ArrayHelper::getColumn(\frontend\models\UserMetro::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'metro_id');


    $userPlace = new \frontend\modules\user\models\UserPlace();

    $userPlace->place_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserPlace::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'place_id');

    $userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();

    $userOsobenosti->param_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserOsobenosti::find()
        ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

    $userService = UserService::find()->where(['post_id' => $post['id']])->asArray()->all();

    $userTime = new \frontend\modules\user\models\UserTime();

    $userTime->param_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserTime::find()
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