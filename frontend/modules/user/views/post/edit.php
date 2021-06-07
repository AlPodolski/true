<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\modules\user\models\Posts */

/* @var $city array */

use frontend\modules\user\models\forms\CheckPhotoForm;

$videoForm = new \frontend\modules\user\models\forms\VideoForm();

$videoForm->video = $post['video'];

$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();

$avatarForm->avatar = $post['avatar']['file'];

$checkPhotoForm = new CheckPhotoForm();

$checkPhotoForm->file = $post['checkPhoto']['file'];

$photoForm = new \frontend\modules\user\models\forms\PhotoForm();

$photoForm->photo = $post['gal'];

$userNational = \frontend\modules\user\models\UserNational::findOne(['post_id' => $post['id']]) ?? new \frontend\modules\user\models\UserNational() ;

$userMetro =  new \frontend\models\UserMetro();

$userMetro->metro_id = \yii\helpers\ArrayHelper::getColumn(\frontend\models\UserMetro::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'metro_id');


$userPlace = new \frontend\modules\user\models\UserPlace();

$userPlace->place_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserPlace::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'place_id');


$userHairColor = \frontend\modules\user\models\UserHairColor::findOne(['post_id' => $post['id']]) ?? new \frontend\modules\user\models\UserHairColor();

$userIntimHair = \frontend\modules\user\models\UserIntimHair::findOne(['post_id' => $post['id']]) ?? new \frontend\modules\user\models\UserIntimHair;


$userRayon = new \frontend\modules\user\models\UserRayon();

$userRayon->rayon_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserRayon::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'rayon_id');


$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();

$userOsobenosti->param_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserOsobenosti::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

$userService = new \frontend\modules\user\models\UserService();

$userService->service_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserService::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'service_id');

$this->title = 'Редактировать анкету';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title.' '.$post['name'];

?>
<div class="container">
    <div class="row">
        <div class="col-12 margin-top-20">
            <?php echo \yii\helpers\Html::tag('h1', 'Редактирование анкеты : '.$post['name']); ?>
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
    'checkPhotoForm' => $checkPhotoForm,
]);

