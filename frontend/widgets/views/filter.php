<?php

/* @var $metro array */
/* @var $rayon array */
/* @var $service array */
/* @var $place array */
/* @var $naci array */
/* @var $intimHair array */
/* @var $hair array */
/* @var $dataGet array */

?>

<div class="container">

    <div onclick="openFilter()" class="toggle-filter">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 4h18"></path>
            <path d="M6 10h12"></path>
            <path d="M10 16h4"></path>
        </svg>
        Показать фильтр
    </div>
    <form action="/find" class="filter-wrap d-flex" id="filter">

        <div class="close-panel" onclick="openFilter()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>

        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">

        <?php if ($metro) : ?>

            <div class="filter-item custom-select position-relative">
                <select name="metro" id="">
                    <option value="">Метро</option>

                    <?php foreach ($metro as $item) : ?>

                        <option
                                value="<?php echo $item['id'] ?>"
                            <?php if (isset($dataGet['metro']) and $dataGet['metro'] and $dataGet['metro'] == $item['id']) echo 'selected' ?>
                        ><?php echo $item['value'] ?></option>

                    <?php endforeach; ?>
                </select>
            </div>

        <?php endif; ?>

        <div class="filter-item custom-select position-relative">
            <select name="national_id" id="">
                <option value="">Национальность</option>
                <?php foreach ($national as $item) : ?>
                    <option
                        <?php if (isset($dataGet['national_id']) and $dataGet['national_id'] and $dataGet['national_id'] == $item['id']) echo 'selected' ?>
                            value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <div class="bold-text">Возраст</div>
            <div class="filter-item-slide" id="age"></div>
            <div class="inputs">
                <input type="text" data-value="<?php echo $dataGet['age-from'] ?? 18 ?>" readonly id="age-from" name="age-from">
                <input type="text" data-value="<?php echo $dataGet['age-to'] ?? 80 ?>" readonly class="right-input" id="age-to"
                       name="age-to">
            </div>
        </div>

        <div class="filter-item">
            <div class="bold-text">Вес</div>
            <div class="filter-item-slide" id="ves"></div>
            <div class="inputs">
                <input type="text" data-value="<?php echo $dataGet['ves-from'] ?? 35 ?>" readonly id="ves-from" name="ves-from">
                <input type="text" data-value="<?php echo $dataGet['ves-to'] ?? 130 ?>" readonly class="right-input" id="ves-to"
                       name="ves-to">
            </div>
        </div>

        <div class="filter-item">
            <div class="bold-text">Грудь</div>
            <div class="filter-item-slide" id="grud"></div>
            <div class="inputs">
                <input type="text" data-value="<?php echo $dataGet['grud-from'] ?? 0 ?>" readonly id="grud-from"
                       name="grud-from">
                <input type="text" data-value="<?php echo $dataGet['grud-to'] ?? 9 ?>" readonly class="right-input" id="grud-to"
                       name="grud-to">
            </div>
        </div>

        <div class="filter-item">
            <div class="bold-text">Цена</div>
            <div class="filter-item-slide" id="price"></div>
            <div class="inputs">
                <input type="text" data-value="<?php echo $dataGet['price-1-from'] ?? 500 ?>" readonly id="price-1-from"
                       name="price-1-from">
                <input type="text" data-value="<?php echo $dataGet['price-1-to'] ?? 50000 ?>" readonly class="right-input"
                       id="price-1-to" name="price-1-to">
            </div>
        </div>

        <button type="submit" class="blue-btn">Поиск</button>

    </form>
</div>