<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>TapCep</title>
	<link type="text/css" rel="stylesheet" href="stylesheets/jqtouch.min.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="stylesheets/apple/theme.min.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="stylesheets/tapcep.css" media="screen" />
	<script type="text/javascript" src="javascripts/jquery.1.3.2.min.js"></script>
	<script type="text/javascript" src="javascripts/jqtouch.min.js"></script>
	<script type="text/javascript" src="javascripts/jquery.maskedinput-1.2.2.min.js"></script>
	<script type="text/javascript" src="javascripts/tapcep.js"></script>
	<script type="text/javascript" src="javascripts/init.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body>
	<div id="home" class="current">
		<div class="toolbar">
			<h1>TapCep</h1>
      <a class="button slideup" id="infoButton" href="#about">Sobre</a>
		</div>
			<p id="add-to-home" class="info">
				Adicione este aplicativo ao menu do seu aparelho clicando no ícone [+] da barra inferior.
			</p>
			<ul id="main" class="rounded">
				<li class="cleared" id="ceprow">
					<label for="cep" id="ceplabel">CEP:</label>
					<input id="cep" type="tel" name="cep" class="selectable" />
				</li>
			</ul>
			<ul class="rounded hidden">
				<li class="arrow forward"><a href="#bookmarks"><img src="images/icons/heart.png" alt="" /> Favoritos</a></li>
			</ul>
	</div>
  <div id="about">
		<p class="rounded">
				<a href="http://tapush.com" rel="external" class="subtle"><img src="images/tapush.png" /><br/>
	  		<strong>TapCep 1.0</strong><br/>&copy 2009 Marcos Gurgel</a>
				<br/>
	  		<a href="http://github.com/mgurgel/tapcep" rel="external">http://github.com/mgurgel/tapcep</a>
    </p>
		<p>
			Built with the awesome <a href="http://jqtouch.com" rel="external">jQTouch</a> by David Kaneda<br/>
			Results powered by <a href="http://www.republicavirtual.com.br/cep/" rel="external">República Virtual</a><br/>
			<a href="http://jquery.com/" rel="external">jQuery Javascript Library</a> by John Resig<br/>
			<a href="http://digitalbush.com/projects/masked-input-plugin" rel="external">Masked Input plugin</a> by Josh Bush<br/>
			Icons by <a href="http://glyphish.com" rel="external">Joseph Wain / glyphish.com</a>
		</p>
		<a href="#" class="whiteButton goback indented">Fechar</a>		

  </div>
	<div id="map">
		<div class="toolbar">
			<h1>Mapa</h1>
			<a href="#" class="back">Voltar</a>
		</div>
		<div id="map_canvas"></div>
	</div>
	<div id="bookmarks">
		<div class="toolbar">
			<h1>Favoritos</h1>
			<a href="#" class="back">Voltar</a>
		</div>
		<ul class="rounded">
			<li>Em desenvolvimento</li>
		</ul>
	</div>
</body>
</html>