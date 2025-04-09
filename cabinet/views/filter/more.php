<?php

use cabinet\modules\user\helpers\ViewCountHelper;

/* @var $posts \cabinet\modules\user\models\Posts */
/* @var $topPostList \cabinet\modules\user\models\Posts */
/* @var $page string */

if ($page > 1) echo '<div data-url="/' . $param . '?page=' . $page . '" class="col-12"></div>';

foreach ($posts as $post) {

    echo $this->renderFile('@app/views/layouts/article.php', [
        'post' => $post,
    ]);

}