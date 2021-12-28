<?php


namespace frontend\components\helpers;


class CanonicalHelper
{
    public static function getLink($request)
    {

        if (\strpos($request, 'page=') !== false) {

            $link = \strstr($request, 'page', true);

            if ($link == '/') return $link;

            else return \mb_substr($link, 0, -1);

        }

        if (\strstr($request, '?')) return \strstr($request, '?', true);

        return false;

    }
}