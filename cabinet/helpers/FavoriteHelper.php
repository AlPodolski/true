<?php


namespace cabinet\helpers;

use Yii;

class FavoriteHelper
{

    public static function getFavorite()
    {
        $cookiesRequest = Yii::$app->request->cookies;

        return \unserialize($cookiesRequest->getValue('favorite'));

    }

    public static function Favorite($id)
    {

        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue('favorite');

        $cookies = Yii::$app->response->cookies;

        if (!$favorite){

            $item = \serialize(array($id));

            $cookies->add(new \yii\web\Cookie([
                'name' => 'favorite',
                'value' => $item,
                'expire' => \time() + (3600 * 24 * 365),
            ]));

        }else {

            $items = \unserialize($favorite);

            if (\in_array($id, $items)){

                foreach ($items as $key => $item){

                    if ($item == $id) unset($items[$key]);

                }

            }else {

                $items[] = $id;

            }

            $items = \serialize($items);

            $cookies->add(new \yii\web\Cookie([
                'name' => 'favorite',
                'value' => $items,
                'expire' => \time() + (3600 * 24 * 365),
            ]));

        }

    }

    /**
     * @param $id
     * @return bool
     */
    public static function isFavorite($id)
    {

        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue('favorite');

        $items = \unserialize($favorite);


        if (\is_array($items) and \in_array($id, $items)){

            return true;

        }

        return false;

    }

}