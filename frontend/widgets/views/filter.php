<?php

/* @var $metro array */
/* @var $rayon array */
/* @var $service array */
/* @var $place array */
/* @var $naci array */
/* @var $intimHair array */
/* @var $hair array */

?>

<form action="/find">

    <div class="search-by-params-btn" onclick="close_filter(this)">
        Поиск по параметрам
        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M0.178459 0.70499L0.81969 0.010324L4.15384 3.62232L7.488 0.010324L8.12923 0.70499L4.79507 4.31699L4.15384 5.01166L0.178459 0.70499Z" fill="#F74952"/>
            </g>
            <defs>
                <clipPath id="clip0">
                    <rect width="5" height="8" fill="white" transform="translate(0 5) rotate(-90)"/>
                </clipPath>
            </defs>
        </svg>
    </div>

    <?php if ($metro) : ?>

        <div class="metro-select-wrap position-relative">

            <select name="metro" id="" class="metro-select w-100">

                <option value="">Выберите станцию метро</option>

                <?php foreach ($metro as $metroItem) : ?>

                    <option value="<?php echo $metroItem['id'] ?>"><?php echo $metroItem['value'] ?></option>

                <?php endforeach; ?>

            </select>
            <div class="find-icon-block position-absolute"></div>
        </div>

    <?php endif; ?>

    <div class="find-near-with-me d-none">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.00001 4.95833C5.87447 4.95833 4.95834 5.87416 4.95834 6.99999C4.95834 8.12583 5.87447 9.04166 7.00001 9.04166C8.12555 9.04166 9.04168 8.12583 9.04168 6.99999C9.04168 5.87416 8.12555 4.95833 7.00001 4.95833ZM7.00001 7.875C6.51759 7.875 6.12501 7.48241 6.12501 6.99999C6.12501 6.51758 6.51759 6.12499 7.00001 6.12499C7.48243 6.12499 7.87501 6.51758 7.87501 6.99999C7.87501 7.48241 7.48243 7.875 7.00001 7.875Z" fill="#F74952"/>
            <path d="M13.4167 6.41667H12.2156C11.9455 3.98737 10.0126 2.0545 7.58333 1.78442V0.583333C7.58333 0.261333 7.322 0 7 0C6.678 0 6.41667 0.261333 6.41667 0.583333V1.78442C3.98737 2.0545 2.0545 3.98737 1.78442 6.41667H0.583333C0.261333 6.41667 0 6.678 0 7C0 7.322 0.261333 7.58333 0.583333 7.58333H1.78442C2.0545 10.0126 3.98737 11.9455 6.41667 12.2156V13.4167C6.41667 13.7387 6.678 14 7 14C7.322 14 7.58333 13.7387 7.58333 13.4167V12.2156C10.0126 11.9455 11.9455 10.0126 12.2156 7.58333H13.4167C13.7387 7.58333 14 7.322 14 7C14 6.678 13.7387 6.41667 13.4167 6.41667ZM7 11.0833C4.74833 11.0833 2.91667 9.25167 2.91667 7C2.91667 4.74833 4.74833 2.91667 7 2.91667C9.25167 2.91667 11.0833 4.74833 11.0833 7C11.0833 9.25167 9.25167 11.0833 7 11.0833Z" fill="#F74952"/>
        </svg>
        Искать рядом со мной</div>

    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Возраст</div>
        <div class="slider-item d-flex">
            <input type="text" id="age-from" name="age-from" readonly value="18">
            <div id="slider-range-age"></div>
            <input type="text" id="age-to" name="age-to" readonly value="65">
        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Рост</div>
        <div class="slider-item d-flex">
            <input type="text" id="rost-from" name="rost-from" readonly value="150">
            <div id="rost-range-age"></div>
            <input type="text" id="rost-to" name="rost-to" readonly value="200">
        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Вес</div>
        <div class="slider-item d-flex">
            <input type="text" id="ves-from" name="ves-from" readonly value="35">
            <div id="slider-range-ves"></div>
            <input type="text" id="ves-to"  name="ves-to" readonly value="130">
        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Грудь</div>
        <div class="slider-item d-flex">
            <input type="text" id="grud-from" name="grud-from" readonly value="0">
            <div id="slider-range-grud"></div>
            <input type="text" id="grud-to" name="grud-to" readonly value="9">
        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Цена <br> (1 час)</div>
        <div class="slider-item d-flex">
            <input type="text" id="price-1-from" name="price-1-from" readonly value="500">
            <div id="slider-range-price-1-hour"></div>
            <input type="text" id="price-1-to" name="price-1-to" readonly value="25000">
        </div>
    </div>
    <div class="slider-item-wrap d-flex">
        <div class="slider-item-text">Цена <br> (2 часа)</div>
        <div class="slider-item d-flex">
            <input type="text" id="price-2-from" name="price-2-from" readonly value="500">
            <div id="slider-range-price-2-hour"></div>
            <input type="text" id="price-2-to" name="price-2-to" readonly value="25000">
        </div>
    </div>

    <div class="dopolnitaelno-btn" onclick="dopolnitaelno(this)">
        <span class="d-none">Скрыть</span>
        <span>Дополнительно</span>
        <svg class="arrow-up " width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 1.99998L4.00002 6L8 1.99998H0Z" fill="black"/>
        </svg>
    </div>

    <div class="dop-block d-none">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="checbox black-check-box">
                    <input type="checkbox" name="check-photo" id="check-photo" class="custom-checkbox">
                    <label for="check-photo"><span>Фото проверено</span></label>
                </div>
                <div class="checbox black-check-box">
                    <input type="checkbox" name="video" id="video" class="custom-checkbox">
                    <label for="video"><span>Анкета с видео</span></label>
                </div>
                <div class="checbox black-check-box d-none">
                    <input type="checkbox" name="bez-retushi" id="bez-retushi" class="custom-checkbox">
                    <label for="bez-retushi"><span>Фото без ретуши</span></label>
                </div>
            </div>
            <div class="col-12 col-sm-6 right-property-column">
                <div class="checbox black-check-box">
                    <input type="checkbox" name="new" id="new" class="custom-checkbox">
                    <label for="new"><span>Новые на сайте</span></label>
                </div>
                <div class="checbox black-check-box d-none">
                    <input type="checkbox" name="popular" id="popular" class="custom-checkbox">
                    <label for="popular"><span>Популярные</span></label>
                </div>
            </div>
        </div>

        <div class="more-search-btn" onclick="more_search(this)">
            <span class="d-none">Скрыть</span>
            <span>Расширенный поиск</span>
            <svg class="arrow-up " width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1.99998L4.00002 6L8 1.99998H0Z" fill="black"/>
            </svg>
        </div>
    </div>

    <div class="more-search-block d-none">
        <div class="row">
            <div class="col-6">
                <?php if ($service) : ?>
                    <select name="service" class="red-select">
                        <option value="">Услуги</option>

                        <?php foreach ($service as $serviceItem) : ?>

                            <option value="<?php echo $serviceItem['id'] ?>"><?php echo $serviceItem['value'] ?></option>

                        <?php endforeach; ?>

                    </select>
                <?php endif; ?>
                <select name="place" class="red-select">
                    <option value="">Место встречи</option>

                    <?php foreach ($place as $item) : ?>

                        <option value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                    <?php endforeach; ?>

                </select>
                <select name="naci" class="red-select">
                    <option value="">Национальность</option>

                    <?php foreach ($naci as $item) : ?>

                        <option value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                    <?php endforeach; ?>

                </select>
                <select name="hair" class="red-select">
                    <option value="">Цвет волос</option>

                    <?php foreach ($hair as $item) : ?>

                        <option value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div class="col-6 right-property-column">
                <select name="service" class="red-select">
                    <option value="">Интим стрижка</option>

                    <?php foreach ($intimHair as $item) : ?>

                        <option value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                    <?php endforeach; ?>

                </select>
                <?php if ($rayon) : ?>
                    <select name="rayon" class="red-select">
                        <option value="">Район</option>

                        <?php foreach ($rayon as $item) : ?>

                            <option value="<?php echo $item['id'] ?>"><?php echo $item['value'] ?></option>

                        <?php endforeach; ?>

                    </select>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <button class="show-anket-count">Показать</button>

</form>