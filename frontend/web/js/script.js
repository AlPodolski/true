function get_dialog(object){

    var dialog_id = $(object).attr('data-dialog-id');
    var to = $(object).attr('data-to');

    if(!$(object).closest('.dialog_list-wrap').hasClass('dialog_list-wrap-with-dialog')){

        $(object).closest('.dialog_list-wrap').addClass('dialog_list-wrap-with-dialog d-flex' );

    }

    $('.dialog_item').each(function() {
        $(this).removeClass('selected-dialog');
    });

    $('.dialog').html('')

    $.ajax({
        type: 'POST',
        url: "/cabinet/chat/get", //Путь к обработчику
        data: 'dialog_id=' + dialog_id+'&to='+to,
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

function close_chat(){

    $('.dialog_list-wrap').removeClass('dialog_list-wrap-with-dialog d-flex');

}

function send_message(object){

    var dialog_id = $(object).attr('data-dialog-id');
    var to = $(object).attr('data-user-id-to');

    var text = $('#sendmessageform-text').val();

    var sendData = 'dialog_id='+dialog_id+'&to='+to+'&text='+text;

    $.ajax({
        url: '/cabinet/chat/send',
        type: 'POST',
        data: sendData,
        datatype:'json',
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

function add_message(text){

    $('.chat').prepend('<div class="wall-tem right-message">\n' +
        '    <div class="post_header">\n' +
        '        <div class="post_header_info">\n' +
        '            <div class="post-text">\n' +
        '                <span class="message-wrap">\n' +
        '                    '+text +
        '                </span>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div style="clear: both">\n' +
        '    </div>\n' +
        '</div>');

}

function show_otzivi_block(object){

    $('.otzivi-block-'+$(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}
function close_otzivi_block(){

    $('.otzivi-block').animate({

        left: '-120%'

    }, 250);

}

function show_anket_params_block(object){

    $('.anket-params-block-'+$(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}
function close_anket_params_block(object){

    $('.anket-params-block-'+$(object).attr('data-id')).animate({

        left: '-120%'

    }, 250);

}

function show_site_price_block(object){

    $('.owl-carousel-main').owlCarousel({
        margin:10,
        autoplayTimeout:9000,
        autoplay:true,
        nav : true,
        loop: true,
        items:1
    })

    $('.site-price-block-'+$(object).attr('data-id')).animate({

        left: '0px'

    }, 250);

}
function close_site_price_block(){

    $('.site-price-block').animate({

        left: '-120%'

    }, 250);

}

function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
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

var changeURL = debounce(function() {
    $('[data-url]').each(function() {
        if (inView($(this))) {

            if(window.location.pathname != $(this).attr('data-url')){

                window.history.pushState('', document.title, $(this).attr('data-url'));

                console.log(window.location.pathname);

            }
        }
    });
}, 1);

function favorite(object){

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
$(document).ready(function() {

    $("#editprofileform-avatar").on('change', function () {

        $("#change-video-label").text('');
        $(".editprofileform-avatar-label .red-text .add-text").text('Фото выбрано');

    });

});
function get_comments_forum(object){

    $('#forum-comments-modal').modal('show');

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

$(window).scroll(function () {

    var target = $('.pager');
    var targetPos = target.offset().top;
    var winHeight = $(window).height();
    var scrollToElem = targetPos - winHeight;

    var winScrollTop = $(this).scrollTop();

    var page = $(target).attr('data-page');

    var url = $(target).attr('data-url');
    var request = $(target).attr('data-reqest');

    var accept = $(target).attr('data-accept');

    changeURL();

    if (winScrollTop > (scrollToElem - 100)) {

        $.ajax({
            type: 'POST',
            url: '' + url,
            data: 'page=' + page + '&req=' + request,
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

                } else {

                    $(target).remove();
                    $('.dots').remove();

                }

            }
        })
    }
});
var main = function() {

    $('.mobil-menu').click(function() {

        $('.menu').animate({

            left: '0px'

        }, 250);

        $('body').css('overflow' , 'hidden');

        $('body').animate({
            left: '0'
        }, 250);
    });

    /* Закрытие меню */

    $('.icon-close').click(function() {

        $('body').css('overflow' , 'inherit');

        $('.menu').animate({

            left: '-120%'

        }, 200);

    });    /* Закрытие меню */

};


$('.login-icon-close').click(function() {

    $('body').css('overflow' , 'inherit');

    $('.login').animate({

        left: '-120%'

    }, 200);

});
$('.register-icon-close').click(function() {

    $('body').css('overflow' , 'inherit');

    $('.register').animate({

        left: '-120%'

    }, 200);

});

function get_user_menu(){

    $('.login').animate({

        left: '0px'

    }, 250);

}
function get_register_btn(){

    $('.register').animate({

        left: '0px'

    }, 250);

}

$('.search-by-params-btn').click(function() {

    $('.filter-block').toggleClass('d-none');

});

$('.dopolnitaelno-btn').click(function() {

    $('.dopolnitaelno-btn span').toggleClass('d-none');
    $('.dop-block').toggleClass('d-none');
    $('.dopolnitaelno-btn svg').toggleClass('arrow-down');

});


$('.more-search-btn').click(function() {
    $('.more-search-btn span').toggleClass('d-none');
    $('.more-search-block').toggleClass('d-none');
    $('.more-search-btn svg').toggleClass('arrow-down');

});

$( function() {
    $( "#slider-range-age" ).slider({
        range: true,
        min: 18,
        max: 65,
        values: [ 18, 65 ],
        slide: function( event, ui ) {
            $( "#age-from" ).val( ui.values[ 0 ] );
            $( "#age-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#rost-range-age" ).slider({
        range: true,
        min: 150,
        max: 200,
        values: [ 150, 200 ],
        slide: function( event, ui ) {
            $( "#rost-from" ).val( ui.values[ 0 ] );
            $( "#rost-to" ).val( ui.values[ 1 ] );
        }
    });

    $( "#slider-range-ves" ).slider({
        range: true,
        min: 35,
        max: 130,
        values: [ 35, 130 ],
        slide: function( event, ui ) {
            $( "#ves-from" ).val( ui.values[ 0 ] );
            $( "#ves-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-grud" ).slider({
        range: true,
        min: 0,
        max: 9,
        values: [ 0, 9 ],
        slide: function( event, ui ) {
            $( "#grud-from" ).val( ui.values[ 0 ] );
            $( "#grud-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-price-1-hour" ).slider({
        range: true,
        min: 500,
        max: 25000,
        values: [ 500, 25000 ],
        slide: function( event, ui ) {
            $( "#price-1-from" ).val( ui.values[ 0 ] );
            $( "#price-1-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-price-2-hour" ).slider({
        range: true,
        min: 500,
        max: 25000,
        values: [ 500, 25000 ],
        slide: function( event, ui ) {
            $( "#price-2-from" ).val( ui.values[ 0 ] );
            $( "#price-2-to" ).val( ui.values[ 1 ] );
        }
    });

} );

$(document).ready(main);