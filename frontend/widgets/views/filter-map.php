<?php

/* @var $place array */
/* @var $naci array */
/* @var $intimHair array */
/* @var $hair array */

?>

<div id="map-filter-wrap">
    <div id="map-filter-btn" class="d-flex" onclick="toggle_map_filter()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 8" width="12">
            <path fill="#666" d="M10.6.3L6 4.9 1.4.3 0 1.7l6 6 6-6L10.6.3z"></path>
        </svg>
        <div class="span">Расширенный поиск</div>
    </div>
    <div id="map-filter">
        <form action="/find">

            <div class="find-near-with-me d-none">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.00001 4.95833C5.87447 4.95833 4.95834 5.87416 4.95834 6.99999C4.95834 8.12583 5.87447 9.04166 7.00001 9.04166C8.12555 9.04166 9.04168 8.12583 9.04168 6.99999C9.04168 5.87416 8.12555 4.95833 7.00001 4.95833ZM7.00001 7.875C6.51759 7.875 6.12501 7.48241 6.12501 6.99999C6.12501 6.51758 6.51759 6.12499 7.00001 6.12499C7.48243 6.12499 7.87501 6.51758 7.87501 6.99999C7.87501 7.48241 7.48243 7.875 7.00001 7.875Z" fill="#F74952"/>
                    <path d="M13.4167 6.41667H12.2156C11.9455 3.98737 10.0126 2.0545 7.58333 1.78442V0.583333C7.58333 0.261333 7.322 0 7 0C6.678 0 6.41667 0.261333 6.41667 0.583333V1.78442C3.98737 2.0545 2.0545 3.98737 1.78442 6.41667H0.583333C0.261333 6.41667 0 6.678 0 7C0 7.322 0.261333 7.58333 0.583333 7.58333H1.78442C2.0545 10.0126 3.98737 11.9455 6.41667 12.2156V13.4167C6.41667 13.7387 6.678 14 7 14C7.322 14 7.58333 13.7387 7.58333 13.4167V12.2156C10.0126 11.9455 11.9455 10.0126 12.2156 7.58333H13.4167C13.7387 7.58333 14 7.322 14 7C14 6.678 13.7387 6.41667 13.4167 6.41667ZM7 11.0833C4.74833 11.0833 2.91667 9.25167 2.91667 7C2.91667 4.74833 4.74833 2.91667 7 2.91667C9.25167 2.91667 11.0833 4.74833 11.0833 7C11.0833 9.25167 9.25167 11.0833 7 11.0833Z" fill="#F74952"/>
                </svg>
                Искать рядом со мной</div>

            <div class="slider-item-wrap d-flex">
                <div class="slider-item-text">Возраст</div>
                <div class="slider-item d-flex">
                    <?php

                    $ageFrom = 18;

                    ?>

                    <?php

                    $ageTo = 65

                    ?>
                    <div id="slider-range-age"></div>

                    <div class="d-flex filter-input-wrap">
                        <input type="text" id="age-from" class="text-left" name="age-from" readonly value="<?php echo $ageFrom?>">

                        <input type="text" id="age-to" name="age-to" class="text-right" readonly value="<?php echo $ageTo ?>">
                    </div>

                </div>
            </div>
            <div class="slider-item-wrap d-flex">
                <div class="slider-item-text">Рост</div>
                <div class="slider-item d-flex">
                    <?php

                    $rostFrom = 150;

                    ?>

                    <?php

                    $rostTo = 200;

                    ?>

                    <div id="rost-range-age"></div>

                    <div class="d-flex filter-input-wrap">
                        <input type="text" id="rost-from" class="text-left" name="rost-from" readonly value="<?php echo $rostFrom?>">

                        <input type="text" id="rost-to" class="text-right" name="rost-to" readonly value="<?php echo $rostTo?>">
                    </div>

                </div>
            </div>
            <div class="slider-item-wrap d-flex">
                <div class="slider-item-text">Вес</div>
                <div class="slider-item d-flex">
                    <?php

                    $vesFrom = 35;

                    ?>

                    <?php

                    $vestTo = 130;

                    ?>

                    <div id="slider-range-ves"></div>

                    <div class="d-flex filter-input-wrap">
                        <input type="text" id="ves-from" class="text-left" name="ves-from" readonly value="<?php echo $vesFrom ?>">

                        <input type="text" id="ves-to" class="text-right" name="ves-to" readonly value="<?php echo $vestTo ?>">
                    </div>

                </div>
            </div>
            <div class="slider-item-wrap d-flex">
                <div class="slider-item-text">Грудь</div>
                <div class="slider-item d-flex">
                    <?php

                    $grudFrom = 0;

                    ?>

                    <?php

                    $grudTo = 9;

                    ?>

                    <div id="slider-range-grud"></div>

                    <div class="d-flex filter-input-wrap">
                        <input type="text" id="grud-from" class="text-left" name="grud-from" readonly value="<?php echo $grudFrom ?>">

                        <input type="text" id="grud-to" class="text-right" name="grud-to" readonly value="<?php echo $grudTo ?>">
                    </div>


                </div>
            </div>
            <div class="slider-item-wrap d-flex">
                <div class="slider-item-text">Цена (1 час)</div>
                <div class="slider-item d-flex">
                    <?php

                    $priceFrom = 500;

                    ?>

                    <?php

                    $priceTo = 25000;

                    ?>

                    <div id="slider-range-price-1-hour"></div>

                    <div class="d-flex filter-input-wrap">
                        <input type="text" id="price-1-from" class="text-left" name="price-1-from" readonly value="<?php echo $priceFrom?>">

                        <input type="text" id="price-1-to" class="text-right" name="price-1-to" readonly value="<?php echo $priceTo ?>">
                    </div>

                </div>
            </div>

            <div class="col-12"></div>

            <div class="filter-map-item intim-haircut-wrap d-flex margin-top-20">

                <div class="heading">Интим стрижка</div>

                <?php foreach ($intimHair as $item) : ?>

                    <div class="checbox black-check-box">
                        <input type="checkbox" name="intimCut[]" id="intimCut-<?php echo $item['id']?>"
                               class="custom-checkbox" value="<?php echo $item['id']?>">
                        <label for="intimCut-<?php echo $item['id']?>"><span><?php echo $item['value']?></span></label>
                    </div>

                <?php endforeach; ?>

            </div>

            <div class="filter-map-item national-wrap d-flex margin-top-10">

                    <div class="heading">Национальность</div>

                    <?php foreach ($naci as $item) : ?>

                        <div class="checbox black-check-box">
                            <input type="checkbox" name="naci[]" id="naci-<?php echo $item['id']?>"
                                   class="custom-checkbox" value="<?php echo $item['id']?>">
                            <label for="naci-<?php echo $item['id']?>"><span><?php echo $item['value'] ?></span></label>
                        </div>

                    <?php endforeach; ?>

                </div>

            <div class="filter-map-item place-wrap d-flex margin-top-10">

                    <div class="heading">Место встречи</div>

                    <?php foreach ($place as $item) : ?>

                        <div class="checbox black-check-box">
                            <input type="checkbox" name="place[]" id="place-<?php echo $item['id']?>"
                                   class="custom-checkbox" value="<?php echo $item['id']?>">
                            <label for="place-<?php echo $item['id']?>"><span><?php echo $item['value'] ?></span></label>
                        </div>

                    <?php endforeach; ?>

                </div>

            <div class="filter-map-item hair-color-wrap d-flex margin-top-10">

                    <div class="heading">Цвет волос</div>

                    <?php foreach ($hair as $item) : ?>

                        <div class="checbox black-check-box">
                            <input type="checkbox" name="place[]" id="hair-<?php echo $item['id']?>"
                                   class="custom-checkbox" value="<?php echo $item['id']?>">
                            <label for="hair-<?php echo $item['id']?>"><span><?php echo $item['value'] ?></span></label>
                        </div>

                    <?php endforeach; ?>

                </div>

            <div class="d-none margin-top-10">
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

            <div class="col-12"></div>

            <button class="show-anket-count">Показать</button>

        </form>
    </div>
</div>