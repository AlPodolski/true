<?php

/* @var $this \yii\web\View */
/* @var $post \cabinet\modules\user\models\Posts */

/* @var $city array */

use cabinet\modules\user\models\forms\CheckPhotoForm;
use cabinet\modules\user\models\forms\SelphiForm;
use cabinet\modules\user\models\UserService;

$videoForm = new \cabinet\modules\user\models\forms\VideoForm();

$videoForm->video = $post['video'];

$avatarForm = new \cabinet\modules\user\models\forms\AvatarForm();

$avatarForm->avatar = $post['avatar']['file'];

$checkPhotoForm = new CheckPhotoForm();

$checkPhotoForm->file = $post['checkPhoto']['file'];

$photoForm = new \cabinet\modules\user\models\forms\PhotoForm();

$photoForm->photo = $post['gal'];

$selphiForm = new SelphiForm();

$selphiForm->photo = $post['selphiCount'];

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

$this->title = 'Редактировать анкету';

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
    'userOsobenosti' => $userOsobenosti,
    'userService' => $userService,
    'checkPhotoForm' => $checkPhotoForm,
    'userTime' => $userTime,
    'selphiForm' => $selphiForm,
    'cityList' => $cityList,
]);

