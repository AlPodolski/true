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
        url: "/chat/get", //Путь к обработчику
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

function editPhone(object){
    var phone = $(object).siblings('.phone-change').val();
    var userId = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: "/phone/update", //Путь к обработчику
        data: 'user_id=' + userId + '&phone=' + phone ,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text('Готово');

        }
    })

}
function activateUser(object){

    var userId = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: "/user/activate", //Путь к обработчику
        data: 'id=' + userId ,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text('Готово');

        }
    })

}

function start_all(){
    $( ".start-post" ).each(function( index ) {
        $(this).trigger('click')
    });
}

function delete_selected(){

    $( ".delete-post" ).each(function() {

        if (this.checked){

            var id = $(this).attr('data-id')
            var object = this;

            $.ajax({
                type: 'POST',
                url: "/posts/delete?id=" + id, //Путь к обработчику
                cache: false,
                async: false,
                success: function () {
                    $(object).closest('tr').remove();
                }
            })
        }
    });

}

function check_anket(object){

    var id = $(object).attr('data-id');

    var check_photo = $(object).closest('tr').find('.check-photo');

    var check = '';

    if ($(check_photo).prop('checked')){
        check = '&check=true'
    }

    $.ajax({
        type: 'POST',
        url: "/posts/check", //Путь к обработчику
        data: 'id='+id + check ,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text(data);
            $(object).attr('onclick', '');
            $(object).removeClass('check-text');

        }
    })

}

function check_advert(object){

    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: "/advert/check", //Путь к обработчику
        data: 'id='+id,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text('Готово');

        }
    })

}

function close_chat(){

    $('.dialog_list-wrap').removeClass('dialog_list-wrap-with-dialog d-flex');

}
function check_review(object){

    var id = $(object).attr('data-id')

    $.ajax({
        type: 'POST',
        url: "/review/check", //Путь к обработчику
        data: 'id=' + id,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).text('Готово');

        }
    })

}
function remove_review(object){

    var id = $(object).attr('data-id')

    $.ajax({
        type: 'POST',
        url: "/review/remove", //Путь к обработчику
        data: 'id=' + id,
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            $(object).closest('tr').remove();

        }
    })

}

function send_message(object){

    var dialog_id = $(object).attr('data-dialog-id');
    var to = $(object).attr('data-user-id-to');

    var text = $('#sendmessageform-text').val();

    var sendData = 'dialog_id='+dialog_id+'&to='+to+'&text='+text;

    $.ajax({
        url: '/chat/send',
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

function delete_item(object){

    var deleteUrl = $(object).attr('delete-url');
    var pjaxContainer = $(object).attr('pjax-container');
    var result = confirm('Delete this item, are you sure?');
    if(result) {
        $.ajax({
            url: deleteUrl,
            type: 'post',
            error: function(xhr, status, error) {
                alert('There was an error with your request.' + xhr.responseText);
            }
        }).done(function(data) {
            $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
        });
    }


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