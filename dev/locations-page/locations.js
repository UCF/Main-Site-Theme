var map;

var init = function() {
	if (window.google && google.maps) {
		initializeMap();
	} else {
		lazyLoadGoogleMap();
	}

  if ($.isFunction($.matchHeight)) {
    initializeMatchHeight();
  } else {
    lazyLoadMatchHeight();
  }
};

var initialize = function() {
  var pinImage = new google.maps.MarkerImage("https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%20|FFCC00");

	var latLng = new google.maps.LatLng(28.601947, -81.200254);
	
	var mapOptions = {
		center: latLng,
		zoom: 8,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
		draggable: false
	};

	map = new google.maps.Map(document.getElementById("campus-map"), mapOptions);

  createMarker(
    'Home Campus',
    28.602201,
    -81.200061,
    pinImage,
    '#main-campus'
  );

  createMarker(
    'Rosen College of Hospitality Management',
    28.428469,
    -81.442817,
    pinImage,
    '#rosen-campus'
  );

  createMarker(
    'Regional Campuses: Altamonte Springs',
    28.646578,
    -81.416092,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Cocoa',
    28.383541,
    -80.758191,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Daytona Beach',
    29.203289,
    -81.049823,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Leesburg',
    28.829147,
    -81.797152,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Ocala',
    29.165581,
    -82.178506,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Palm Bay',
    27.993328,
    -80.630371,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Sanford/Lake Mary',
    28.743735,
    -81.305565,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: South Lake',
    28.551034,
    -81.708312,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Valencia East',
    28.553338,
    -81.250908,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Valencia Osceola',
    28.305638,
    -81.380999,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'Regional Campuses: Valencia West',
    28.523881,
    -81.463834,
    pinImage,
    '#regional-campuses'
  );

  createMarker(
    'College of Medicine',
    28.367046, 
    -81.280181,
    pinImage,
    '#college-of-medicine'
  );

  createMarker(
    'Downtown UCF',
    28.548199,
    -81.385640,
    pinImage,
    '#downtown'
  );
};

var createMarker = function(title, lat, lng, icon, target) {
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(lat, lng),
    map: map,
    title: title,
    icon: icon
  });

  var infoWindow = new google.maps.InfoWindow({
    content: '<p class="location-text">' + title + '</p>'
  });

  marker.addListener('mouseover', function() {
    infoWindow.open(map, marker);
  });

  marker.addListener('mouseout', function() {
    infoWindow.close();
  });

  marker.addListener('click', function() {
    scrollToTarget($(target));
  });
};

var scrollToTarget = function($target) {
	if ($target.length) {
		$('html, body').animate({
			scrollTop: $target.offset().top
		}, 750);
	}
};

var lazyLoadGoogleMap = function() {
	$.getScript("https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBQtVEuBQkAjfKe1HbdO-In1LgIuu1UEXk")
		.done(function() {
			initializeMap();
		});
};

var lazyLoadMatchHeight = function() {
  $.getScript("https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js")
    .done(function() {
      initializeMatchHeight();
    });
};

function initializeMap() {
	initialize();
}

function initializeMatchHeight() {
  $('.campus-card').matchHeight();

  $(window).on('resize', function() {
    $('.campus-card').matchHeight();
  });
}

$(document).ready(init);
