function create_img(src, link) {
    return '<a target="_blank" href="/post/'+ link +'"><img src="' + src + '" class="yandex-map-img"></a>'
}

function create_ballon_content(item) {
    return create_img(item.avatar['file'], item.id) + "<br>"
        + "<a href='tel:+" + item.phone + "' class='map-phone'> " + item.phone + " </a><br>"
        + "<a target='_blank' class='map-link' href='/post/" + item.id + "'> Подробнее </a>"
        + "<div class='small-red-text'>" + item.price + " р.</div>";
}

ymaps.ready(init_map_with_posts);

function init_map_with_posts() {
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
                geometry: {type: "Point", coordinates: [item.x, item.y]},
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

function getForMap() {

    var form = $('#map-form');
    var msg = form.serialize();

    $('#map').addClass('blur');

    $.ajax({
        type: 'POST',
        url: '/map/filter', // Обработчик собственно
        data: msg,
        success: function (data) {
            $('.map-data').html(data);
            $('#map').html('').removeClass('blur');
            init_map_with_posts();
        },
        error: function () {
            alert('Ошибка!');
        }
    });

}