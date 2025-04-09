<?php

namespace cabinet\modules\advert\components\helpers;

use cabinet\components\helpers\CashHelper;
use cabinet\modules\advert\models\Advert;
use Yii;
use yii\web\IdentityInterface;

class AdvertHelper
{
    public static function add($request, IdentityInterface $user)
    {
        $model = new Advert();

        $model->timestamp = \time();

        $model->user_id = $user->id;

        $model->status = Advert::STATUS_NOT_CHECK;

        if (CashHelper::enoughCash(Yii::$app->params['advert_price'], $user->cash) and $model->load($request)){

            $transaction = Yii::$app->db->beginTransaction();

            if ($model->save() and CashHelper::babloSpiz($user, Yii::$app->params['advert_price'])){

                $transaction->commit();

                Yii::$app->session->setFlash('success', 'Объяление отправлено на модерацию, если оно не пройдет модерацию деньги будут возвращены на счет');

                return true;

            }else{

                $transaction->rollBack();

                return false;

            }

        }

        Yii::$app->session->setFlash('warning', 'Недостаточно средств');

        return false;

    }
}