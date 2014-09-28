(function ($) {
    'use strict';

    var defaults = {},
        dataName = 'ajaxPosts',
        AjaxPosts = function (object, options) {
            //set options
            this.element = object;
            this.ready = false;
            this.nextBtn = options.nextBtn;
            this.page = 1;
            this.loading = false;

            this.init();
        },
        init = function (options) {
            var settings = $.extend({}, defaults, options);
            return this.each(function () {
                var element = $(this),
                    ajaxPosts = new AjaxPosts(element, settings);

                element.data(dataName, ajaxPosts);
            });
        },
        callMethod = function (methodName) {
            if (!(methodName in AjaxPosts.prototype)) {
                $.error('Method ' + methodName + ' does not exist on jQuery.ajaxPosts');
            }
            var slicedArguments = Array.prototype.slice.call(arguments, 1);

            return this.each(function () {
                var $element = $(this);
                var ajaxPosts = $element.data(dataName);

                if (!ajaxPosts) {
                    // This element hasn't had ajax posts constructed yet, so skip it
                    return true;
                }
                ajaxPosts[methodName].apply(ajaxPosts, slicedArguments);
            });
        },
        addToUrl = function(url, key, value){
            var regex = new RegExp('(\\?|\\&)'+key+'=.*?(?=(&|$))'),
                qstring = /\?.+$/;

            if (regex.test(url)){
                url = url.replace(regex, '$1'+key+'='+value);
            } else if (qstring.test(url)) {
                url = url + '&'+key+'='+value;
            } else {
                url =  url + '?'+key+'='+value;
            }

            return url;     
        }, 
        getPageNumberFromUrl = function(url) {
            var vars = getUrlVars(url),
                page = vars['page'];


            if(page) return page;

            var ary = url.split('/');

            for(var i = 0; i < ary.length; i++) {
                if(ary[i] == 'page') break;
            }

            return ( typeof ary[i + 1] != 'undefined') ? parseInt(ary[i + 1]) : 1;
        
        },
        getUrlVars = function(url){
            var vars = [], hash,
                hashes = url.slice(url.indexOf('?') + 1).split('&');

            for(var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        updateUrlPageNumber = function(url, page){
            var vars = getUrlVars(url),
                page = parseInt(page);

            if( vars['page'] ) {
                url = url.replace('page='+page, 'page='+ (page + 1) );
            } else {
                url = url.replace('page/'+page, 'page/'+ (page + 1) );
            }

            return url;
        };

    AjaxPosts.prototype = {
        init: function(){
            var instance = this,
                nextBtn = instance.nextBtn;

            nextBtn.text("Load More").on('click', function(e) {
                e.preventDefault();
                instance.load($(this).attr('href'));
            });
        
        },
        load: function(url){
            var instance = this,
                element = instance.element,
                nextBtn = instance.nextBtn,
                page = getPageNumberFromUrl(url);

            if(instance.page != page && !instance.loading) {

                var ajaxUrl = addToUrl(url, 'ajax', 1);
                
                nextBtn.text('loading...');

                instance.loading = true;

                $.ajax({
                    url: ajaxUrl
                }).done(function(html){
                    if(!html) {
                        nextBtn.text('No More to load').attr('disabled', true);
                        return false;
                    }
                    var clone = $(html);

                    if($.fn.imagesLoaded) {
                        clone.hide();
                        element.append(clone);
                        clone.slideDown().imagesLoaded(function(){
                            clone.fadeIn();
                        });
                    } else {
                        element.append(clone);
                    }

                    instance.loading = false;
                    instance.page = page;
                    url = updateUrlPageNumber(url, page);
                    nextBtn.attr('href', url).text('Load More');

                });
            }
        },
        loaded: function(data){
            var html = data;
            
        }
    };
    $.fn.ajaxPosts = function (method) {
        if (typeof method === 'object' || ! method) {
            return init.apply(this, arguments);
        } else {
            return callMethod.apply(this, arguments);
        }
    };

})(jQuery);