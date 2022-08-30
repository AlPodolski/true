<?php


namespace frontend\modules\user\helpers;


use frontend\modules\user\models\UserService;

class SavePostRelationHelper
{
    public static function save($class, $params, $postId, $paramName , $cityId)
    {
        $class::deleteAll(['post_id' => $postId]);

        if (\is_array($params)) {

            foreach ($params as $param){

                $object = new $class;

                $object->$paramName = $param;
                $object->post_id = $postId;
                $object->city_id = $cityId;

                $object->save();

            }

        }else{

            $object = new $class;

            $object->$paramName = $params;
            $object->post_id = $postId;
            $object->city_id = $cityId;

            $object->save();

        }

    }

    public static function saveService($postId, $params, $cityId)
    {
        UserService::deleteAll(['post_id' => $postId]);

        foreach ($params['service_id'] as $param){

            $object = new UserService();

            $object->service_id = $param;
            $object->post_id = $postId;
            $object->city_id = $cityId;

            if ($params['service_info'][$param]) $object->service_info = $params['service_info'][$param];

            $object->save();

        }
    }
}