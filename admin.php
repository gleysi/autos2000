<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
date_default_timezone_set("America/Mexico_City");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Autos2000</title>
    <link href="<?php echo MEDIA; ?>/bs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo MEDIA; ?>/css/estilo.css" rel="stylesheet">
    <script src="<?php echo MEDIA; ?>/js/jquery.min.js"></script>
    <script src="<?php echo MEDIA; ?>/bs/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin.php">Autos 2000</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav">
            <li class="active"><a href="/admin.php">Inicio</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?usuarios">Todos los usuarios</a></li>
                <li><a href="?usuarios&a">Agregar usuario</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sucursales <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?sucursales">Todos las sucursales</a></li>
                <li><a href="?sucursales&a">Agregar sucursal</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compras <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?compras">Todos las compras</a></li>
                <li><a href="?compras&a">Agregar compra</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vehículos <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?car">Todos los vehículos</a></li>
                <li><a href="?car&a">Agregar vehículo</a></li>
                <li><a href="?marca">Todas las Marcas</a></li>
                <li><a href="?marca&a">Agregar Marca</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ventas <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?venta&a">Agregar venta</a></li>
                <li><a href="?finan">Financiamiento</a></li>
              </ul>
            </li>
            <li><a href="http://correo.autos2000.mx" target="_blank">Correo</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a class="navbar-brand" href="#">Bienvenido(a) <?php echo $_SESSION['alias'];?> </a></li>
            <li class="active"><a href="/?logout">Salir</span></a></li>
          </ul>
          
        </div><!--/.nav-collapse -->
    </nav>

    <div class="container">

      <div class="col-xs-12 jumbotron">
      	<?php
        if (isset($_GET['car'])) {
          include_once("vehiculos.php");
        }
        elseif (isset($_GET['venta'])) {
          include_once("venta.php");
        }
        elseif (isset($_GET['compras'])) {
          include_once("compras.php");
        }
        elseif (isset($_GET['sucursales'])) {
          include_once("sucursales.php");
        }
      	elseif (isset($_GET['usuarios'])) {
      		include_once("usuarios.php");
      	}
        elseif (isset($_GET['cartadeposito'])) {
          include_once("cartadeposito.php");
        }
        elseif (isset($_GET['finan'])) {
          include_once("finan.php");
        }
        elseif (isset($_GET['marca'])) {
          include_once("marca.php");
        }
        elseif (isset($_GET['pagos'])) {
          include_once("pagos.php");
        }
        else{
      	    ?>
	         <h1>Administrador</h1>
	         <div class="row" id="iconitos">

              <div class="col-xs-6 col-md-3">
                <a href="?usuarios" class="thumbnail">
                  <img  src="<?php echo MEDIA; ?>/iconos/usuarios.png" >
                  <span class="textoadmin">usuarios</span> 
                </a>
              </div>

              <div class="col-xs-6 col-md-3">
                <a href="?sucursales" class="thumbnail">
                  <img  src="<?php echo MEDIA; ?>/iconos/sucursales.png" >
                  <span class="textoadmin">Sucursales</span> 
                </a>
              </div>

              <div class="col-xs-6 col-md-3">
                <a href="?compras" class="thumbnail">
                  <img  src="<?php echo MEDIA; ?>/iconos/compras.png" >
                  <span class="textoadmin">Compras</span> 
                </a>
              </div>

              <div class="col-xs-6 col-md-3">
                <a href="?car" class="thumbnail">
                  <img  src="<?php echo MEDIA; ?>/iconos/vehiculos.png" >
                  <span class="textoadmin">Vehículos</span> 
                </a>
              </div>

              <div class="col-xs-6 col-md-3">
                <a href="?venta" class="thumbnail">
                  <img  src="<?php echo MEDIA; ?>/iconos/ventas.png" >
                  <span class="textoadmin">Ventas</span> 
                </a>
              </div>

              <div class="col-xs-6 col-md-3">
                <a href="http://correo.autos2000.mx" class="thumbnail" target="_blank">
                  <img  src="<?php echo MEDIA; ?>/iconos/correo.png" >
                  <span class="textoadmin">Correo</span> 
                </a>
              </div>

            </div>
		    <?php
		 }
      	?>
      </div>
    </div> <!-- /container -->

  </body>
</html>
