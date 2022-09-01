
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

    $.getScript("https://yastatic.net/share2/share.js", function (data, textStatus, jqxhr) {

    });

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

    var price = $('.first').attr('data-price');
    var national = $('.first').attr('data-national');
    var pol = $('.first').attr('data-pol');
    var ref = $('.first').attr('data-ref');

    var winScrollTop = $(this).scrollTop();

    var page = Number($('.content').attr('data-page'));

    var id = '';

    if(winScrollTop > scrollToElem - 250) {

        $('[data-post-id]').each(function() {

            id = id + $(this).attr('data-post-id') + ',';

        });

        var data = 'price=' + price + '&ref=' + ref + '&pol=' + pol + '&national='+ national +'&id='+id;

        $.ajax({
            type: 'POST',
            url: '/post/more',
            data: data,
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