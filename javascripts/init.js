var jQT = new $.jQTouch({
preloadImages: [
    'stylesheets/apple/img/backButton.png',
    'stylesheets/apple/img/grayButton.png',
    'stylesheets/apple/img/whiteButton.png',
    'stylesheets/apple/img/loading.gif',
    'images/loader_small.gif',
    'images/icons/location.png',
    'images/icons/star.png'
    ],
	formSelector: '.form',
	startupScreen: 'images/startup.png',
	icon: 'images/icon.png',
	addGlossToIcon: false
});

jQuery(function($){
	$("#cep").mask("99999-999",{completed:function(){$(this).blur();getAddress($(this).val());}});
	$("#ceplabel").click(function(){$("#cep").focus()});
	$("#ceprow").click(function(){$("#cep").focus()});
	$("#cep").focus();

	$('#map').bind( 'pageAnimationEnd', function( e, i ) {
		if( i.direction != 'in' ) {
			$("#map_canvas").empty();
			return;
		}
		showMap();
	});
	checkOnlineStatus();
});

