var current_address, onlineStatusTimeout;

function getAddress(c) {
	showLoader();
	$.ajax({
		type: "GET",
		url: "ajax_cep.php",
		data: {cep: c},
		dataType: "json",
		success: function(d){
			showResults(d);
		}
	});
}

function showResults(d) {
	hideLoader();
	hideInfo();
	if (d.response == "success") {
		
		current_address = d.data.tipo+' '+d.data.logradouro+', '+d.data.bairro+', '+d.data.cidade+', '+d.data.uf+', Brazil';
	
		$line = $('<li>').addClass('result');
		$line.clone().html($('<textarea>').addClass('address').text(d.data.tipo+' '+d.data.logradouro+'\n'+d.data.bairro+'\n'+d.data.cidade+', '+d.data.uf+'\n'+d.data.cep)).appendTo('#main');
		$line.clone().addClass('arrow forward').html($('<a>').attr('href', '#map').html('<img src="images/icons/location.png" /> Mapa')).appendTo('#main');
		$line.clone().addClass('arrow forward').html($('<a>').attr('href', '#bookmarks').html('<img src="images/icons/star.png" /> Adicionar aos Favoritos')).appendTo('#main');
	}
	else {
		current_address = null;
		$('#main').append('<li class="result">O CEP '+d.data.cep+' não foi encontrado.</li>');
		$('#cep').focus();
	}
}

function showLoader() {
	if(!$('#main .loader').size()) {
		$('#main .result').remove();
		$('#main').append('<li class="loader"><img src="images/loader_small.gif" alt="Loading..."/></li>');
	}
}

function hideLoader() {
	$('#main .loader').remove();
}

function hideInfo() {
	$("#add-to-home").remove();
}

function showMap() {
	var geocoder = new google.maps.Geocoder();
	if (geocoder && current_address) {
	  geocoder.geocode( {'address': current_address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
				var map = new google.maps.Map( $('#map_canvas')[0], {
					zoom: 16,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: results[0].geometry.location
				});

				/* 
					Correção para movimentação do mapa
					http://code.google.com/p/jqtouch/issues/detail?id=44&q=maps#c11
				*/ 
				google.maps.event.addListener(map, "dragstart", function(){ hideMapToolbar(); });
				google.maps.event.addListener(map, "drag", function(){ interval = null; });
				google.maps.event.addListener(map, "dragend", function(){ interval = setTimeout(function(){ showMapToolbar(); }, 250); });
				/* */ 
				
	      var marker = new google.maps.Marker({
	          map: map, 
	          position: results[0].geometry.location
	    	});

	  	}
	    else {
	    	alert("Endereço não encontrado: " + status);
	    }
		});
	}
	else {
		alert("Erro ao carregar a Google Maps API.");
	}
}

function checkOnlineStatus() {
	var timeOut = 5000;
	if (navigator.onLine) {
		$("#ceprow").show();
		$("#offline").hide();
	}
	else {
		$("#cep").blur();
		$("#ceprow").hide();
		$("#offline").show();
		timeOut = 1000;
	}
	onlineStatusTimeout = setTimeout(checkOnlineStatus, timeOut);	
}

/* 
	Correção para movimentação do mapa
	http://code.google.com/p/jqtouch/issues/detail?id=44&q=maps#c11
*/ 

function hideMapToolbar(){
	if(!interval) $('.toolbar').fadeOut('fast');
	interval = null;
}

function showMapToolbar(){
	if(interval) {
		var width = $('#map').width();
		$('.toolbar').fadeIn('fast').width(width).height(45);
	}
	interval = null; 
}

