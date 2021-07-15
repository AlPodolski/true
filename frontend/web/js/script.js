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

function check_number(object){

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

function open_rating_block(object){

    $(object).siblings('.rating-block').removeClass('rating-block-close');

    $(object).remove();

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

    $('.carousel').carousel({interval: false});

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

function add_phone_view(object){

    var id = $(object).attr('data-id');
    var phone = $(object).attr('data-tel');

    $.ajax({
        type: 'POST',
        url: "/view/phone", //Путь к обработчику
        data: 'id=' + id,
        cache: false,
        success: function (data) {
            window.location.href=phone;
        }
    })

}

function get_claim_modal(){

    $.ajax({
        type: 'POST',
        url: "/claim/get-modal", //Путь к обработчику
        cache: false,
        success: function (data) {

            $('#claimModal .modal-body').html(data);
            $('#claimModal').modal('toggle' );

        }
    })

}

function get_data(object){

    var data_type = $(object).attr('data-type');

    var data = 'data='+data_type;

    var url = "/data/get?data="+data_type;

    if(data_type == 'filter'){

        if(window.location.search == ''){

            url = "/data/get?data="+data_type;

        }else{

            url = "/data/get" + encodeURI(window.location.search) + "&data="+data_type;

        }

    }

    $.ajax({
        type: 'GET',
        url: url,
        cache: false,
        success: function (data) {

            if(data_type == 'filter'){

                var scriptTag= document.createElement( "script" );
                scriptTag.type = "text/javascript";
                scriptTag.src = "/js/jquery-ui.js";
                $("body").append(scriptTag);
                $("head").prepend('<link href="/css/jquery-ui.css" rel="stylesheet">');

                $('.filter-block').html(data);

                $('.filter-block').removeClass('d-none');

                filter();

            }else{

                $('#dataModal .modal-body').html(data);
                $('#dataModal').modal('toggle');

            }

        }
    })

}

function close_filter(){
    $('.filter-block').addClass('d-none');
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

        var single = $(target).attr('data-single');

        if(single === 1){
            $('[data-post-id]').each(function() {

                id = id + $(this).attr('data-post-id') + ',';

            });

            $.ajax({
                type: 'POST',
                url: '/post/more',
                data: 'id='+id,
                async:false,
                dataType: "html",
                cache: false,
                beforeSend: function() {
                    $(target).removeClass('footer');
                },
                success: function (data){

                    if(data !== ''){

                        $('.single-content').append(data);

                        $(target).addClass('footer');

                        add_img_grid();

                    }else{

                        $('.dots').remove();

                    }


                    // window.history.pushState("object or string", "Title", "/page-2");

                },
            })

        }else{

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

function close_parent_modal(object){

    $(object).closest('.modal').modal('toggle');

}

function set_read_message(object){

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

function dopolnitaelno(){

    $('.dopolnitaelno-btn span').toggleClass('d-none');
    $('.dop-block').toggleClass('d-none');
    $('.dopolnitaelno-btn svg').toggleClass('arrow-down');

}

function more_search(){
    $('.more-search-btn span').toggleClass('d-none');
    $('.more-search-block').toggleClass('d-none');
    $('.more-search-btn svg').toggleClass('arrow-down');
}

function filter(){

    $( "#slider-range-age" ).slider({
        range: true,
        min: 18,
        max: 65,
        values: [ $( "#age-from" ).val(), $( "#age-to" ).val() ],
        slide: function( event, ui ) {
            $( "#age-from" ).val( ui.values[ 0 ] );
            $( "#age-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#rost-range-age" ).slider({
        range: true,
        min: 150,
        max: 200,
        values: [ $( "#rost-from" ).val(), $( "#rost-to" ).val() ],
        slide: function( event, ui ) {
            $( "#rost-from" ).val( ui.values[ 0 ] );
            $( "#rost-to" ).val( ui.values[ 1 ] );
        }
    });

    $( "#slider-range-ves" ).slider({
        range: true,
        min: 35,
        max: 130,
        values: [ $( "#ves-from" ).val(), $( "#ves-to" ).val() ],
        slide: function( event, ui ) {
            $( "#ves-from" ).val( ui.values[ 0 ] );
            $( "#ves-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-grud" ).slider({
        range: true,
        min: 0,
        max: 9,
        values: [ $( "#grud-from" ).val(), $( "#grud-to" ).val() ],
        slide: function( event, ui ) {
            $( "#grud-from" ).val( ui.values[ 0 ] );
            $( "#grud-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-price-1-hour" ).slider({
        range: true,
        min: 500,
        max: 25000,
        values: [ $( "#price-1-from" ).val(), $( "#price-1-to" ).val() ],
        slide: function( event, ui ) {
            $( "#price-1-from" ).val( ui.values[ 0 ] );
            $( "#price-1-to" ).val( ui.values[ 1 ] );
        }
    });
    $( "#slider-range-price-2-hour" ).slider({
        range: true,
        min: 500,
        max: 25000,
        values: [$( "#price-2-from" ).val(), $( "#price-2-to" ).val()],
        slide: function( event, ui ) {
            $( "#price-2-from" ).val( ui.values[ 0 ] );
            $( "#price-2-to" ).val( ui.values[ 1 ] );
        }
    });

}

$(document).ready(main);