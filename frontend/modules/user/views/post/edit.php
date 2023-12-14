<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\modules\user\models\Posts */

/* @var $city array */

use frontend\modules\user\models\forms\CheckPhotoForm;
use frontend\modules\user\models\forms\SelphiForm;
use frontend\modules\user\models\UserService;

$videoForm = new \frontend\modules\user\models\forms\VideoForm();

$videoForm->video = $post['video'];

$avatarForm = new \frontend\modules\user\models\forms\AvatarForm();

$avatarForm->avatar = $post['avatar']['file'];

$checkPhotoForm = new CheckPhotoForm();

$checkPhotoForm->file = $post['checkPhoto']['file'];

$photoForm = new \frontend\modules\user\models\forms\PhotoForm();

$photoForm->photo = $post['gal'];

$selphiForm = new SelphiForm();

$selphiForm->photo = $post['selphiCount'];

$userMetro =  new \frontend\models\UserMetro();

$userMetro->metro_id = \yii\helpers\ArrayHelper::getColumn(\frontend\models\UserMetro::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'metro_id');


$userPlace = new \frontend\modules\user\models\UserPlace();

$userPlace->place_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserPlace::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'place_id');

$userIntimHair = \frontend\modules\user\models\UserIntimHair::findOne(['post_id' => $post['id']]) ?? new \frontend\modules\user\models\UserIntimHair;


$userRayon = new \frontend\modules\user\models\UserRayon();

$userRayon->rayon_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserRayon::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'rayon_id');


$userOsobenosti = new \frontend\modules\user\models\UserOsobenosti();

$userOsobenosti->param_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserOsobenosti::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

$userService = UserService::find()->where(['post_id' => $post['id']])->asArray()->all();

$userTime = new \frontend\modules\user\models\UserTime();

$userTime->param_id = \yii\helpers\ArrayHelper::getColumn(\frontend\modules\user\models\UserTime::find()
    ->where(['post_id' => $post['id']])->asArray()->all(), 'param_id');

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

