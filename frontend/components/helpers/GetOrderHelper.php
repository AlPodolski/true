<?php

namespace frontend\components\helpers;

class GetOrderHelper
{
    private $default = 'tarif_id DESC, sort DESC';
    private $priceDesc = 'price DESC';
    private $priceAsc = 'price ASC';

    public function get(): string
    {

        $cookies = $_COOKIE;
        if (isset($cookies['sort'])) $sort = $cookies['sort'];
        else $sort = 'default';

        switch ($sort) {

            case 'default':
                return $this->default;

            case 'price_asc':
                return $this->priceAsc;

            case 'price_desc':
                return $this->priceDesc;

        }

        return $this->default;

    }
}