(function($){

	$.fn.scroller = function(options) {
		
		var defaults = {
			autoScroll: false,
			scrollAll: false,
			easing: 'easeInOutExpo',
			resize: false,
			nextOnClick: false
		};
		options = $.extend({}, defaults, options);
		
		var scroller = $(this),
			currItem = $('.scroll-item:eq(0)', scroller);
		if($('.scroll-item', scroller).hasClass('current')){
			currItem = $('.scroll-item.current', scroller);
		}

		var speed = 600,
			easing = options.easing,
			canAutoScroll = true,
			canScroll = true,
			firstLoad = true,
			totalItems = $('.scroll-item', scroller).size();
		
		function gotoItem(id, direction){
			var nextItem = $('.scroll-item', scroller).filter('[data-id='+id+']'),
				nextI = nextItem.index(),
				currI = currItem.index(),
				scrollWidth = nextItem.outerWidth(true),
				canScroll = (firstLoad || id !== currItem.data('id'));

			if(canScroll && !$('.scroll-item', scroller).is(':animated')){
				
				canScroll = false;
				var targetX = 0;
				if(options.scrollAll){
					if(currI < nextI){
						targetX = scrollWidth * (nextI - currI);
					} else {
						targetX = -scrollWidth * (currI - nextI);
					}

					if(!firstLoad){
						if(currI < nextI){
							if($.fn.transition){
								$('.scroll-items-container', scroller).stop().transition({left: -targetX}, speed, easing, function(){
									var nextII = nextI - 1,
										nextItemTemp = $('.scroll-item:lt('+nextII+')', scroller);
									$('.scroll-item:last', scroller).after(nextItemTemp);
									$('.scroll-items-container', scroller).css({left: 0 + 'px' });
									nextItemTemp.hide().fadeIn();
									currItem = nextItem;
									canScroll = false;
								});
							} else {
								$('.scroll-items-container', scroller).stop().animate({left: -targetX}, speed, easing, function(){
									var nextII = nextI - 1,
										nextItemTemp = $('.scroll-item:lt('+nextII+')', scroller);
									$('.scroll-item:last', scroller).after(nextItemTemp);
									$('.scroll-items-container', scroller).css({left: 0 + 'px' });
									nextItemTemp.hide().fadeIn();
									currItem = nextItem;
									canScroll = false;
								});	
							}
							
							

							currItem.removeClass('current');
							nextItem.addClass('current');
							
						} else {
							
							$('.scroll-item:first', scroller).before($('.scroll-item:last', scroller));
							$('.scroll-items-container', scroller).css({left: -scrollWidth + 'px' });
							if($.fn.transition){
								$('.scroll-items-container', scroller).stop().transition({left: 0}, speed, easing, function(){
									currItem = nextItem;
									canScroll = false;
								});	
							} else {
								$('.scroll-items-container', scroller).stop().animate({left: 0}, speed, easing, function(){
									currItem = nextItem;
									canScroll = false;
								});	
							}
							

							currItem.removeClass('current');
							nextItem.addClass('current');
							
						}
					} else {
						$('.scroll-item:first', scroller).before($('.scroll-item:last', scroller));
						$('.scroll-items-container', scroller).css({left: 0});
						currItem = nextItem;
						canScroll = false;
					}
				} else {
					if(currI < nextI){
						targetX = scrollWidth;
					} else {
						targetX = -scrollWidth;
					}

					if(direction){
						switch(direction){
							case 'next':
								targetX = scrollWidth;
								break;
							case 'prev':
								targetX = -scrollWidth;
								break;
						}
					}
					if(!firstLoad){
						currItem.css({position: 'absolute'}).animate({'left': -targetX}, speed, easing, function(){
							$(this).removeClass('current').css({position: 'relative'});
						});
						nextItem.css({'left': targetX, position: 'absolute'}).addClass('current').animate({'left': 0}, speed, easing, function(){
							$(this).css({position: 'relative'});
							currItem = nextItem;
							canScroll = false;
						});
					} else {
						nextItem.addClass('current');
						currItem = nextItem;
						canScroll = false;
					}
				}
				var scrollerPagination = $('.scroller-pagination');
				$('li', scrollerPagination).removeClass('current');
				$('li .btn[data-id='+nextItem.data('id')+']', scrollerPagination).parent().addClass('current');
				$('.scroller-mask', scroller).animate({height: nextItem.outerHeight()}, 500, 'easeInOutQuad');;
				scroller.trigger('onChange', [nextItem]);
				
			}
		}
		
		function gotoNextItem(){
			var nextItem = currItem.next();
			if(nextItem.length === 0){
				nextItem = $('.scroll-item:eq(0)', scroller);
			}
			gotoItem(nextItem.data('id'), 'next');
		}

		
		function gotoPrevItem(){
			var prevItem = currItem.prev();
			if(prevItem.length === 0){
				var lastI = totalItems - 1;
				prevItem = $('.scroll-item:eq('+lastI+')', scroller);
			}
			gotoItem(prevItem.data('id'), 'prev');
		}
		
		function init(){
			if(totalItems > 1){
				if(options.scrollAll){
					$('.scroll-item', scroller).hover(function(){
						if($(this).data('id') == currItem.prev().data('id')){
							$('.prev-btn', scroller).addClass('hover');
							currItem.prev().addClass('hover');
						} else if($(this).data('id') == currItem.next().data('id')){
							$('.next-btn', scroller).addClass('hover');
							currItem.next().addClass('hover');
						}
					}, function(){
						$('.prev-btn', scroller).removeClass('hover');
						$('.next-btn', scroller).removeClass('hover');
						$('.scroll-item', scroller).removeClass('hover');
					});
				}


				if(options.nextOnClick) {
					$('.scroll-item', scroller).on('click', function(e){
						e.preventDefault();
						gotoNextItem();	
						return false;
					});
				}

				$('.scroller-pagination .btn', scroller).on('click', function(e){
					e.preventDefault();
					gotoItem($(this).data('id'));
					canAutoScroll = false;
					return false;
				});
				
				$('.prev-btn', scroller).on('click', function(){
					gotoPrevItem()
					canAutoScroll = false;
				});
				$('.next-btn', scroller).on('click', function(){
					gotoNextItem()
					canAutoScroll = false;
				});

				if(options.autoScroll){
					var scrollInterval;
					
					scrollInterval = setInterval(function(){
						if(canAutoScroll) gotoNextItem()
					}, 4000);
				}
				
				gotoItem(currItem.data('id'));
			} else {
				$('.scroller-navigation', scroller).hide();
				//$('.scroller-pagination', scroller).hide();
				gotoItem(currItem.data('id'));
			}

			scroller.bind('refresh', refresh);
			scroller.bind('gotoItem', gotoItemHandler);
			scroller.bind('resizeScroller', resizeScroller);

			$(window).on('load resize', function(){
				resizeScroller();
			});
			

			firstLoad = false;
		}

		function gotoItemHandler(e, id, direction){
			var direction = direction || 'next';
			gotoItem(id, direction);
		}

		function refresh(){
			gotoItem($('.scroll-item:eq(0)', scroller).data('id'));
			scroller.css({height: currItem.outerHeight()});
		}

		function resizeScroller(){
			$('.scroller-mask', scroller).css({height: currItem.outerHeight()}, 500, 'easeInOutQuad');
		}
		
		init();
		return scroller;
	};
})(jQuery);