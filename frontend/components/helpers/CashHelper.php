<?php


namespace frontend\components\helpers;

use common\models\User;

class CashHelper
{
    public static function enoughCash($sum, $balance)
    {
        if ($balance >= $sum) return true;

        return false;
    }

    public static function babloSpiz(User $user, $sum)
    {
        $user->cash = $user->cash - $sum;

        return $user->save();
    }
}