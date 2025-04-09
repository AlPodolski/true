<?php

/* @var $placeholder string */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$searchName = new \cabinet\models\SearchNameForm();

?>

<div class="header__col header__col--search" itemscope itemtype="https://schema.org/WebSite">

    <meta itemprop="url" content="https://<?php echo $_SERVER['HTTP_HOST'] ?>">

    <form class="header__search header-search" action="/search/name"
          method="get" itemprop="potentialAction"
          itemscope="" itemtype="https://schema.org/SearchAction">

        <meta itemprop="target"
              content="https://<?php echo $_SERVER['HTTP_HOST'] ?>/search/name?name={name}">

        <input class="header-search__input"
               type="search"
               placeholder="Поиск : имя | метро | район"
               name="name"
               itemprop="query-input">

        <button type="submit" class="header-search__btn">
            <img src="/images/icons/search.svg" alt="">
        </button>

    </form>

</div>