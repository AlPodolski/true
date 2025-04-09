<?php


namespace cabinet\helpers;


class CommentsHelper
{
    public static function getCommentOwner(int $id, string $class)
    {
        if ($class and class_exists($class)){

            return $class::find()->where(['id' => $id])->select('user_id')->asArray()->one();

        }

        return false;
    }
}