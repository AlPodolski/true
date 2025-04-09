<?php

namespace cabinet\modules\user\controllers;

use cabinet\controllers\BeforeController as Controller;

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
