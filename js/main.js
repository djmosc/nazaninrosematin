;(function($) {

	window.main = {
		w: $(window),
		d: $(document),
		init: function(){
			
			main.global.init();
			main.carousel.init();
			main.header.init();
			main.widgets.init();
			main.frontpage.init();
			main.city.init();
			main.index.init();
			main.single.init();
			main.press.init();
			main.category.init();
			main.closet.init();
			main.share.init();

		},

		loaded: function(){
		
		},

		global: {
			init: function(){
				if( $.fn.lazyload ) {
					$('img[data-src]').lazyload({
						data_attribute: 'src',
						effect : 'fadeIn',
						threshold: 400
					});
				}

				$('.print-btn').on('click', function(e) {
					e.preventDefault();
					window.print();
				});

				$('#back-to-top .up-btn').on('click', function(e){
					e.preventDefault();
					$('html, body').animate({scrollTop: 0});
				});

				main.d.on('click', '.scroll-to-btn', function(e){
					var btn = $(this),
						href = btn.attr('href'),
						location = $(href);

		 			if( location.length ) {
		 				e.preventDefault();
		 				$('html, body').animate({scrollTop: location.offset().top - 200});
			 		}
				});

				$('.redirect-dropdown').on('change', function(e){
					e.preventDefault();
					window.location.href = $(this).val();
				});
			}
		},

		body: {
			element: $('body')
		},
		
		carousel: {
			element: $('#carousel'),
			init: function(){
				var element = main.carousel.element;

				if(!element.length) return false;

				var w = main.w,
					d = main.d,
					header = main.header.element,
					downBtn = $('.scroll-down-btn', element);

				element.flexslider({
					prevText: '',
					nextText: '',
					controlNav: true,
					animation: 'fade',
					animationSpeed: 1500,
					animationLoop: true,
					slideshow: true,
					directionNav: false
				});

				w.on('scroll', function(){
					var top = d.scrollTop();
					if(top >= w.height()) {
						main.header.element.css({marginTop: 0});
						main.carousel.element.remove();
						d.scrollTop(0);
						w.off('scroll');
					}
				}).on('resize', function(){
					if (! Modernizr.cssvhunit) main.header.element.css({marginTop: w.height()});
				}).trigger('resize');

				downBtn.on('click', function(){
					$('html, body').animate({scrollTop: w.height()}, 1000);
				});
			}
		},

		header: {
			element: $('#header'),
			init: function(){
				var header = main.header.element;
					menuBtn = $('.menu-btn', header),
					searchBtn = $('> .bottom .search-btn', header),
					searchForm = $('.search-form', header);

				menuBtn.on('click', function(e){
					e.preventDefault();
					header.toggleClass('navigation-open');
				});

				searchBtn.on('click', function(e){
					e.preventDefault();
					header.toggleClass('search-open');
					if(header.hasClass('search-open')) {
						$('.field', searchForm).focus();
					}
				});

			}
		},

		widgets: {
			init: function(){
				
				main.widgets.products.init();

				main.widgets.advert.init();
			
			},
			products: {
				init: function(){
					var widgets = main.widgets,
						widget = $('.widget_products', widgets);

					if(!widget.length) return false;
					
					var options = {
						prevText: '',
						nextText: '',
						controlNav: false,
						animation: 'slide',
						animationSpeed: 400,
						animationLoop: true,
						slideshow: false
					};
					
					$('.flexslider', widget).flexslider(options);

				}
			},
			advert: {
				element: $('.widget_advert'),
				init: function(){
					var element = main.widgets.advert.element;

					if( !element.length ) return false;

					element.on('advert.load', function(e, orientation){
						var advert = $(this),
							img = advert.find('img'),
							src = img.data('src-' + orientation);

						if(src) img.attr('src', src);
					});

				}
			}
		},

		frontpage: {
			element: $('#front-page'),
			init: function(){
				var element = main.frontpage.element;

				if(!element.length) return false;

				var size = main.frontpage.size;
				
				main.w.on('resize', main.frontpage.resize).trigger('resize');
				//
			},
			resize: function(){
				if(Modernizr.mq('only all and (max-width: 800px)') && main.frontpage.size !== 'small') {
					main.widgets.advert.element.trigger('advert.load', 'landscape');
					main.frontpage.size = 'small';
				} else if(Modernizr.mq('only all and (min-width: 800px)') && main.frontpage.size !== 'big') {
					main.frontpage.size = 'big';
					main.widgets.advert.element.trigger('advert.load', 'portrait');
				}
			}
		},

		index: {
			element: $('#index'),
			init: function(){
				var element = main.index.element;

				if(!element.length) return false;

				var form = main.index.form = $('.filters form', element),
					category = $('.category', form),
					tag = $('.tag', form),
					date = $('.date', form),
					posts = $('.posts', element),
					currMonth = main.url.parameters.get(window.location.href, 'm');

				category.on('change', function(){
					form.submit();
				});

				tag.on('change', function(){
					form.submit();
				});

				date.find('option').each(function(){
					var option = $(this),
						value = option.val(),
						month = main.url.parameters.get(value, 'm');

					if(month) {
						option.val(month);

						if(month == currMonth) option.attr('selected', 'selected');
					}

				});

				date.on('change', function(){
					form.submit();
				});


				

				if( $.fn.ajaxPosts ) {
					var pagination = $('.pagination', element),
						nextBtn = $('.next-btn', pagination);

					posts.ajaxPosts({
						nextBtn: nextBtn
					});
				}
				main.single.shopthepost.init();
			}
		},

		single: {
			element: $('#single'),
			init: function(){
				var element = main.single.element;

				if(!element.length) return false;
				
				main.single.locations.init();
				main.single.shopthepost.init();
				main.single.content.init();
			},
			locations: {
				element: $('#single .post-locations'),
				init: function() {
					var element = main.single.locations.element;

					if(!element.length) return false;


					main.map.init();

					$('a.location-btn', main.single.element).on('click', function(e) {
						e.preventDefault();
						var id = $(this).data('id'),
							marker = main.map.marker.get(id);

						main.map.infowindow.open(marker);

						$('html, body').animate({scrollTop: ( main.single.locations.element.offset().top) - (( main.w.height() / 2) - (main.single.locations.element.height() / 2)) });
					});
				},

				goto: function(id){
					var location = $('#location-' + id);

		 			if( location.length ) {
		 				$('html, body').animate({scrollTop: location.offset().top - 20});
			 		}
				}
			},

			shopthepost: {
				element: $('.shop-the-post'),
				init: function(){
					var element = main.single.shopthepost.element

					if(!element.length) return false;

					element.each(function(){
						var el = $(this),
							id = el.data('id'),
							url = 'http://widgets.rewardstyle.com/stps/'+id+'.html .stp-slide > *';
							
						el.load(url);
					});
				}
			},

			content: {
				element: $('.content'),
				init: function(){
					var element = main.single.content.element;

					if( !element.length) return false;

					$('iframe', element).wrap('<div class="video-container"></div>');
				}
			}
		},

		city: {
			element: $('#taxonomy-city'),
			init: function(){
				var element = main.city.element;

				if(!element.length) return false;
				
				main.map.init();


				var locations = $('.locations > .inner', element);
				locations.imagesLoaded(function(){
					locations.masonry();
				});

				$('a.location-btn', element).on('click', function(e) {
					e.preventDefault();
					var id = $(this).data('id'),
						marker = main.map.marker.get(id);

					main.map.infowindow.open(marker);

					$('html, body').animate({scrollTop: ( main.city.map.element.offset().top) - (( main.w.height() / 2) - (main.city.map.element.height() / 2)) });
				});
			},

			map: {
				element: $('.city-map')
			}
		},	

		press: {
			init: function(){
				main.press.archive.init();
			},
			archive: {
				element: $('#archive-press-release'),
				init: function(){
					var element = main.press.archive.element;

					if(!element.length) return false;

					var posts = $('.posts', element),
						pagination = $('.pagination', element),
						nextBtn = $('.next-btn', pagination),
						btns = $('.post-btn', element);

					if( nextBtn.length ) {
						posts.ajaxPosts({
							nextBtn: nextBtn
						});

						// main.d.on('click', btns, function(e){
						// 	e.preventDefault();
						// });
					}					
				}
			}
		},
		category: {
			element: $('#template-category'),
			init: function(){
				var element = main.category.element;

				if(!element.length) return;

				main.category.map.init();
			},
			map: {
				element: $('.continents-map'),
				init: function(){
					var element = main.category.map.element;

					if(!element.length) return false;
					
					element.cssMap({'size' : 960});			
				}
			}
		},

		closet: {
			element: $('#template-closet'),
			init: function(){
				var element = main.closet.element;

				if(!element.length) return false;

				var products = $('.rs-products', element),
					folder = $('.folder', element),
					pagination = $('.pagination', element),
					nextBtn = $('.next-btn', pagination);

				folder.on('change', function(){
					window.location.href = $(this).val();
				});

				if( nextBtn.length ) {
					products.ajaxPosts({
						nextBtn: nextBtn
					});
				}					
			}
		},

		map: {
			element: $('.google-map'),
			init: function(){
				var element = main.map.element;

				if(!element.length) return false;

				var markers = element.find('.marker');
					
				// vars
				var args = {
					zoom		: 16,
					center		: new google.maps.LatLng(0, 0),
					mapTypeId	: google.maps.MapTypeId.ROADMAP
				};
			 
				// create map	        	
				var map = main.map.object = new google.maps.Map( element[0], args);
			 
				// add a markers reference
				map.markers = [];
			 
				// add markers
				markers.each(function(){
			 	
			    	main.map.marker.add( $(this), map );
			 
				});
			 
				// center map
				main.map.center();
			},
			center: function( map ) {

				// vars
				var bounds = new google.maps.LatLngBounds(),
					map = main.map.object;

				// // loop through all markers and create bounds
				$.each( map.markers, function( i, marker ){
			 
					var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
									 
					bounds.extend( latlng );
			 
				});
			 
				// only 1 marker?
				if( map.markers.length == 1 ) {
					// set center of map
				    map.setCenter( bounds.getCenter() );
				    map.setZoom( 16 );
				} else {
					// fit to bounds
					map.fitBounds( bounds );
				}
			},

			marker: {
				add: function(element, map){
					// var
					var latlng = new google.maps.LatLng( element.attr('data-lat'), element.attr('data-lng') );
				 
					// create marker
					var marker = new google.maps.Marker({
						position	: latlng,
						map			: map
					});

					marker.id = element.data('id');
				 	
					
					// if marker contains HTML, add it to an infoWindow
					if( element.html() ) {
						// create info window
						var infowindow = new google.maps.InfoWindow({
							content: element.html()
						});

						marker.infowindow = infowindow;

						// show info window when marker is clicked
						google.maps.event.addListener(marker, 'click', function() {
							main.map.infowindow.open(marker);
						});
					} else {
						google.maps.event.addListener(marker, 'click', function() {
				 			main.single.locations.goto(element.data('id'));
						});
					}

					// add to array
					map.markers.push( marker );
				 
				},
				get: function(id){
					var marker = null;
					
					$.each(main.map.object.markers, function(i, m){
						if(id == m.id) marker = m;
					});

					return marker;
				}
			},

			infowindow: {
				open: function(marker){
					if(marker && marker.infowindow) {
						var infowindow = marker.infowindow;

						$.each(main.map.object.markers, function(e, m){
							if( m.infowindow) m.infowindow.close();
						});

						infowindow.open(marker.getMap(), marker );
					}
				}
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

