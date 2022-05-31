<?php

/* @var $sort string */

?>

<div class="sort-block d-flex">
    <div class="order-block">
        <select class="metro-select" name="limit" id="sort-select" onchange="setSort()">
            <option <?php if ($sort == 'default') echo 'selected'?> value="default">Сортировать</option>
            <option <?php if ($sort == 'price_asc') echo 'selected'?> value="price_asc">От дешевых к дорогим</option>
            <option <?php if ($sort == 'price_desc') echo 'selected'?> value="price_desc">От дорогих к дешевым</option>
        </select>
    </div>
</div>
