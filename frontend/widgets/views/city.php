<?php

/* @var $cityList \common\models\City[] */
/* @var $metroList \frontend\models\Metro[] */

?>

<div class="header__col header__col--location">
    <form action="#" class="header-location">
        <select onchange="selectHref(this)" class="header-location__select header-location__select--city"
                data-custom-select name="city" id="city-select">

            <?php foreach ($cityList as $cityItem) : ?>

                <?php

                $city = $cityItem->url;

                if ($cityItem->actual_city) $city = $cityItem->actual_city;

                $domain = Yii::$app->params['domain'];

                if ($cityItem->domain) $domain = $cityItem->domain;

                ?>

                <option value="https://<?php echo $city . '.' . $domain ?>"><?php echo $cityItem->city ?></option>

            <?php endforeach; ?>

        </select>

        <?php if ($metroList) : ?>

            <select class="header-location__select header-location__select--metro"
                    data-custom-select name="city" >

                <?php foreach ($metroList as $metroItem) : ?>

                    <option value="/metro-<?php echo $metroItem['url'] ?>">
                        <?php echo $metroItem['value']; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        <?php endif; ?>

    </form>
</div>