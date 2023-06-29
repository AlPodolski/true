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

<form action="/find" class="filter__form filter-form">
    <div class="filter-form__item filter-form__item--big">
        <div class="filter-form__item-text">Возраст</div>
        <div class="filter-form__item-drop">
            <div class="filter-form__range multi-range ">
                <div class="filter-form__range-input multi-range__input">
                    <?php

                    if ($dataGet and isset($dataGet['age-from'])) $ageFrom = $dataGet['age-from'];
                    else $ageFrom = 18;

                    ?>

                    <?php

                    if ($dataGet and isset($dataGet['age-to'])) $ageTo = $dataGet['age-to'];
                    else $ageTo = 65;

                    ?>
                    <input class="upper" type="range" step="1" min="18" max="65" value="<?php echo $ageFrom ?>"
                           name="age-from">
                    <input class="lower" type="range" step="1" min="18" max="65" value="<?php echo $ageTo ?>"
                           name="age-to">
                </div>
                <div class="filter-form__range-values">
                    <span class="filter-form__range-value filter-form__range-value--1">18</span>
                    <span class="filter-form__range-value filter-form__range-value--2">65</span>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-form__item">
        <div class="filter-form__item-text">Рост</div>
        <div class="filter-form__item-drop">
            <div class="filter-form__range filter-form__range--sm multi-range">
                <div class="filter-form__range-input filter-form__range-input--sm multi-range__input">

                    <?php

                    if ($dataGet and isset($dataGet['rost-from'])) $rostFrom = $dataGet['rost-from'];
                    else $rostFrom = 150;

                    ?>

                    <?php

                    if ($dataGet and isset($dataGet['rost-to'])) $rostTo = $dataGet['rost-to'];
                    else $rostTo = 200;

                    ?>

                    <input class="lower" type="range" step="1" min="150" max="200" value="<?php echo $rostFrom ?>"
                           name="rost-from">
                    <input class="upper" type="range" step="1" min="150" max="200" value="<?php echo $rostTo ?>"
                           name="rost-to">
                </div>
                <div class="filter-form__range-values">
                    <span class="filter-form__range-value filter-form__range-value--1">150</span>
                    <span
                            class="filter-form__range-value filter-form__range-value--2">200</span>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-form__item">
        <div class="filter-form__item-text">Вес</div>
        <div class="filter-form__item-drop">
            <div class="filter-form__range filter-form__range--sm multi-range">
                <div class="filter-form__range-input multi-range__input">

                    <?php

                    if ($dataGet and isset($dataGet['ves-from'])) $vesFrom = $dataGet['ves-from'];
                    else $vesFrom = 35;

                    ?>

                    <?php

                    if ($dataGet and isset($dataGet['ves-to'])) $vestTo = $dataGet['ves-to'];
                    else $vestTo = 130;

                    ?>

                    <input class="lower" type="range" step="1" min="35" max="130" value="<?php echo $vesFrom ?>"
                           name="ves-from">
                    <input class="upper" type="range" step="1" min="35" max="130" value="<?php echo $vestTo ?>"
                           name="ves-to">
                </div>
                <div class="filter-form__range-values">
                    <span class="filter-form__range-value filter-form__range-value--1">35</span>
                    <span class="filter-form__range-value filter-form__range-value--2">130</span>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-form__item">
        <div class="filter-form__item-text">Грудь</div>
        <div class="filter-form__item-drop">
            <div class="filter-form__range filter-form__range--sm multi-range">
                <div class="filter-form__range-input multi-range__input">

                    <?php

                    if ($dataGet and isset($dataGet['grud-from'])) $grudFrom = $dataGet['grud-from'];
                    else $grudFrom = 0;

                    ?>

                    <?php

                    if ($dataGet and isset($dataGet['grud-to'])) $grudTo = $dataGet['grud-to'];
                    else $grudTo = 9;

                    ?>

                    <input class="lower" type="range" step="1" min="0" max="9" value="<?php echo $grudFrom ?>"
                           name="grud-from">
                    <input class="upper" type="range" step="1" min="0" max="9" value="<?php echo $grudTo ?>"
                           name="grud-to">
                </div>
                <div class="filter-form__range-values">
                    <span class="filter-form__range-value filter-form__range-value--1">0</span>
                    <span class="filter-form__range-value filter-form__range-value--2">9</span>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-form__item filter-form__item--big">
        <div class="filter-form__item-text">Цена (за 1 час)</div>
        <div class="filter-form__item-drop">
            <div class="filter-form__range filter-form__range--sm multi-range">
                <div class="filter-form__range-input multi-range__input">

                    <?php

                    if ($dataGet and isset($dataGet['price-1-from'])) $priceFrom = $dataGet['price-1-from'];
                    else $priceFrom = 500;

                    ?>

                    <?php

                    if ($dataGet and isset($dataGet['price-1-to'])) $priceTo = $dataGet['price-1-to'];
                    else $priceTo = 25000;

                    ?>

                    <input class="lower" type="range" step="1" min="500" max="25000" value="<?php echo $priceFrom ?>"
                           name="price-1-from">
                    <input class="upper" type="range" step="1" min="500" max="25000" value="<?php echo $priceTo ?>"
                           name="price-1-to">
                </div>
                <div class="filter-form__range-values">
                    <span class="filter-form__range-value filter-form__range-value--1">500</span>
                    <span class="filter-form__range-value filter-form__range-value--2">25000</span>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-form__item">
        <button class="filter-form__btn" type="submit">Показать</button>
        <div class="filter-form__mob">
            <button type="submit"
                    class="filter-form__mob-btn filter-form__mob-btn--1">Применить
            </button>
            <button class="filter-form__mob-btn filter-form__mob-btn--2"
                    data-filter-reset>Сбросить
            </button>
        </div>
    </div>
</form>