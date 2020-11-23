<?php


namespace frontend\helpers;


class PostPriceHelper
{
    public static function getMinAndMaxPrice($price)
    {
        $min = 999999;

        $max = 0;

        foreach ($price as $item){

            if ($item['price'] < $min) $min = $item['price'];
            if ($item['price'] > $max) $max = $item['price'];

        }

        return array('min' => $min, 'max' => $max);

    }
}