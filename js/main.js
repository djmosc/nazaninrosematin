;(function($) {

	window.main = {
		w: $(window),
		d: $(document),
		init: function(){

			main.global.init();
			main.header.init();

			if ($(window).width() > 800) {
				main.submenus.init();				
			}			
			main.accordion.init();
			main.frontpage.init();
			main.collection.init();
			main.product.init();

		},

		loaded: function(){
		
		},

		global: {
			init: function(){
				
			}
		},

		body: {
			element: $('body')
		},
		
		header: {
			element: $('#header'),
			init: function(){
				var header = main.header.element,
					menuBtn = $('.menu-btn', header);
					
				menuBtn.on('click', function(e){
					e.preventDefault();
					header.toggleClass('navigation-open');
				});
			}
		},

		submenus: {
			element: $('ul.sub-menu'),
			init: function() {
				var element = main.submenus.element,
					nav = $('#header-navigation');

				if(element.is(":visible")) {
					var height = element.outerHeight(),
						navheight = $('#header-navigation').outerHeight();
					
					nav.height(navheight + height);
				}

			}

		},

		accordion: {
			element: $('#accordion'),
			init: function() {
				var element = main.accordion.element;

				$(".content", element).first().css('display', 'block');

				var link = $('a.trigger', element);

				link.first().addClass('first current');

				link.on('click', function(e) {
					e.preventDefault();
					
					if ($(this).hasClass('current')) {
					    link.removeClass('current first');
						$(".content", element).not(a).slideUp('fast');
					} else {
					    link.removeClass('current first');
					    var a = $(this).attr("href");
						link.removeClass('current');
					    $(this).addClass('current');
					    $(a).slideDown('fast');
					    $(".content", element).not(a).slideUp('fast');						
					}
				});				
			}
		},

		frontpage: {
			element: $('#front-page'),
			init: function(){
				var element = main.frontpage.element;

				if(!element.length) return false;


			}
		},

		collection: {
			element: $('#taxonomy-collection'),
			init: function(){
				var element = main.collection.element;

				if(!element.length) return false;

				var carousel = main.collection.carousel = $('.carousel', element);
				
				carousel.owlCarousel({
					navText: false,
					dots: false,
					nav: true,
					items: 1,
					loop: true,
					center: true,
					autoWidth: true,
					margin: 50
				});
			}
		},

		product: {
			element: $('#single-product'),
			init: function(){
				var element = main.product.element;

				if(!element.length) return false;

				var thumbnails = main.product.thumbnails = $('.thumbnails', element);
				
				thumbnails.owlCarousel({
					navText: false,
					dots: false,
					nav: true,
					items: 1,
					autoWidth: true,
					margin: 10,
					stagePadding: 50
				});
			}
		},

		share: {
			init: function(){
				$('.share-popup-btn').on('click', function(e){
					e.preventDefault();

					var url = $(this).attr('href'),
					width = 640,
					height = 305,
					left = ($(window).width() - width) / 2,
					top = ($(window).height() - height) / 2;

					window.open(url, null,'height='+height+',width='+width+',left='+left+',top='+top+',status=yes,toolbar=no,menubar=no,location=no');
					return false;
				});
			}
		},

		equalHeight: function(){
			if($('.equal-height').length !== 0){
		
				var currTallest = 0,
				currRowStart = 0,
				rowDivs = [],
				topPos = 0;

				$('.equal-height').each(function() {

					var element = $(this);
					topPos = element.position().top;
					if (currRowStart !== topPos) {

						for (var i = 0; i < rowDivs.length ; i++) {
							rowDivs[i].height(currTallest);
						}

						rowDivs.length = 0;
						currRowStart = topPos;
						currTallest = element.height();
						rowDivs.push(element);

					} else {
						rowDivs.push(element);
						currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
					}

					for (var ii = 0 ; ii < rowDivs.length ; ii++) {
						rowDivs[ii].height(currTallest);
					}

				});
			}
		},

		template: {
			parse: function (template, data) {
				return template.replace(/\{([\w\.]*)\}/g, function(str, key) {
					var keys = key.split("."), v = data[keys.shift()];
					for (var i = 0, l = keys.length; i < l; i++) v = v[keys[i]];
					return (typeof v !== "undefined" && v !== null) ? v : "";
				});
			}
		},

		url: {
			parameters: {

				get: function(url, key){
					if(key) {
					   	var params = main.url.parameters.get(url);

					   	return params[key];
		     			
					} else {
			            var values = [], parameter,
			                parameters = url.slice(url.indexOf('?') + 1).split('&');

			            for(var i = 0; i < parameters.length; i++) {
			                parameter = parameters[i].split('=');
			                values.push(parameter[0]);
			                values[parameter[0]] = parameter[1];
			            }
			            return values;
			        }
		        },

		        set: function(url, key, value){
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
		        
		        }
	        }
        }
	};

	$(function(){
		window.main.init();
	});

})(jQuery);

