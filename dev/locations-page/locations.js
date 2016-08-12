var init = function() {
	if (window.google && google.maps) {
		initializeMap();
	} else {
		lazyLoadGoogleMap();
	}
};

var initialize = function() {
	var latLng = new google.maps.LatLng(28.601947, -81.200254);
	
	var mapOptions = {
		center: latLng,
		zoom: 10,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true,
		scrollwheel: false,
		draggable: false
	};

	var map = new google.maps.Map(document.getElementById("campus-map"), mapOptions);
	var icon = '/wordpress/main-site/wp-content/uploads/sites/2/2016/08/map-marker.png';

	var homeCampus = new google.maps.Marker({
		position: new google.maps.LatLng(28.602201, -81.200061),
		map: map,
		title: "Home Campus",
		icon: icon
	});

	homeCampus.addListener('click', function() {
		scrollToTarget($('#main-campus'));
	});

	var rosenCampus = new google.maps.Marker({
		position: new google.maps.LatLng(28.428469, -81.442817),
		map: map,
		title: "Rosen College of Hospitality Management",
		icon: icon
	});

	rosenCampus.addListener('click', function() {
		scrollToTarget($('#rosen-campus'));
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
	$.getScript("http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBQtVEuBQkAjfKe1HbdO-In1LgIuu1UEXk")
		.done(function() {
			initializeMap();
		});
};

function initializeMap() {
	initialize();
}

$(document).ready(init);