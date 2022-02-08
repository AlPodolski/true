<?php

namespace frontend\modules\user\controllers;

use frontend\controllers\BeforeController as Controller;

/**
 * Default controller for the `User` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
