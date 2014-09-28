!function($){window.main={w:$(window),d:$(document),init:function(){main.global.init(),main.carousel.init(),main.header.init(),main.widgets.init(),main.frontpage.init(),main.city.init(),main.index.init(),main.single.init(),main.press.init(),main.category.init(),main.closet.init(),main.share.init()},loaded:function(){},global:{init:function(){$.fn.lazyload&&$("img[data-src]").lazyload({data_attribute:"src",effect:"fadeIn",threshold:400}),$(".print-btn").on("click",function(n){n.preventDefault(),window.print()}),$("#back-to-top .up-btn").on("click",function(n){n.preventDefault(),$("html, body").animate({scrollTop:0})}),main.d.on("click",".scroll-to-btn",function(n){var e=$(this),t=e.attr("href"),i=$(t);i.length&&(n.preventDefault(),$("html, body").animate({scrollTop:i.offset().top-200}))}),$(".redirect-dropdown").on("change",function(n){n.preventDefault(),window.location.href=$(this).val()})}},body:{element:$("body")},carousel:{element:$("#carousel"),init:function(){var n=main.carousel.element;if(!n.length)return!1;var e=main.w,t=main.d,i=main.header.element,a=$(".scroll-down-btn",n);n.flexslider({prevText:"",nextText:"",controlNav:!0,animation:"fade",animationSpeed:1500,animationLoop:!0,slideshow:!0,directionNav:!1}),e.on("scroll",function(){var n=t.scrollTop();n>=e.height()&&(main.header.element.css({marginTop:0}),main.carousel.element.remove(),t.scrollTop(0),e.off("scroll"))}).on("resize",function(){Modernizr.cssvhunit||main.header.element.css({marginTop:e.height()})}).trigger("resize"),a.on("click",function(){$("html, body").animate({scrollTop:e.height()},1e3)})}},header:{element:$("#header"),init:function(){var n=main.header.element;menuBtn=$(".menu-btn",n),menuBtn.on("click",function(e){e.preventDefault(),n.toggleClass("navigation-open")})}},widgets:{init:function(){main.widgets.products.init(),main.widgets.advert.init()},products:{init:function(){var n=main.widgets,e=$(".widget_products",n);if(!e.length)return!1;var t={prevText:"",nextText:"",controlNav:!1,animation:"slide",animationSpeed:400,animationLoop:!0,slideshow:!1};$(".flexslider",e).flexslider(t)}},advert:{element:$(".widget_advert"),init:function(){var n=main.widgets.advert.element;return n.length?void n.on("advert.load",function(n,e){var t=$(this),i=t.find("img"),a=i.data("src-"+e);a&&i.attr("src",a)}):!1}}},frontpage:{element:$("#front-page"),init:function(){var n=main.frontpage.element;if(!n.length)return!1;var e=main.frontpage.size;main.w.on("resize",main.frontpage.resize).trigger("resize")},resize:function(){Modernizr.mq("only all and (max-width: 800px)")&&"small"!==main.frontpage.size?(main.widgets.advert.element.trigger("advert.load","landscape"),main.frontpage.size="small"):Modernizr.mq("only all and (min-width: 800px)")&&"big"!==main.frontpage.size&&(main.frontpage.size="big",main.widgets.advert.element.trigger("advert.load","portrait"))}},index:{element:$("#index"),init:function(){var n=main.index.element;if(!n.length)return!1;var e=main.index.form=$(".filters form",n),t=$(".category",e),i=$(".tag",e),a=$(".date",e),o=$(".posts",n),r=main.url.parameters.get(window.location.href,"m");if(t.on("change",function(){e.submit()}),i.on("change",function(){e.submit()}),a.find("option").each(function(){var n=$(this),e=n.val(),t=main.url.parameters.get(e,"m");t&&(n.val(t),t==r&&n.attr("selected","selected"))}),a.on("change",function(){e.submit()}),$.fn.ajaxPosts){var l=$(".pagination",n),m=$(".next-btn",l);o.ajaxPosts({nextBtn:m})}main.single.shopthepost.init()}},single:{element:$("#single"),init:function(){var n=main.single.element;return n.length?(main.single.locations.init(),main.single.shopthepost.init(),void main.single.content.init()):!1},locations:{element:$("#single .post-locations"),init:function(){var n=main.single.locations.element;return n.length?(main.map.init(),void $("a.location-btn",main.single.element).on("click",function(n){n.preventDefault();var e=$(this).data("id"),t=main.map.marker.get(e);main.map.infowindow.open(t),$("html, body").animate({scrollTop:main.single.locations.element.offset().top-(main.w.height()/2-main.single.locations.element.height()/2)})})):!1},"goto":function(n){var e=$("#location-"+n);e.length&&$("html, body").animate({scrollTop:e.offset().top-20})}},shopthepost:{element:$(".shop-the-post"),init:function(){var n=main.single.shopthepost.element;return n.length?void n.each(function(){var n=$(this),e=n.data("id"),t="http://widgets.rewardstyle.com/stps/"+e+".html .stp-slide > *";n.load(t)}):!1}},content:{element:$(".content"),init:function(){var n=main.single.content.element;return n.length?void $("iframe",n).wrap('<div class="video-container"></div>'):!1}}},city:{element:$("#taxonomy-city"),init:function(){var n=main.city.element;if(!n.length)return!1;main.map.init();var e=$(".locations > .inner",n);e.imagesLoaded(function(){e.masonry()}),$("a.location-btn",n).on("click",function(n){n.preventDefault();var e=$(this).data("id"),t=main.map.marker.get(e);main.map.infowindow.open(t),$("html, body").animate({scrollTop:main.city.map.element.offset().top-(main.w.height()/2-main.city.map.element.height()/2)})})},map:{element:$(".city-map")}},press:{init:function(){main.press.archive.init()},archive:{element:$("#archive-press-release"),init:function(){var n=main.press.archive.element;if(!n.length)return!1;var e=$(".posts",n),t=$(".pagination",n),i=$(".next-btn",t),a=$(".post-btn",n);i.length&&e.ajaxPosts({nextBtn:i})}}},category:{element:$("#template-category"),init:function(){var n=main.category.element;n.length&&main.category.map.init()},map:{element:$(".continents-map"),init:function(){var n=main.category.map.element;return n.length?void n.cssMap({size:960}):!1}}},closet:{element:$("#template-closet"),init:function(){var n=main.closet.element;if(!n.length)return!1;var e=$(".rs-products",n),t=$(".folder",n),i=$(".pagination",n),a=$(".next-btn",i);t.on("change",function(){window.location.href=$(this).val()}),a.length&&e.ajaxPosts({nextBtn:a})}},map:{element:$(".google-map"),init:function(){var n=main.map.element;if(!n.length)return!1;var e=n.find(".marker"),t={zoom:16,center:new google.maps.LatLng(0,0),mapTypeId:google.maps.MapTypeId.ROADMAP},i=main.map.object=new google.maps.Map(n[0],t);i.markers=[],e.each(function(){main.map.marker.add($(this),i)}),main.map.center()},center:function(n){var e=new google.maps.LatLngBounds,n=main.map.object;$.each(n.markers,function(n,t){var i=new google.maps.LatLng(t.position.lat(),t.position.lng());e.extend(i)}),1==n.markers.length?(n.setCenter(e.getCenter()),n.setZoom(16)):n.fitBounds(e)},marker:{add:function(n,e){var t=new google.maps.LatLng(n.attr("data-lat"),n.attr("data-lng")),i=new google.maps.Marker({position:t,map:e});if(i.id=n.data("id"),n.html()){var a=new google.maps.InfoWindow({content:n.html()});i.infowindow=a,google.maps.event.addListener(i,"click",function(){main.map.infowindow.open(i)})}else google.maps.event.addListener(i,"click",function(){main.single.locations.goto(n.data("id"))});e.markers.push(i)},get:function(n){var e=null;return $.each(main.map.object.markers,function(t,i){n==i.id&&(e=i)}),e}},infowindow:{open:function(n){if(n&&n.infowindow){var e=n.infowindow;$.each(main.map.object.markers,function(n,e){e.infowindow&&e.infowindow.close()}),e.open(n.getMap(),n)}}}},share:{init:function(){$(".share-popup-btn").on("click",function(n){n.preventDefault();var e=$(this).attr("href"),t=640,i=305,a=($(window).width()-t)/2,o=($(window).height()-i)/2;return window.open(e,null,"height="+i+",width="+t+",left="+a+",top="+o+",status=yes,toolbar=no,menubar=no,location=no"),!1})}},equalHeight:function(){if(0!==$(".equal-height").length){var n=0,e=0,t=[],i=0;$(".equal-height").each(function(){var a=$(this);if(i=a.position().top,e!==i){for(var o=0;o<t.length;o++)t[o].height(n);t.length=0,e=i,n=a.height(),t.push(a)}else t.push(a),n=n<a.height()?a.height():n;for(var r=0;r<t.length;r++)t[r].height(n)})}},template:{parse:function(n,e){return n.replace(/\{([\w\.]*)\}/g,function(n,t){for(var i=t.split("."),a=e[i.shift()],o=0,r=i.length;r>o;o++)a=a[i[o]];return"undefined"!=typeof a&&null!==a?a:""})}},url:{parameters:{get:function(n,e){if(e){var t=main.url.parameters.get(n);return t[e]}for(var i=[],a,o=n.slice(n.indexOf("?")+1).split("&"),r=0;r<o.length;r++)a=o[r].split("="),i.push(a[0]),i[a[0]]=a[1];return i},set:function(n,e,t){var i=new RegExp("(\\?|\\&)"+e+"=.*?(?=(&|$))"),a=/\?.+$/;return n=i.test(n)?n.replace(i,"$1"+e+"="+t):a.test(n)?n+"&"+e+"="+t:n+"?"+e+"="+t}}}},$(function(){window.main.init()})}(jQuery);