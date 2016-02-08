<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
include("num2letras.txt");
 setlocale (LC_TIME, "es_ES");
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

//echo $_SESSION['compra']['prov_id'];
$sucursal=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".__($_SESSION['compra']['suc_id'])."' ");
if( $sucursal->num_rows>0) { $sucursal=$sucursal->fetch_object(); }
?>
<!DOCTYPE html>
<html lang="es">
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
<style type="text/css" media="print">
.nover {display:none}
</style>

	<div style="font-size: 12px;line-height: 15px;" class="container" id="impricom">
	<input style="float: left;" type="button" onclick="window.print();" class="nover" value="Imprimir" />
	   <p style="text-align:left"><img style=" width: 130px;"src="<?php echo MEDIA;?>/img/logo.jpg"></p>
	   <h2  style="text-align:center">CONTRATO DE VENTA DE CRÉDITO</h2>	
	   <p style="text-align: right;">TORREÓN COAH. A 13 DE JUNIO DEL 2015</p>
	   <p>
	   		CONTRATO DE COMPRA VENTA CON RESERVA DE DOMINIO DE VEHÍCULO USADO, QUE CELEBRAN POR UNA PARTE EL ING. <b>MAURICIO TORRES NAVA</b>, PROPIETARIO DE LA NEGOCIACIÓN DENOMINADA AUTOS 2000. A QUIEN A LO SUCESIVO SE LE DENOMINARÁ "EL VENDEDOR" Y POR OTRA PARTE <B>FERNANDO VAZQUEZ CASTILLO</B>, QUIEN EN LO SUCESIVO SE LE DENOMINARÁ "EL COMPRADOR" AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLAÚSULAS.
	   </p>
	</div>
	    

</body>
</html>