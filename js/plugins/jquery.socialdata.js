;(function($) {

	$.extend({
		socialdata: function(options, callback){
			
			var methods = {
				init: function(){
					var processes = [];
					
					for (var i = 0; i < options.networks.length; i++) {
						var name = options.networks[i].name;

						if(networks[name]) {
							var network = networks[name],
								url = network.url,
								id = options.networks[i].id,
								num = (options.networks[i].num) ? options.networks[i].num : 10,
								page = (options.networks[i].page) ? options.networks[i].page : 1;

							url = url.replace('[id]', id);

							if(network.parseXml) url = googleApiUrl.replace('[url]', encodeURIComponent(url));

							url = url.replace('[num]', num);
							url = url.replace('[page]', page);
							processes.push( methods.request(url) );
						}
					}

					if(processes) {
						$.when.apply($, processes).done(methods.loaded);
					}

				},
				request: function(url){
					return $.ajax({type: 'GET', dataType: 'json', contentType: 'application/json; charset=utf-8', url: url/*, success: function(data){
						console.log('success: ', url);
						console.log(data);
					}, error: function(data, two){
						 console.log('error: ', url);
					}*/});
				},
				loaded: function(data){

					var results = methods.unify(arguments);
						results = methods.sortByKey(results, 'timestamp');
					
 					callback(results);
				},
				unify: function(items){
					var data = [];

					for (var i in options.networks) {

						var name = options.networks[i].name;
						if(networks[name]) {
							var network = networks[name],
								item = (options.networks.length > 1) ? items[i][0] : items[i];


							var entries = methods.getObjectData(item, network.parser.entries);
							
							network.parser.name = name;

							for (var j in entries) {
								data.push(methods.parseData(entries[j], network.parser));
							}
						}
					}

					return data;
				},
				parseData: function(data, parser){
					var result = [],
						classes = [];

					delete parser.entries;
					for(var key in parser) {
						var selector = parser[key];
						if(selector) {
							if(selector instanceof Array){
								for(var i in selector) {
									result[key] = methods.getObjectData(data, selector[i]);
								}
							} else {
								result[key] = methods.getObjectData(data, selector);
							}
						}
					}

					if( typeof result.timestamp != 'number') {
						result.timestamp = Date.parse(result.timestamp) / 1000;		
					}
					
					var date = new Date(result.timestamp * 1000);
					result.date = methods.relativeTime(date);

					result.network = parser.name;

					classes.push(result.network);

					switch(parser.name) {
						case 'facebook':

							result.image_url = methods.extractSrc(result.content);

							if(result.image_url.indexOf('fbcdn.net') > -1) {
								result.image_url = result.image_url.replace('_s.', '_o.');
							}

							if(result.image_url.indexOf('external.ak.fbcdn.net/safe_image.php') > -1) {
								result.image_url = methods.getUrlQuery(result.image_url, 'url');
							}
	
							break;
						case 'pinterest':
							result.image_url = methods.extractSrc(result.content);
							break;
						case 'instagram':
							result.image_url = methods.extractSrc(result.content);
							break;
						case 'twitter':
							result.title = result.title.replace(/\bhttp[^ ]+/ig, function(url){
								return '<a href="' + url + '">' + url + '<\/a>';
							});
							break;
						case 'youtube':
							result.id = methods.getUrlQuery(result.url, 'v');
							break;
					}

					result.class = classes.join(' ');

					return result;
				},
				getObjectData: function(object, selectors){
					var data = null;
					
					if(!selectors) return object;

					if(typeof selectors === 'string') {
						selectors = selectors.split('.');
					}

					if(typeof (value = object[selectors[0]]) !== 'undefined') {
						
						if(selectors.length > 1) {
							data = methods.getObjectData(value, selectors.splice(1));
						} else {
							if(value) data = value;
						}
					}

					return data;
				},
				sortByKey: function(array, key) {
					return array.sort(function(a, b) {
						var x = a[key];
						var y = b[key];
						return (parseInt(y) - parseInt(x));});
				},
				relativeTime: function(timestamp) {
					var date = Date.parse(timestamp);
					var relativeTo = (arguments.length > 1) ? arguments[1] : new Date();
					var delta = parseInt((relativeTo.getTime() - date) / 1000);

					if(delta < 60) {
						return 'less than a minute ago';
					} else if(delta < 120) {
						return 'about a minute ago';
					} else if(delta < (45*60)) {
						return (parseInt(delta / 60)).toString() + ' minutes ago';
					} else if(delta < (90*60)) {
						return 'about an hour ago';
					} else if(delta < (24*60*60)) {
						return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
					} else if(delta < (48*60*60)) {
						return '1 day ago';
					} else {
						return (parseInt(delta / 86400)).toString() + ' days ago';
					}
				},
				extractSrc: function(str) {
					var html = $( $.parseHTML( $.trim( str ) ) ),
						src = $('img', html).attr('src');
					return src;
				},
				getUrlQuery: function(url, name) {
					var queryVars = url.split('?');
					if(queryVars[1]) {
						var parameters = queryVars[1].split('&');

						for (var i = 0; i < parameters.length; i++) {
							var parameter = parameters[i].split('=');

							if (parameter[0] === name) {
								return decodeURIComponent(parameter[1]);
							}
						}
					}
					return url;
				}
			},
			networks = {
				facebook: {
					url:'http://www.facebook.com/feeds/page.php?id=[id]&format=rss20',   // <- without pictures
					//url:'http://graph.facebook.com/[id]/photos?limit=[num]',           // <- only pictures (may need an own ajax request)
					//url:'https://www.facebook.com/feeds/page.php?id=[id]&format=json', // <- with pictures (does not work with googleapi)
					parseXml: true,
					parser: {
						entries: 'responseData.feed.entries',
						id: 'id',
						image_url: '',
						video: '',
						title: 'title',
						content: 'content',
						timestamp: 'publishedDate',
						url: 'link'
					}
				},
				tumblr: {
					url:'http://[id].tumblr.com/api/read/json?callback=?&num=[num]',
					parseXml: false,
					parser: {
						entries: 'posts',
						id: 'id',
						image_url: 'photo-url-400',
						video: 'video-source',
						title: ['regular-title', 'photo-caption'],
						content: [ 'conversation-text', 'regular-body', 'link-description', 'regular-title', 'photo-caption', 'video-caption' ],
						timestamp: 'unix-timestamp',
						url: 'url'
					}
				},
				pinterest: {
					url:'https://www.pinterest.com/[id]/feed.rss',
					parseXml: true,
					parser: {
						entries: 'responseData.feed.entries',
						id: 'id',
						image_url: '',
						video: '',
						title:'title',
						content:'content',
						timestamp: 'publishedDate',
						url: 'link'
					}
				},
				instagram: {
					url:'http://ink361.com/feed/user/[id]',
					parseXml: true,
					parser: {
						entries: 'responseData.feed.entries',
						id: 'id',
						image_url: '',
						video: '',
						title:'title',
						content:'content',
						timestamp: 'publishedDate',
						url: 'link'
					}
				},
				twitter: {
					url: baseUrl + '/twitter/[id]?count=[num]',
					parseXml: false,
					parser: {
						entries: '',
						id: 'id',
						title:'text',
						timestamp: 'created_at'	
					}
				},
				youtube: {
					url: 'http://gdata.youtube.com/feeds/base/users/[id]/uploads?alt=rss&v=2',
					parseXml: true,
					parser: {
						entries: 'responseData.feed.entries',
						id: 'id',
						url: 'link',
						title:'title',
						timestamp: 'publishedDate'	
					}
				}
			},
			googleApiUrl = 'http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=[num]&callback=?&q=[url]';

			
			methods.init();

		}
	});

})(jQuery);