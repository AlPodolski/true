
function add_img_grid(){

    $('.aniimated-thumbnials').each(function(i){

        var singleGallery = $(this);
        singleGallery.lightGallery();

    });
    $('.carousel-inner').each(function(i){

        var singleGallery = $(this);
        singleGallery.lightGallery();

    });

}

$( function() {

    add_img_grid();

})

$( function() {
    

    $(".rate").rateYo({
        rating: 5,
        fullStar: true
    });

    $(".rate").rateYo("option", "onSet", function () {

        var rating = $(this).rateYo("rating");

        $(this).siblings('.form-group').find('input').attr('value', rating);

    });

});

function get_more_post_single(){

    var id;

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
        success: function (data){

            if(data !== ''){

                $('.single-content').append(data);

                var singleGallery = $('.owl-carousel-main');

                add_img_grid();

                $('.carousel').carousel({interval: false})

            }else{

                $('.dots').remove();

            }


            // window.history.pushState("object or string", "Title", "/page-2");

        },
    })

}

$(window).scroll(function(){

    changeURL();

    var target = $('.footer');
    var targetPos = target.offset().top;
    var winHeight = $(window).height();
    var scrollToElem = targetPos - winHeight;

    var winScrollTop = $(this).scrollTop();

    var page = Number($('.content').attr('data-page'));

    var id = '';

    if(winScrollTop > scrollToElem - 250) {

        $('[data-post-id]').each(function() {

            id = id + $(this).attr('data-post-id') + ',';

        });

        $.ajax({
            type: 'POST',
            url: '/post/more',
            data: 'id='+id,
            async:true,
            dataType: "html",
            cache: false,
            beforeSend: function() {
                $(target).removeClass('footer');
            },
            success: function (data){

                if(data !== ''){

                    $('.single-content').append(data);

                    $(target).addClass('footer');

                    $('.carousel').carousel({interval: false});

                    add_img_grid();

                }else{

                    $('.dots').remove();

                }


                // window.history.pushState("object or string", "Title", "/page-2");

            },
        })
    }

});

function get_modal(object){

    var target = $(object).attr('data-target');
    var id = $(object).attr('data-id');

    $.ajax({
        type: 'POST',
        url: '/post/get',
        data: 'target='+target+'&id='+id,
        async:false,
        dataType: "html",
        cache: false,
        success: function (data){

            $('#info-modal .modal-body').html(data);

            $('#info-modal').modal('show');

            $('#info-modal').on('shown.bs.modal', function (e) {
                $('.chat-wrap').scrollTop(99999999);
            })

            $('.chat-wrap').scrollTop(99999999);

            if(target == 'selfy'){

                $('.aniimated-thumbnials').each(function(i){

                    var singleGallery = $(this);
                    singleGallery.lightGallery();

                });

            }
            if(target == 'call'){

                $('#info-modal').on('shown.bs.modal', function (e) {
                    $("#getcallform-phone").mask("+7(999) 999-9999");
                })

            }

            if(target == 'comment-form'){

                $('#info-modal').on('shown.bs.modal', function (e) {

                    $(".rate").rateYo({
                        rating: 5,
                        fullStar: true
                    });

                    $(".rate").rateYo("option", "onSet", function () {

                        var rating = $(this).rateYo("rating");

                        $(this).siblings('.form-group').find('input').attr('value', rating);

                    });

                })


            }

        },
    })
}