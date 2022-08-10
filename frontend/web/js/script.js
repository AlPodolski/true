$(document).ready(function () {
    $.getScript("/js/jquery-ui.min.js", function (data, textStatus, jqxhr) {
        $("head").prepend('<link href="/css/jquery-ui.min.css" rel="stylesheet">');
        filter();
    });
});

function close_text(){
    $('.text-block-wrap').remove();
    document.cookie = 'text=close';
}

var exist_map_block = false;

if ($('.yandex-map').length > 0) {

    exist_map_block = true;

}

var exist_jivo_block = false;

if ($('.jivo-block').length > 0) {

    exist_jivo_block = true;

}

function rememberClose(object) {

    var type = $(object).attr('data-type')

    document.cookie = type + '=1; max-age=' + (3600 * 24 * 31);

}

function send_to_telegram(object) {

    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: "/cabinet/telegram/send", //Путь к обработчику
        data: 'id=' + id,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text(data).attr('onclick', '')

        }
    })

}

function delete_item(object) {

    var id = $(object).attr('data-id');
    var name = $(object).attr('data-name');

    let isBoss = confirm("Удалить анкету " + name + " ?");

    if (isBoss === true) {

        $.ajax({
            type: 'POST',
            url: "/cabinet/post/delete", //Путь к обработчику
            data: 'id=' + id,
            response: 'text',
            dataType: "html",
            cache: false,
            success: function (data) {

                $(object).closest('.cabinet-item').remove();

            }
        })

    }


}

function get_dialog(object) {

    var dialog_id = $(object).attr('data-dialog-id');
    var to = $(object).attr('data-to');

    if (!$(object).closest('.dialog_list-wrap').hasClass('dialog_list-wrap-with-dialog')) {

        $(object).closest('.dialog_list-wrap').addClass('dialog_list-wrap-with-dialog d-flex');

    }

    $('.dialog_item').each(function () {
        $(this).removeClass('selected-dialog');
    });

    $('.dialog').html('')

    $.ajax({
        type: 'POST',
        url: "/cabinet/chat/get", //Путь к обработчику
        data: 'dialog_id=' + dialog_id + '&to=' + to,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).addClass('selected-dialog');

            $('.dialog').html(data);

            $('.chat-wrap').scrollTop($('.chat-wrap').height() + 99999999);

        }
    })
}

function get_mobil_map_block(object) {

    init_yandex_map(object);

    $('.anket-map-block-' + $(object).attr('data-id')).removeClass('d-none');

    $('.anket-map-block-' + $(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}

function close_mobil_map_block(object) {

    $('.anket-map-block-' + $(object).attr('data-id')).animate({

        left: '-120%'

    }, 250);

}

function init_yandex_map(object) {

    var map_name = $(object).attr('data-map');

    var x = $('#' + map_name).attr('data-x');
    var y = $('#' + map_name).attr('data-y');

    if (typeof ymaps == 'undefined') {

        $.getScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU", function (data, textStatus, jqxhr) {
            ymaps.ready(function () {

                if ($('#' + map_name).hasClass('map-not-exist')) {

                    $('#' + map_name).removeClass('map-not-exist');

                    $('.map').each(init(map_name, x, y));

                }

            })
        });
    } else {

        ymaps.ready(function () {

            if ($('#' + map_name).hasClass('map-not-exist')) {

                $('#' + map_name).removeClass('map-not-exist');

                $('.map').each(init(map_name, x, y));

            }

        })
    }

}

function init(map_name, x, y) {

    console.log(map_name);

    var myMap = new ymaps.Map(map_name, {
        center: [x, y],
        zoom: 13,
    });

    // Все виды меток
    // https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage-docpage/


    // Собственное изображение для метки с контентом
    var placemark4 = new ymaps.Placemark([x, y], {
        // hintContent: 'Собственный значок метки с контентом',
    }, {
        // Опции.

        // Необходимо указать данный тип макета.
        iconLayout: 'default#image',

        // Своё изображение иконки метки.
        iconImageHref: '/img/map.svg',
        // Размеры метки.
        iconImageSize: [131, 62],
        // Смещение левого верхнего угла иконки относительно
        // её "ножки" (точки привязки).
        iconImageOffset: [-72, -62],
    });

    myMap.geoObjects.add(placemark4);
}

function map() {
    ymaps.ready(init);
}

function check_number(object) {

    var phone = $(object).attr('data-number');

    $.ajax({
        type: 'POST',
        url: "/cabinet/phone/get-info", //Путь к обработчику
        data: 'phone=' + phone,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $('#phoneModal .modal-body').html(data);

            $('#phoneModal').modal('toggle');

        }
    })

}

function open_rating_block(object) {

    $(object).siblings('.rating-block').removeClass('rating-block-close');

    $(object).remove();

}

function close_chat() {

    $('.dialog_list-wrap').removeClass('dialog_list-wrap-with-dialog d-flex');

}

function findCity(object) {

    var cityName = $(object).val();

    if (cityName.length > 2) {

        var url = "/data/get?data=city&val=" + cityName;

        $.ajax({
            type: 'GET',
            url: url, //Путь к обработчику
            response: 'text',
            dataType: "html",
            cache: false,
            success: function (data) {

                $('#cityModal .city-list').html(data)

            }
        })

    }

}

function send_message(object) {

    var dialog_id = $(object).attr('data-dialog-id');
    var to = $(object).attr('data-user-id-to');

    var text = $('#sendmessageform-text').val();

    var sendData = 'dialog_id=' + dialog_id + '&to=' + to + '&text=' + text;

    $.ajax({
        url: '/cabinet/chat/send',
        type: 'POST',
        data: sendData,
        datatype: 'json',
        // async: false,
        success: function (data) {

            add_message(text);

            $('#message-form textarea').val('');

            $('.chat-wrap').scrollTop($('.chat-wrap').height() + 99999999);

        },

        error: function (data) {
            alert("Ошибка");
        },
    });

}

function add_message(text) {

    $('.chat').prepend('<div class="wall-tem right-message">\n' +
        '    <div class="post_header">\n' +
        '        <div class="post_header_info">\n' +
        '            <div class="post-text">\n' +
        '                <span class="message-wrap">\n' +
        '                    ' + text +
        '                </span>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div style="clear: both">\n' +
        '    </div>\n' +
        '</div>');

}

function show_otzivi_block(object) {

    $('.otzivi-block-' + $(object).attr('data-id')).removeClass('d-none');

    $('.otzivi-block-' + $(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}

function close_otzivi_block() {

    $('.otzivi-block').animate({

        left: '-120%'

    }, 250);

}

function show_anket_params_block(object) {

    $('.anket-params-block-' + $(object).attr('data-id')).removeClass('d-none');

    $('.anket-params-block-' + $(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}

function close_anket_params_block(object) {

    $('.anket-params-block-' + $(object).attr('data-id')).animate({

        left: '-120%'

    }, 250);

}

function show_site_price_block(object) {

    $('.carousel').carousel({interval: false});

    $('.site-price-block-' + $(object).attr('data-id')).removeClass('d-none');

    $('.site-price-block-' + $(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}

function close_site_price_block() {

    $('.site-price-block').animate({

        left: '-120%'

    }, 250);

}

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function inView($elem) {
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

var changeURL = debounce(function () {
    $('[data-url]').each(function () {
        if (inView($(this))) {

            if (window.location.pathname + window.location.search != $(this).attr('data-url') && $(this).attr('data-url').length > 0) {

                window.history.pushState('', document.title, $(this).attr('data-url'));
                yaCounter70919698.hit($(this).attr('data-url'));

            }
        }
    });
}, 1);

function favorite(object) {

    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: "/favorite", //Путь к обработчику
        data: 'id=' + id,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {
            $(object).toggleClass('favorite');
        }
    })

}

$(document).ready(function () {
    $('.carousel').carousel();
    $("#editprofileform-avatar").on('change', function () {

        $("#change-video-label").text('');
        $(".editprofileform-avatar-label .red-text .add-text").text('Фото выбрано');

    });

});

function get_comments_forum(object) {

    $('#forum-comments-modal').modal('show');

}

function getPhone(object) {

    var id = $(object).attr('data-id');
    var price = $(object).attr('data-price');
    var city = $(object).attr('data-city');
    var rayon = $(object).attr('data-rayon');
    var age = $(object).attr('data-age');

    if (typeof $(object).attr('data-num') !== typeof undefined) {

        window.location.href = 'tel:+' + $(object).attr('data-num');

    } else {

        $.ajax({
            type: 'POST',
            url: "/phone/get", //Путь к обработчику
            data: 'id=' + id + '&price=' + price + '&city_id=' + city + '&rayon=' + rayon + '&age=' + age,
            cache: false,
            success: function (data) {

                $(object).attr('data-num', data);

                $(object).text(data);
                window.location.href = 'tel:+' + data;
            }
        })

    }

}

function add_phone_view(object) {

    var id = $(object).attr('data-id');
    var phone = $(object).attr('data-tel');
    $(object).text($(object).attr('data-number'));
    $.ajax({
        type: 'POST',
        url: "/view/phone", //Путь к обработчику
        data: 'id=' + id,
        cache: false,
        success: function (data) {

            window.location.href = phone;
            get_phone_review_form(id);

        }
    })

}

function get_phone_review_form(id) {

    var target = 'phone-claim-form';

    $.ajax({
        type: 'POST',
        data: 'id=' + id + '&target=' + target,
        url: "/post/get", //Путь к обработчику
        cache: false,
        success: function (data) {

            $('#info-modal .modal-body').html(data);

            $('#info-modal').modal('show');

        }
    })

}

function publication(object) {

    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        data: 'id=' + id,
        url: "/cabinet/post/publication", //Путь к обработчику
        cache: false,
        success: function (data) {

            $(object).text(data);

        }
    })

}

function get_claim_modal() {

    $.ajax({
        type: 'POST',
        url: "/claim/get-modal", //Путь к обработчику
        cache: false,
        success: function (data) {

            $('#claimModal .modal-body').html(data);
            $('#claimModal').modal('toggle');

        }
    })

}

function get_data(object) {

    var data_type = $(object).attr('data-type');

    var data = 'data=' + data_type;

    var url = "/data/get?data=" + data_type;

    if (data_type == 'filter') {

        if (window.location.search == '') {

            url = "/data/get?data=" + data_type;

        } else {

            url = "/data/get" + encodeURI(window.location.search) + "&data=" + data_type;

        }

    }

    $.ajax({
        type: 'GET',
        url: url,
        cache: false,
        success: function (data) {

            if (data_type == 'filter') {

                var scriptTag = document.createElement("script");
                scriptTag.type = "text/javascript";
                scriptTag.src = "/js/jquery-ui.js";
                $("body").append(scriptTag);
                $("head").prepend('<link href="/css/jquery-ui.css" rel="stylesheet">');

                $('.filter-block').html(data);

                $('.filter-block').removeClass('d-none');

                filter();

            } else {

                $('#dataModal .modal-body').html(data);
                $('#dataModal').modal('toggle');

            }

        }
    })

}

function toggle_filter() {
    $('.filter-block form').toggleClass('d-flex');
}

function toggle_map_filter() {
    $('#map-filter').toggle();
}


function send_comment(object) {

    var formData = new FormData($(".form-wall-comment-" + $(object).attr('data-id'))[0]);

    var id = $(object).attr('data-id');

    $.ajax({
        url: '/comment',
        type: 'POST',
        data: formData,
        datatype: 'json',
        // async: false,
        beforeSend: function () {
            $('#w0 .form-text').css('display', 'none');
        },
        success: function (data) {
            $(object).closest('.comment-wall-form').siblings('.comments-list').append(data);
        },

        complete: function () {
            // success alerts
        },

        error: function (data) {
            alert("There may a error on uploading. Try again later");
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function init_yandex() {
    $(".yandex-map").each(function (index) {

        var object = this;

        var x = $(object).attr('data-x');
        var y = $(object).attr('data-y');

        ymaps.ready(function () {

            if ($(object).hasClass('map-not-exist')) {

                $(object).removeClass('map-not-exist');

                $('.map').each(init(object, x, y));

            }

        })
    });
}

var load_map_status = false;
var start_load_map_status = false;

$(window).scroll(function () {

    if (exist_jivo_block){
        $('.jivo-block').remove();
        exist_jivo_block = false;
        $.getScript("//code-ya.jivosite.com/widget/N3G2svN2tk", function (data, textStatus, jqxhr) {

        });
    }

    if (exist_map_block && !load_map_status && !start_load_map_status) {

        start_load_map_status = true;

        $.getScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU", function (data, textStatus, jqxhr) {
            ymaps.ready(function () {

                load_map_status = true;

                init_yandex();

            })
        });

    }
    if (exist_map_block && load_map_status) {

        init_yandex();

    }


    var target = $('.pager');
    var targetPos = target.offset().top;
    var winHeight = $(window).height();
    var scrollToElem = targetPos - winHeight;

    var winScrollTop = $(this).scrollTop();

    var page = $(target).attr('data-page');

    var url = $(target).attr('data-adress');
    var request = $(target).attr('data-reqest');

    var accept = $(target).attr('data-accept');

    changeURL();

    if (winScrollTop > (scrollToElem - 100)) {

        var single = $(target).attr('data-single');

        if (single == 1) {

            $('[data-post-id]').each(function () {

                id = id + $(this).attr('data-post-id') + ',';

            });

        } else {

            var id = [];

            $('[data-post-id]').each(function () {

                id.push($(this).attr('data-post-id'));

            });

            $.ajax({
                type: 'POST',
                url: '' + url,
                data: 'page=' + page + '&req=' + request + '&id=' + JSON.stringify(id),
                async: false,
                dataType: "html",
                headers: {
                    "Accept": accept,
                },
                cache: false,
                success: function (data) {

                    if (data !== '') {

                        $('.content').append(data);

                        page = $(target).attr('data-page', Number(page) + 1);

                        $('.carousel').carousel();

                    } else {

                        $(target).remove();
                        $('.dots').remove();

                    }

                }
            })
        }

    }

});

function closeHelper(object){

    if (!$('#helper').hasClass('show-helper')){
        $('#helper').remove();
        let date = new Date(Date.now() + (3600 * 24));
        document.cookie = "helper=close; expires=" + date;
    }else{
        console.log($('#helper').removeClass('show-helper'));
        $('#helper').removeClass('show-helper');
    }

}

var main = function () {

    $('.mobil-menu').click(function () {

        $('.menu').animate({

            left: '0px'

        }, 250);

        $('body').css('overflow', 'hidden');

        $('body').animate({
            left: '0'
        }, 250);
    });

    /* Закрытие меню */

    $('.icon-close').click(function () {

        $('body').css('overflow', 'inherit');

        $('.menu').animate({

            left: '-120%'

        }, 200);

    });    /* Закрытие меню */

};


$('.login-icon-close').click(function () {

    $('body').css('overflow', 'inherit');

    $('.login').animate({

        left: '-120%'

    }, 200);

});
$('.register-icon-close').click(function () {

    $('body').css('overflow', 'inherit');

    $('.register').animate({

        left: '-120%'

    }, 200);

});

function get_user_menu() {

    $('.login').animate({

        left: '0px'

    }, 250);

}

function get_register_btn() {

    $('.register').animate({

        left: '0px'

    }, 250);

}

function close_parent_modal(object) {

    $(object).closest('.modal').modal('toggle');

}

function set_read_message(object) {

    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: '/cabinet/message/read',
        data: 'id=' + id,
        async: false,
        dataType: "html",
        cache: false,
        success: function (data) {


        }
    })

}

function dopolnitaelno() {

    $('.dopolnitaelno-btn span').toggleClass('d-none');
    $('.dop-block').toggleClass('d-none');
    $('.dopolnitaelno-btn svg').toggleClass('arrow-down');

}

function toggleHelper(object){

    $('#helper').toggleClass('show-helper');

}

function more_search() {
    $('.more-search-btn span').toggleClass('d-none');
    $('.more-search-block').toggleClass('d-none');
    $('.more-search-btn svg').toggleClass('arrow-down');
    $('#searchForm').toggleClass('open-form');
}

function setView(){

    if ($('#sort-select').val()) {

        document.cookie = 'view=' + $('#sort-select').val();

    }
    window.location.href = location.pathname;

}

function setSort() {

    if ($('#sort-select').val()) {

        document.cookie = 'sort=' + $('#sort-select').val();

    }

    window.location.href = location.pathname;

}

function filter() {

    $("#slider-range-age").slider({
        range: true,
        min: 18,
        max: 65,
        values: [$("#age-from").val(), $("#age-to").val()],
        slide: function (event, ui) {
            $("#age-from").val(ui.values[0]);
            $("#age-to").val(ui.values[1]);
        }
    });
    $("#rost-range-age").slider({
        range: true,
        min: 150,
        max: 200,
        values: [$("#rost-from").val(), $("#rost-to").val()],
        slide: function (event, ui) {
            $("#rost-from").val(ui.values[0]);
            $("#rost-to").val(ui.values[1]);
        }
    });

    $("#slider-range-ves").slider({
        range: true,
        min: 35,
        max: 130,
        values: [$("#ves-from").val(), $("#ves-to").val()],
        slide: function (event, ui) {
            $("#ves-from").val(ui.values[0]);
            $("#ves-to").val(ui.values[1]);
        }
    });
    $("#slider-range-grud").slider({
        range: true,
        min: 0,
        max: 9,
        values: [$("#grud-from").val(), $("#grud-to").val()],
        slide: function (event, ui) {
            $("#grud-from").val(ui.values[0]);
            $("#grud-to").val(ui.values[1]);
        }
    });
    $("#slider-range-price-1-hour").slider({
        range: true,
        min: 500,
        max: 25000,
        values: [$("#price-1-from").val(), $("#price-1-to").val()],
        slide: function (event, ui) {
            $("#price-1-from").val(ui.values[0]);
            $("#price-1-to").val(ui.values[1]);
        }
    });
    $("#slider-range-price-2-hour").slider({
        range: true,
        min: 500,
        max: 25000,
        values: [$("#price-2-from").val(), $("#price-2-to").val()],
        slide: function (event, ui) {
            $("#price-2-from").val(ui.values[0]);
            $("#price-2-to").val(ui.values[1]);
        }
    });

}

$(document).ready(main);