<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
include("num2letras.txt");
 setlocale (LC_TIME, "es_ES");

if (isset($_GET['ven_id'])) {

	$vent = $sql->Query("SELECT * FROM ventas WHERE ven_id='".__($_GET['ven_id'])."' ");
	if ($vent->num_rows>0) {
		$vent = $vent->fetch_object();

		$sucursal=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".$vent->suc_id."' ");
		if( $sucursal->num_rows>0) { $sucursal=$sucursal->fetch_object(); }

		$cli = $sql->Query("SELECT * FROM clientes WHERE cli_id='".$vent->cli_id."' ");
		if ($cli->num_rows>0) {
			$cli = $cli->fetch_object();
		}

		$veh = $sql->Query("SELECT * FROM vehiculos WHERE ve_id='".$vent->ve_id."' ");
		if ($veh->num_rows>0) {
			$veh = $veh->fetch_object();
		}

		$markas=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$veh->ve_marca."' ");
		if ($markas->num_rows>0) {
			$mark=$markas->fetch_object(); $mark=$mark->ma_nombre;
		}

		$attr = $sql->Query("SELECT * FROM vehiculos_attr WHERE ve_id='".$vent->ve_id."' ");
		if ($attr->num_rows>0) {
			$attr = $attr->fetch_object();
		}

		$color = $sql->Query("SELECT * FROM colores WHERE co_id='".$attr->att_colorext."' ");
		if ($color->num_rows>0) {
			$color = $color->fetch_object();
		}

		$placas=$sql->Query("SELECT * FROM placas WHERE ven_id='".$vent->ven_id."' ");
		if( $placas->num_rows>0) { $placas=$placas->fetch_object(); }
	}

}	
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
  <style type="text/css">
	#datos{width: 500px; margin: 40px auto; }

  </style>
<body> 
<style type="text/css" media="print">
.nover {display:none}
</style>

	<div class="container" id="impricom">
	<input type="button" onclick="window.print();" class="nover" value="Imprimir" />
	    <div class="col-xs-12" id="logcom">
	    	<img src="<?php echo MEDIA; ?>/img/logo.png" >
	    	<p>
	    		COMPRA VENTA Y CONSIGNACIÓN <br>
	    		ING. MAURICIO E. TORRES NAVA<br>
	    		AV. ALLENDE #601 OTE.<br>
	    		ESQ. COMONFORT COL. CENTRO<br>
	    		TORREÓN COAH. (871)2-67-54-76<br>
	    	</p>
	    </div>
	    <p><?php echo $sucursal->suc_ciudad.", ".$sucursal->suc_estado;?>, <?php echo strftime('%d de %B del %Y', strtotime($vent->ven_fecha)); ?>.</p>
	    <br>
	    <h2 id="h2com">CARTA RESPONSIVA DE PLACAS</h2>	
	     <br>
	   	<p>
	   		Que se celebra entre <b>Autos 2000</b> en su carácter de vendedor y por la otra la otra parte <b><?php echo $cli->cli_nombre." ".$cli->cli_apellido;?></b> 
	   		en su carácter de comprador, al tenor de las siguientes:
			Por medio de la presente hacemos constar la venta del automóvil:
			Marca: <b><?php echo $mark;?></b>
			Tipo: <b><?php echo $veh->ve_tipo;?></b>
			Modelo: <b><?php echo $veh->ve_modelo;?></b>
			Color: <b><?php echo $color->co_nombre; ?></b>
			No. Serie: <b><?php echo $attr->att_numserie; ?></b>
			No. Motor: <b><?php echo $attr->att_nummotor; ?></b>
			Placas: <b><?php echo $placas->pla_placas; ?></b>
			con la tarjeta de circulación no. <b><?php echo $placas->pla_circulacion; ?></b>
	   	</p>

	   	<p>
	   		El automóvil antes descrito pasa a ser responsabilidad del comprador, el cual se compromete a regresar las placas y la tarjeta de circulación antes descritas o su respectiva baja, en el tiempo estipulado así como de realizar su cambio de propietario como marca la ley en un plazo no mayor de 15 días naturales a partir de la fecha de compra-venta, y a cumplir con las obligaciones fiscales, civiles o penales propias al automóvil.
	   	</p>
	    
	    <p>
		   
	        <div class="firma" style="float: none;">
		    ________________________________________<br>
		    	<?php echo $cli->cli_nombre." ".$cli->cli_apellido;?>
		    </div>
	    </p>
	</div>

</body>
</html>