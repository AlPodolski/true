<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */
/* @var $cityList \common\models\City[] */

use yii\base\BaseObject;
use frontend\modules\user\models\forms\CheckPhotoForm;

$videoForm = new \frontend\modules\user\models\forms\VideoForm();
$selphiForm = new \frontend\modules\user\models\forms\SelphiForm();
$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();
$photoForm = new \frontend\modules\user\models\forms\PhotoForm();
$userNational = new \frontend\modules\user\models\UserNational();
$userMetro = new \frontend\models\UserMetro();
$userPlace = new \frontend\modules\user\models\UserPlace();
$userIntimHair = new \frontend\modules\user\models\UserIntimHair();
$userRayon = new \frontend\modules\user\models\UserRayon();
$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
$userService = new \frontend\modules\user\models\UserService();
$checkPhotoForm = new CheckPhotoForm();
$userTime = new \frontend\modules\user\models\UserTime();

$this->title = 'Добавить анкету';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

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
    'userIntimHair' => $userIntimHair,
    'userRayon' => $userRayon,
    'userOsobenosti' => $userOsobenosti,
    'userService' => $userService,
    'checkPhotoForm' => $checkPhotoForm,
    'userTime' => $userTime,
    'selphiForm' => $selphiForm,
    'cityList' => $cityList,
]);