<?php

namespace frontend\widgets;

use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public function run()
    {

        $placeholder = 'Поиск : имя | номер';

        if (MetroWidget::checkExistMetro()) $placeholder .= ' | метро';
        if (MetroWidget::checkExistRayon()) $placeholder .= ' | район';

        return $this->render('search-form', compact('placeholder'));
    }
}