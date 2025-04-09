<?php


namespace cabinet\components\helpers;

use common\models\User;
use yii\web\IdentityInterface;

class CashHelper
{
    public static function enoughCash($sum, $balance)
    {
        if ($balance >= $sum) return true;

        return false;
    }

    public static function babloSpiz(IdentityInterface $user, $sum)
    {
        $user->cash = $user->cash - $sum;

        return $user->save();
    }
}