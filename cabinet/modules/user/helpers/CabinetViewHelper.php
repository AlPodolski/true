<?php

namespace cabinet\modules\user\helpers;

class CabinetViewHelper
{

    private $table = 'table';
    private $default = '';

    public function get()
    {
        $cookies = $_COOKIE;

        if (isset($cookies['view'])) $view = $cookies['view'];
        else $view = 'default';

        switch ($view) {

            case 'default':
                return $this->default;

            case 'table':
                return $this->table;

        }

        return $this->default;

    }
}