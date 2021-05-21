<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="site-error margin-top-20">

                <h1><?= Html::encode($this->title) ?></h1>

                <p>Перейдите на <a href="/">главную</a> страницу</p>

            </div>
        </div>
    </div>
</div>
