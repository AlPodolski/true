<?php

namespace frontend\components\helpers;

class GetOrderHelper
{
    private $default = 'tarif_id DESC, sort DESC';

    private $priceDesc = 'price DESC';
    private $priceAsc = 'price ASC';

    private $ageAsc = 'age ASC';
    private $ageDesc = 'age DESC';

    private $vesDesc = 'ves DESC';
    private $vesAsc = 'ves ASC';

    private $breastDesc = 'breast DESC';
    private $breastAsc = 'breast ASC';

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

            case 'age_asc':
                return $this->ageAsc;

            case 'age_desc':
                return $this->ageDesc;

            case 'ves_asc':
                return $this->vesAsc;

            case 'ves_desc':
                return $this->vesDesc;

            case 'brest_asc':
                return $this->breastAsc;

            case 'brest_desc':
                return $this->breastDesc;

        }

        return $this->default;

    }
}