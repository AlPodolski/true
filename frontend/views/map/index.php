<?php

/* @var $this \yii\web\View */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $posts \frontend\modules\user\models\Posts[] */

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);


$result = [];

foreach ($posts as $post) {

    if (isset($post['metro'][0]['x']) and $post['metro'][0]['x'] and $post['avatar']) {

        $post['name'] = preg_replace('/[^ a-zа-яё\d]/ui', '',$post['name'] );

        $result[] = $post;

    }

}

?>

<scri1pt src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></scri1pt>

<div class="map-data d-none">
    <?php echo json_encode($result) ?>
</div>

<div class="container map-page">

    <h1> <?php echo $h1 ?> </h1>

    <?php echo \frontend\widgets\MapFilterWidget::widget() ?>

    <div id="map">
        <img src="/img/spinner.gif" alt="">
    </div>

    <script>

        function create_img(src) {

            return '<img src="' + src + '" class="yandex-map-img">'

        }

        function create_ballon_content(item) {

            return create_img(item.avatar['file']) + "<br>"
                + "<div class='map-phone'> " + item.phone + " </div>"
                + "<div class='small-red-text'>" + item.price + " р.</div>";

        }

        //ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 10,
            }, {
                searchControlProvider: 'yandex#search'
            });

            var data = JSON.parse($('.map-data').html());

            var result = [];

            var presetName = "twirl#violetIcon";

            data.forEach(function (item) {

                var myGeoObject = new ymaps.GeoObject({
                        geometry: {type: "Point", coordinates: [item.metro[0]['x'], item.metro[0]['y']]},
                        properties: {
                            clusterCaption: item.name,
                            hintContent: item.name,
                            balloonContent: create_ballon_content(item),
                        }
                    },
                    {preset: presetName});

                result.push(myGeoObject);

            })

            var myClusterer0 = new ymaps.Clusterer({preset: "twirl#redClusterIcons", gridSize: 100});

            myClusterer0.add(result);

            myMap.geoObjects.add(myClusterer0);

            $('.map-page #map img').remove();

        }


    </script>

</div>

