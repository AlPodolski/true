<?php

use cabinet\modules\user\helpers\ViewCountHelper;

/* @var $posts \cabinet\modules\user\models\Posts */
/* @var $topPostList \cabinet\modules\user\models\Posts */
/* @var $page string */

if ($posts and $page > 1) echo '<div data-url="/?page=' . $page . '" class="col-12"></div>';

if ($topPostList) {
    foreach ($topPostList as $post) {
        echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
            'post' => $post,
            'advertising' => true,
        ]);
    }
}

foreach ($posts as $post) {

    echo $this->renderFile('@app/views/layouts/article.php', [
        'post' => $post,
    ]);

}