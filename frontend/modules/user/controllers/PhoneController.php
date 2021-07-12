<?php


namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PhoneController extends Controller
{
    public function behaviors()
    {
        return [
            \common\behaviors\isAuth::class,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-info' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGetInfo()
    {
        if (!$phone = Yii::$app->request->post('phone')) return 'Нужно указать номер';

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (mb_strlen($phone) != 11) return 'Указан неверный номер, должно быть 11 сиволов';

        $data = \json_decode(Yii::$app->phone->send(['phone' => $phone, 'action' => 'get-review']));

        return $this->renderFile(Yii::getAlias('@frontend/modules/user/views/phone/review.php'), [
            'data' => $data
        ]);

    }

}