<?php

/* @var $sort string */

?>

<form class="filter-sort__form">
    <select class="filter-sort__input"
            id="sort-select" onchange="setSort()"
            data-custom-select name="sort">
        <option <?php if ($sort == 'default') echo 'selected'?> value="default">Сортировать</option>

        <option <?php if ($sort == 'price_asc') echo 'selected'?> value="price_asc">От дешевых к дорогим</option>
        <option <?php if ($sort == 'price_desc') echo 'selected'?> value="price_desc">От дорогих к дешевым</option>

        <option <?php if ($sort == 'age_asc') echo 'selected'?> value="age_asc">От молодых к старым</option>
        <option <?php if ($sort == 'age_desc') echo 'selected'?> value="age_desc">От старых к молодым</option>

        <option <?php if ($sort == 'ves_asc') echo 'selected'?> value="ves_asc">От худых к толстым</option>
        <option <?php if ($sort == 'ves_desc') echo 'selected'?> value="ves_desc">От толстых к худым</option>

        <option <?php if ($sort == 'brest_asc') echo 'selected'?> value="brest_asc">От маленькой груди к большой</option>
        <option <?php if ($sort == 'brest_desc') echo 'selected'?> value="brest_desc">От большой груди к маленькой</option>
    </select>
</form>
