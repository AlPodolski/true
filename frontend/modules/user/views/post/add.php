<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\modules\user\models\Posts */
/* @var $city array */

$videoForm = new \frontend\modules\user\models\forms\VideoForm();
$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();
$photoForm = new \frontend\modules\user\models\forms\PhotoForm();
$userNational = new \frontend\modules\user\models\UserNational();
$userMetro = new \frontend\models\UserMetro();
$userPlace = new \frontend\modules\user\models\UserPlace();
$userHairColor = new \frontend\modules\user\models\UserHairColor();
$userIntimHair = new \frontend\modules\user\models\UserIntimHair();
$userRayon = new \frontend\modules\user\models\UserRayon();
$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();
$userService = new \frontend\modules\user\models\UserService();

$this->title = 'Добавить анкету';

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
    'userNational' => $userNational,
    'userMetro' => $userMetro,
    'userPlace' => $userPlace,
    'userHairColor' => $userHairColor,
    'userIntimHair' => $userIntimHair,
    'userRayon' => $userRayon,
    'userOsobenosti' => $userOsobenosti,
    'userService' => $userService,
]);