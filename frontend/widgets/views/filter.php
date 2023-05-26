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

<div class="search-by-params-btn" onclick="toggle_filter(this)">
    Показать фильтр
    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(.clip0)">
            <path d="M0.178459 0.70499L0.81969 0.010324L4.15384 3.62232L7.488 0.010324L8.12923 0.70499L4.79507 4.31699L4.15384 5.01166L0.178459 0.70499Z"
                  fill="#0F2C93"/>
        </g>
        <defs>
            <clipPath class="clip0">
                <rect width="5" height="8" fill="white" transform="translate(0 5) rotate(-180)"/>
            </clipPath>
        </defs>
    </svg>
</div>

<form action="/find" id="searchForm">

    <div class="close-filter-btn" onclick="toggle_filter(this)">
        <svg width="13" height="13" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 0.353513L5.64649 0L3 2.64649L0.353513 0L0 0.353513L2.64649 3L0 5.64649L0.353513 6L3 3.35351L5.64649 6L6 5.64649L3.35351 3L6 0.353513Z"
                  fill="black"/>
        </svg>
    </div>

    <?php if ($metro) : ?>

        <div class="metro-select-wrap position-relative">

            <select name="metro" class="metro-select">

                <option value="">Выберите метро</option>

                <?php foreach ($metro as $metroItem) : ?>

                    <?php $selected = '' ?>

                    <?php if ($dataGet
                        and isset($dataGet['metro'])
                        and $dataGet['metro']
                        and $dataGet['metro'] == $metroItem['id']) $selected = 'selected' ?>

                    <option <?php echo $selected ?>
                            value="<?php echo $metroItem['id'] ?>"><?php echo $metroItem['value'] ?></option>

                <?php endforeach; ?>

            </select>
        </div>

    <?php endif; ?>

    <div class="find-near-with-me d-none">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.00001 4.95833C5.87447 4.95833 4.95834 5.87416 4.95834 6.99999C4.95834 8.12583 5.87447 9.04166 7.00001 9.04166C8.12555 9.04166 9.04168 8.12583 9.04168 6.99999C9.04168 5.87416 8.12555 4.95833 7.00001 4.95833ZM7.00001 7.875C6.51759 7.875 6.12501 7.48241 6.12501 6.99999C6.12501 6.51758 6.51759 6.12499 7.00001 6.12499C7.48243 6.12499 7.87501 6.51758 7.87501 6.99999C7.87501 7.48241 7.48243 7.875 7.00001 7.875Z"
                  fill="#0F2C93"/>
            <path d="M13.4167 6.41667H12.2156C11.9455 3.98737 10.0126 2.0545 7.58333 1.78442V0.583333C7.58333 0.261333 7.322 0 7 0C6.678 0 6.41667 0.261333 6.41667 0.583333V1.78442C3.98737 2.0545 2.0545 3.98737 1.78442 6.41667H0.583333C0.261333 6.41667 0 6.678 0 7C0 7.322 0.261333 7.58333 0.583333 7.58333H1.78442C2.0545 10.0126 3.98737 11.9455 6.41667 12.2156V13.4167C6.41667 13.7387 6.678 14 7 14C7.322 14 7.58333 13.7387 7.58333 13.4167V12.2156C10.0126 11.9455 11.9455 10.0126 12.2156 7.58333H13.4167C13.7387 7.58333 14 7.322 14 7C14 6.678 13.7387 6.41667 13.4167 6.41667ZM7 11.0833C4.74833 11.0833 2.91667 9.25167 2.91667 7C2.91667 4.74833 4.74833 2.91667 7 2.91667C9.25167 2.91667 11.0833 4.74833 11.0833 7C11.0833 9.25167 9.25167 11.0833 7 11.0833Z"
                  fill="#0F2C93"/>
        </svg>
        Искать рядом со мной
    </div>

    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Возраст</div>
        <div class="slider-item d-flex">
            <?php

            if ($dataGet and isset($dataGet['age-from'])) $ageFrom = $dataGet['age-from'];
            else $ageFrom = 18;

            ?>

            <?php

            if ($dataGet and isset($dataGet['age-to'])) $ageTo = $dataGet['age-to'];
            else $ageTo = 65;

            ?>
            <div id="slider-range-age"></div>

            <div class="d-flex filter-input-wrap">
                <input type="text" id="age-from" class="text-left" name="age-from" readonly
                       value="<?php echo $ageFrom ?>">

                <input type="text" id="age-to" name="age-to" class="text-right" readonly value="<?php echo $ageTo ?>">
            </div>

        </div>
    </div>

    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Рост</div>
        <div class="slider-item d-flex">
            <?php

            if ($dataGet and isset($dataGet['rost-from'])) $rostFrom = $dataGet['rost-from'];
            else $rostFrom = 150;

            ?>

            <?php

            if ($dataGet and isset($dataGet['rost-to'])) $rostTo = $dataGet['rost-to'];
            else $rostTo = 200;

            ?>

            <div id="rost-range-age"></div>

            <div class="d-flex filter-input-wrap">
                <input type="text" id="rost-from" class="text-left" name="rost-from" readonly
                       value="<?php echo $rostFrom ?>">

                <input type="text" id="rost-to" class="text-right" name="rost-to" readonly
                       value="<?php echo $rostTo ?>">
            </div>

        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Вес</div>
        <div class="slider-item d-flex">
            <?php

            if ($dataGet and isset($dataGet['ves-from'])) $vesFrom = $dataGet['ves-from'];
            else $vesFrom = 35;

            ?>

            <?php

            if ($dataGet and isset($dataGet['ves-to'])) $vestTo = $dataGet['ves-to'];
            else $vestTo = 130;

            ?>

            <div id="slider-range-ves"></div>

            <div class="d-flex filter-input-wrap">
                <input type="text" id="ves-from" class="text-left" name="ves-from" readonly
                       value="<?php echo $vesFrom ?>">

                <input type="text" id="ves-to" class="text-right" name="ves-to" readonly value="<?php echo $vestTo ?>">
            </div>

        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Грудь</div>
        <div class="slider-item d-flex">
            <?php

            if ($dataGet and isset($dataGet['grud-from'])) $grudFrom = $dataGet['grud-from'];
            else $grudFrom = 0;

            ?>

            <?php

            if ($dataGet and isset($dataGet['grud-to'])) $grudTo = $dataGet['grud-to'];
            else $grudTo = 9;

            ?>

            <div id="slider-range-grud"></div>

            <div class="d-flex filter-input-wrap">
                <input type="text" id="grud-from" class="text-left" name="grud-from" readonly
                       value="<?php echo $grudFrom ?>">

                <input type="text" id="grud-to" class="text-right" name="grud-to" readonly
                       value="<?php echo $grudTo ?>">
            </div>


        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Цена (1 час)</div>
        <div class="slider-item d-flex">
            <?php

            if ($dataGet and isset($dataGet['price-1-from'])) $priceFrom = $dataGet['price-1-from'];
            else $priceFrom = 500;

            ?>

            <?php

            if ($dataGet and isset($dataGet['price-1-to'])) $priceTo = $dataGet['price-1-to'];
            else $priceTo = 25000;

            ?>

            <div id="slider-range-price-1-hour"></div>

            <div class="d-flex filter-input-wrap">
                <input type="text" id="price-1-from" class="text-left" name="price-1-from" readonly
                       value="<?php echo $priceFrom ?>">

                <input type="text" id="price-1-to" class="text-right" name="price-1-to" readonly
                       value="<?php echo $priceTo ?>">
            </div>


        </div>
    </div>

    <div class="more-search-block d-none">

        <div class="inputs-wrap">
            <div class="checbox black-check-box">
                <input type="checkbox" name="check-photo"
                       <?php if ($dataGet['check-photo']) echo 'checked' ?>

                       id="check-photo" class="custom-checkbox">
                <label for="check-photo"><span>Фото проверено</span></label>
            </div>
            <div class="checbox black-check-box">
                <input type="checkbox"
                    <?php if ($dataGet['video']) echo 'checked' ?>
                       name="video" id="video" class="custom-checkbox">
                <label for="video"><span>Анкета с видео</span></label>
            </div>
            <div class="checbox black-check-box d-none">
                <input type="checkbox"
                    <?php if ($dataGet['bez-retushi']) echo 'checked' ?>
                       name="bez-retushi" id="bez-retushi" class="custom-checkbox">
                <label for="bez-retushi"><span>Фото без ретуши</span></label>
            </div>
            <div class="checbox black-check-box">
                <input type="checkbox"
                    <?php if ($dataGet['new']) echo 'checked' ?>
                       name="new" id="new" class="custom-checkbox">
                <label for="new"><span>Новые на сайте</span></label>
            </div>
        </div>
        <?php if ($service) : ?>
            <select name="service" class="red-select">
                <option value="">Услуги</option>

                <?php foreach ($service as $serviceItem) : ?>

                    <option

                        <?php $selected = '' ?>

                        <?php if ($dataGet
                            and isset($dataGet['service'])
                            and $dataGet['service']
                            and $dataGet['service'] == $serviceItem['id']) $selected = 'selected'; ?>

                            <?php echo $selected ?>

                            value="<?php echo $serviceItem['id'] ?>"><?php echo $serviceItem['value'] ?></option>

                <?php endforeach; ?>

            </select>
        <?php endif; ?>
        <select name="place" class="red-select">
            <option value="">Место встречи</option>

            <?php foreach ($place as $item) : ?>

                <option

                    <?php $selected = '' ?>

                    <?php if ($dataGet
                        and isset($dataGet['place'])
                        and $dataGet['place']
                        and $dataGet['place'] == $item['id']) $selected = 'selected'; ?>

                    <?php echo $selected ?>

                        value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

            <?php endforeach; ?>

        </select>
        <select name="naci" class="red-select">
            <option value="">Национальность</option>

            <?php foreach ($naci as $item) : ?>

                <option

                    <?php $selected = '' ?>

                    <?php if ($dataGet
                        and isset($dataGet['naci'])
                        and $dataGet['naci']
                        and $dataGet['naci'] == $item['id']) $selected = 'selected'; ?>

                    <?php echo $selected ?>

                        value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

            <?php endforeach; ?>

        </select>
        <select name="hair" class="red-select">
            <option value="">Цвет волос</option>

            <?php foreach ($hair as $item) : ?>

                <option

                    <?php $selected = '' ?>

                    <?php if ($dataGet
                        and isset($dataGet['hair'])
                        and $dataGet['hair']
                        and $dataGet['hair'] == $item['id']) $selected = 'selected'; ?>

                    <?php echo $selected ?>

                        value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

            <?php endforeach; ?>

        </select>
        <select name="intimHair" class="red-select">
            <option value="">Интим стрижка</option>

            <?php foreach ($intimHair as $item) : ?>

                <option

                    <?php $selected = '' ?>

                    <?php if ($dataGet
                        and isset($dataGet['intimHair'])
                        and $dataGet['intimHair']
                        and $dataGet['intimHair'] == $item['id']) $selected = 'selected'; ?>

                    <?php echo $selected ?>

                        value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

            <?php endforeach; ?>

        </select>
        <?php if ($rayon) : ?>
            <select name="rayon" class="red-select">
                <option value="">Район</option>

                <?php foreach ($rayon as $item) : ?>

                    <option

                        <?php $selected = '' ?>

                        <?php if ($dataGet
                            and isset($dataGet['rayon'])
                            and $dataGet['rayon']
                            and $dataGet['rayon'] == $item['id']) $selected = 'selected'; ?>

                        <?php echo $selected ?>

                            value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                <?php endforeach; ?>

            </select>
        <?php endif; ?>

    </div>

    <div class="more-search-btn" onclick="more_search(this)">
        <span class="d-none">Скрыть</span>
        <span>Расширенный поиск</span>
        <svg class="arrow-up " width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 1.99998L4.00002 6L8 1.99998H0Z" fill="black"/>
        </svg>
    </div>

    <button class="show-anket-count">Показать</button>

</form>

<div class="more-search-btn" onclick="more_search(this)">
    <span class="d-none">Скрыть</span>
    <span>Расширенный поиск</span>
    <svg class="arrow-up " width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 1.99998L4.00002 6L8 1.99998H0Z" fill="black"/>
    </svg>
</div>