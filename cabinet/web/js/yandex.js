function init_yandex_for_cabinet(){
    if (typeof ymaps == 'undefined') {
        $.getScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU", function (data, textStatus, jqxhr) {
            ymaps.ready(function () {
                init_cab();
            })
        });
    } else {
        ymaps.ready(function () {
            init_cab();
        })
    }
}

$(document).ready(function () {
    init_yandex_for_cabinet();
});

function init_cab() {

    var myPlacemark,
        myMap = new ymaps.Map('map', {
            center: [55.753845599344615, 37.62512497949332],
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        });

    var x = $('#posts-x').val();
    var y =  $('#posts-y').val();

    if (x){

        myMap.geoObjects.add(createPlacemark([x, y]));

    }

    // Слушаем клик на карте.
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');

        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }
        // Если нет – создаем.
        else {
            myPlacemark = createPlacemark(coords);
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
        }

        $('#posts-x').val(coords[0]);
        $('#posts-y').val(coords[1]);

    });

    // Создание метки.
    function createPlacemark(coords) {
        return new ymaps.Placemark(coords, {
            iconCaption: ''
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: true
        });
    }

    // Определяем адрес по координатам (обратное геокодирование).
    function getAddress(coords) {
        myPlacemark.properties.set('iconCaption', '');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

            myPlacemark.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: [
                        // Название населенного пункта или вышестоящее административно-территориальное образование.
                        firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                        // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                        firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                    ].filter(Boolean).join(', '),
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: firstGeoObject.getAddressLine()
                });
        });
    }
}