/*	
	Plugin Name: Weather Shortcode
	Description: Weather plugin will show the weather in your city with beautiful icons. Displays shortcode.
	Version: 1.0
	Author: Roman Barbotkin 
*/

	jQuery(document).ready(function($) {

		var location = $('.ms-weather-code').attr('id');
		var wq = "SELECT * FROM weather.forecast WHERE location='" + location + "' AND u='c'";
		var cb = Math.floor((new Date().getTime()) / 1200 / 1000);
		var wu = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent(wq) + '&format=json&_nocache=' + cb;

		window['ms'] = function(data) {
			var info = data.query.results.channel.item.condition;
			var city = data.query.results.channel.location.city;
			var country = data.query.results.channel.location.country;
			$('.ms-icon').addClass('wi-yw-' + info['code']);
			$('#ms-loc').html(city + ", " + country);
			$('#ms-weather').html(info.temp + '<span>' + '&deg; C</span>');
		};

		$.ajax({
			url: wu,
			dataType: 'jsonp',
			cache: true,
			jsonpCallback: 'ms'
		});

	});
