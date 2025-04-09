<?php

namespace cabinet\components\helpers;

class PriceTargetHelper
{
    public static function target($price)
    {
        if ($price < 3000) return "ym(70919698,'reachGoal','phonedo3k')";
        elseif($price >= 3000 and $price < 5000) return "ym(70919698,'reachGoal','phonedo5k')";
        elseif ($price >= 5000) return "ym(70919698,'reachGoal','phoneot5k')";
    }
}