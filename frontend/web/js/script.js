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


$('.user-btn').click(function() {

    $('.login').animate({

        left: '0px'

    }, 250);

});

$('.login-icon-close').click(function() {

    $('body').css('overflow' , 'inherit');

    $('.login').animate({

        left: '-120%'

    }, 200);

});

function get_user_menu(){

    $('.login').animate({

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

/**
 * Navigation Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
    'use strict';

    /**
     * Creates the navigation plugin.
     * @class The Navigation Plugin
     * @param {Owl} carousel - The Owl Carousel.
     */
    var Navigation = function(carousel) {
        /**
         * Reference to the core.
         * @protected
         * @type {Owl}
         */
        this._core = carousel;

        /**
         * Indicates whether the plugin is initialized or not.
         * @protected
         * @type {Boolean}
         */
        this._initialized = false;

        /**
         * The current paging indexes.
         * @protected
         * @type {Array}
         */
        this._pages = [];

        /**
         * All DOM elements of the user interface.
         * @protected
         * @type {Object}
         */
        this._controls = {};

        /**
         * Markup for an indicator.
         * @protected
         * @type {Array.<String>}
         */
        this._templates = [];

        /**
         * The carousel element.
         * @type {jQuery}
         */
        this.$element = this._core.$element;

        /**
         * Overridden methods of the carousel.
         * @protected
         * @type {Object}
         */
        this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        };

        /**
         * All event handlers.
         * @protected
         * @type {Object}
         */
        this._handlers = {
            'prepared.owl.carousel': $.proxy(function(e) {
                if (e.namespace && this._core.settings.dotsData) {
                    this._templates.push('<div class="' + this._core.settings.dotClass + '">' +
                        $(e.content).find('[data-dot]').addBack('[data-dot]').attr('data-dot') + '</div>');
                }
            }, this),
            'added.owl.carousel': $.proxy(function(e) {
                if (e.namespace && this._core.settings.dotsData) {
                    this._templates.splice(e.position, 0, this._templates.pop());
                }
            }, this),
            'remove.owl.carousel': $.proxy(function(e) {
                if (e.namespace && this._core.settings.dotsData) {
                    this._templates.splice(e.position, 1);
                }
            }, this),
            'changed.owl.carousel': $.proxy(function(e) {
                if (e.namespace && e.property.name == 'position') {
                    this.draw();
                }
            }, this),
            'initialized.owl.carousel': $.proxy(function(e) {
                if (e.namespace && !this._initialized) {
                    this._core.trigger('initialize', null, 'navigation');
                    this.initialize();
                    this.update();
                    this.draw();
                    this._initialized = true;
                    this._core.trigger('initialized', null, 'navigation');
                }
            }, this),
            'refreshed.owl.carousel': $.proxy(function(e) {
                if (e.namespace && this._initialized) {
                    this._core.trigger('refresh', null, 'navigation');
                    this.update();
                    this.draw();
                    this._core.trigger('refreshed', null, 'navigation');
                }
            }, this)
        };

        // set default options
        this._core.options = $.extend({}, Navigation.Defaults, this._core.options);

        // register event handlers
        this.$element.on(this._handlers);
    };

    /**
     * Default options.
     * @public
     * @todo Rename `slideBy` to `navBy`
     */
    Navigation.Defaults = {
        nav: false,
        navText: [
            '<span aria-label="' + 'Previous' + '">&#x2039;</span>',
            '<span aria-label="' + 'Next' + '">&#x203a;</span>'
        ],
        navSpeed: false,
        navElement: 'button type="button" role="presentation"',
        navContainer: false,
        navContainerClass: 'owl-nav',
        navClass: [
            'owl-prev',
            'owl-next'
        ],
        slideBy: 1,
        dotClass: 'owl-dot',
        dotsClass: 'owl-dots',
        dots: true,
        dotsEach: false,
        dotsData: false,
        dotsSpeed: false,
        dotsContainer: false
    };

    /**
     * Initializes the layout of the plugin and extends the carousel.
     * @protected
     */
    Navigation.prototype.initialize = function() {
        var override,
            settings = this._core.settings;

        // create DOM structure for relative navigation
        this._controls.$relative = (settings.navContainer ? $(settings.navContainer)
            : $('<div>').addClass(settings.navContainerClass).appendTo(this.$element)).addClass('disabled');

        this._controls.$previous = $('<' + settings.navElement + '>')
            .addClass(settings.navClass[0])
            .html(settings.navText[0])
            .prependTo(this._controls.$relative)
            .on('click', $.proxy(function(e) {
                this.prev(settings.navSpeed);
            }, this));
        this._controls.$next = $('<' + settings.navElement + '>')
            .addClass(settings.navClass[1])
            .html(settings.navText[1])
            .appendTo(this._controls.$relative)
            .on('click', $.proxy(function(e) {
                this.next(settings.navSpeed);
            }, this));

        // create DOM structure for absolute navigation
        if (!settings.dotsData) {
            this._templates = [ $('<button role="button">')
                .addClass(settings.dotClass)
                .append($('<span>'))
                .prop('outerHTML') ];
        }

        this._controls.$absolute = (settings.dotsContainer ? $(settings.dotsContainer)
            : $('<div>').addClass(settings.dotsClass).appendTo(this.$element)).addClass('disabled');

        this._controls.$absolute.on('click', 'button', $.proxy(function(e) {
            var index = $(e.target).parent().is(this._controls.$absolute)
                ? $(e.target).index() : $(e.target).parent().index();

            e.preventDefault();

            this.to(index, settings.dotsSpeed);
        }, this));

        /*$el.on('focusin', function() {
            $(document).off(".carousel");

            $(document).on('keydown.carousel', function(e) {
                if(e.keyCode == 37) {
                    $el.trigger('prev.owl')
                }
                if(e.keyCode == 39) {
                    $el.trigger('next.owl')
                }
            });
        });*/

        // override public methods of the carousel
        for (override in this._overrides) {
            this._core[override] = $.proxy(this[override], this);
        }
    };

    /**
     * Destroys the plugin.
     * @protected
     */
    Navigation.prototype.destroy = function() {
        var handler, control, property, override, settings;
        settings = this._core.settings;

        for (handler in this._handlers) {
            this.$element.off(handler, this._handlers[handler]);
        }
        for (control in this._controls) {
            if (control === '$relative' && settings.navContainer) {
                this._controls[control].html('');
            } else {
                this._controls[control].remove();
            }
        }
        for (override in this.overides) {
            this._core[override] = this._overrides[override];
        }
        for (property in Object.getOwnPropertyNames(this)) {
            typeof this[property] != 'function' && (this[property] = null);
        }
    };

    /**
     * Updates the internal state.
     * @protected
     */
    Navigation.prototype.update = function() {
        var i, j, k,
            lower = this._core.clones().length / 2,
            upper = lower + this._core.items().length,
            maximum = this._core.maximum(true),
            settings = this._core.settings,
            size = settings.center || settings.autoWidth || settings.dotsData
                ? 1 : settings.dotsEach || settings.items;

        if (settings.slideBy !== 'page') {
            settings.slideBy = Math.min(settings.slideBy, settings.items);
        }

        if (settings.dots || settings.slideBy == 'page') {
            this._pages = [];

            for (i = lower, j = 0, k = 0; i < upper; i++) {
                if (j >= size || j === 0) {
                    this._pages.push({
                        start: Math.min(maximum, i - lower),
                        end: i - lower + size - 1
                    });
                    if (Math.min(maximum, i - lower) === maximum) {
                        break;
                    }
                    j = 0, ++k;
                }
                j += this._core.mergers(this._core.relative(i));
            }
        }
    };

    /**
     * Draws the user interface.
     * @todo The option `dotsData` wont work.
     * @protected
     */
    Navigation.prototype.draw = function() {
        var difference,
            settings = this._core.settings,
            disabled = this._core.items().length <= settings.items,
            index = this._core.relative(this._core.current()),
            loop = settings.loop || settings.rewind;

        this._controls.$relative.toggleClass('disabled', !settings.nav || disabled);

        if (settings.nav) {
            this._controls.$previous.toggleClass('disabled', !loop && index <= this._core.minimum(true));
            this._controls.$next.toggleClass('disabled', !loop && index >= this._core.maximum(true));
        }

        this._controls.$absolute.toggleClass('disabled', !settings.dots || disabled);

        if (settings.dots) {
            difference = this._pages.length - this._controls.$absolute.children().length;

            if (settings.dotsData && difference !== 0) {
                this._controls.$absolute.html(this._templates.join(''));
            } else if (difference > 0) {
                this._controls.$absolute.append(new Array(difference + 1).join(this._templates[0]));
            } else if (difference < 0) {
                this._controls.$absolute.children().slice(difference).remove();
            }

            this._controls.$absolute.find('.active').removeClass('active');
            this._controls.$absolute.children().eq($.inArray(this.current(), this._pages)).addClass('active');
        }
    };

    /**
     * Extends event data.
     * @protected
     * @param {Event} event - The event object which gets thrown.
     */
    Navigation.prototype.onTrigger = function(event) {
        var settings = this._core.settings;

        event.page = {
            index: $.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: settings && (settings.center || settings.autoWidth || settings.dotsData
                ? 1 : settings.dotsEach || settings.items)
        };
    };

    /**
     * Gets the current page position of the carousel.
     * @protected
     * @returns {Number}
     */
    Navigation.prototype.current = function() {
        var current = this._core.relative(this._core.current());
        return $.grep(this._pages, $.proxy(function(page, index) {
            return page.start <= current && page.end >= current;
        }, this)).pop();
    };

    /**
     * Gets the current succesor/predecessor position.
     * @protected
     * @returns {Number}
     */
    Navigation.prototype.getPosition = function(successor) {
        var position, length,
            settings = this._core.settings;

        if (settings.slideBy == 'page') {
            position = $.inArray(this.current(), this._pages);
            length = this._pages.length;
            successor ? ++position : --position;
            position = this._pages[((position % length) + length) % length].start;
        } else {
            position = this._core.relative(this._core.current());
            length = this._core.items().length;
            successor ? position += settings.slideBy : position -= settings.slideBy;
        }

        return position;
    };

    /**
     * Slides to the next item or page.
     * @public
     * @param {Number} [speed=false] - The time in milliseconds for the transition.
     */
    Navigation.prototype.next = function(speed) {
        $.proxy(this._overrides.to, this._core)(this.getPosition(true), speed);
    };

    /**
     * Slides to the previous item or page.
     * @public
     * @param {Number} [speed=false] - The time in milliseconds for the transition.
     */
    Navigation.prototype.prev = function(speed) {
        $.proxy(this._overrides.to, this._core)(this.getPosition(false), speed);
    };

    /**
     * Slides to the specified item or page.
     * @public
     * @param {Number} position - The position of the item or page.
     * @param {Number} [speed] - The time in milliseconds for the transition.
     * @param {Boolean} [standard=false] - Whether to use the standard behaviour or not.
     */
    Navigation.prototype.to = function(position, speed, standard) {
        var length;

        if (!standard && this._pages.length) {
            length = this._pages.length;
            $.proxy(this._overrides.to, this._core)(this._pages[((position % length) + length) % length].start, speed);
        } else {
            $.proxy(this._overrides.to, this._core)(position, speed);
        }
    };

    $.fn.owlCarousel.Constructor.Plugins.Navigation = Navigation;

})(window.Zepto || window.jQuery, window, document);


$('.owl-carousel-main').owlCarousel({
    margin:10,
    autoplayTimeout:9000,
    autoplay:true,
    nav : true,
    loop: true,
    items:1
})
$('.owl-carousel-bottom').owlCarousel({
    items: 3,
    margin: 16,
    loop: true,
    nav: true,
    navText: ['', ''],
    navElement: 'a href="#"></a',
    responsive: {
        1024: {
            items: 3
        },
        768: {
            items: 3
        },
        0: {
            items: 2
        }
    }
})

function show_otzivi_block(){

    $('.otzivi-block').animate({

        left: '0px'

    }, 250);

}
function close_otzivi_block(){

    $('.otzivi-block').animate({

        left: '-120%'

    }, 250);

}

function show_anket_params_block(){

    $('.anket-params-block').animate({

        left: '0px'

    }, 250);

}
function close_anket_params_block(){

    $('.anket-params-block').animate({

        left: '-120%'

    }, 250);

}

function show_site_price_block(){

    $('.site-price-block').animate({

        left: '0px'

    }, 250);

}
function close_site_price_block(){

    $('.site-price-block').animate({

        left: '-120%'

    }, 250);

}
$( function() {

    var img = $('#bottom-imgs').attr('data-img');

    $('#bottom-imgs').imagesGrid({
        images: img.split(','),
        cells: 2,
        getViewAllText: function(imagesCount) {
            return 'Все ' + imagesCount + '';
        },
        align: true
    });

});

$( function() {

    var img = $('#selfy-imgs').attr('data-img');

    $('#selfy-imgs').imagesGrid({
        images: img.split(','),
        cells: 2,
        getViewAllText: function(imagesCount) {
            return 'Все ' + imagesCount + '';
        },
        align: true
    });

});

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
