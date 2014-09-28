;(function ($) {
    'use strict';

    var defaults = {
            itemSelector: '.item',
            maxHeight: 360,
        },
        dataName = 'carousel',
        Carousel = function (object, options) {
            //set global vars
            this.element = object;
            this.options = options;
            this.items = null;
            this.currI = 0;
            this.init();
        },
        init = function (options) {
            var settings = $.extend({}, defaults, options);
            return this.each(function () {
                var element = $(this),
                    carousel = new Carousel(element, settings);

                element.data(dataName, carousel);
            });
        },
        callMethod = function (methodName) {
            if (!(methodName in Carousel.prototype)) {
              $.error('Method ' + methodName + ' does not exist on jQuery.carousel');
            }
            var slicedArguments = Array.prototype.slice.call(arguments, 1);

            return this.each(function () {
                var $element = $(this),
                    carousel = $element.data(dataName);

                if (!carousel) {
                    return true;
                }
                carousel[methodName].apply(carousel, slicedArguments);
            });
        };

    Carousel.prototype = {
        init: function(){
            var instance = this,
                element = instance.element,
                items = instance.items = element.find(this.options.itemSelector),
                navigation = instance.navigation = element.find('.navigation');

            $('.next-btn', navigation).on('click', function(){
                instance.next();
            });

            $('.prev-btn', navigation).on('click', function(){
                instance.prev();
            });

            items.on('enter.item', function(){
               var item = $(this);

               if(!Modernizr.cssanimations) {
                    item.addClass('current');
                    item.trigger('ready.item');
                } else {
                    item.addClass('current enter');
                    item.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
                        item.trigger('ready.item');
                    });
                }
            }).on('ready.item', function(){
                var item = $(this);

                item.removeClass('enter').addClass('ready');

            }).on('leave.item', function(){
                var item = $(this);
                if(!Modernizr.cssanimations) {
                    item.removeClass('enter ready');
                    item.trigger('exit.item');
                } else {
                    item.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
                        item.trigger('exit.item');
                    });
                    item.removeClass('enter ready').addClass('leave');
                }

            }).on('exit.item', function(){
                var item = $(this);

                item.removeClass('current enter ready leave');

            });
        },
        goto: function(i){

            var items = this.items,
                currItem = items.filter(':eq(' + this.currI +')'),
                newItem = items.filter(':eq(' + i +')');

            if(currItem !== newItem) {

                
                if(1 == 1){
                    newItem.trigger('enter.item');
                    newItem.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
                        currItem.trigger('leave.item');
                    });
                    currItem.removeClass('current');
                    
                } else {
                    currItem.one('exit.item', function(){
                        newItem.trigger('enter.item');
                    });

                    currItem.trigger('leave.item');
                }

                this.currI = i;
            }

        },
        next: function(){

            var i = this.currI;

            i++;

            if(i >= this.items.length) i = 0; 

            this.goto(i);

        },
        prev: function(){
            var i = this.currI;

            i--;

            if(i <= 0) i = this.items.length - 1; 

            this.goto(i);
        }
    };
    $.fn.carousel = function (method) {
        if (typeof method === 'object' || ! method) {
            return init.apply(this, arguments);
        } else {
            return callMethod.apply(this, arguments);
        }
    };

})(jQuery);