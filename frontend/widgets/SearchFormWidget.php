<?php

namespace frontend\widgets;

use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public function run()
    {

        $placeholder = 'Поиск по имени | номеру';

        if (MetroWidget::checkExistMetro()) $placeholder .= ' | метро';

        return $this->render('search-form', compact('placeholder'));
    }
}