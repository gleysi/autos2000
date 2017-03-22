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

		$cli = $sql->Query("SELECT * FROM clientes WHERE cli_id='".$vent->cli_id."' ");
		if ($cli->num_rows>0) {
			$cli = $cli->fetch_object();
		}

		$av = $sql->Query("SELECT * FROM avales WHERE av_id='".$vent->av_id."' ");
		if ($av->num_rows>0) {
			$av = $av->fetch_object();
		}

		// AVAL dos
		$aval_dos=$sql->Query("SELECT * FROM avales WHERE av_id='".$vent->av_iddos."' ");
		if ($aval_dos->num_rows>0) {
			$aval_dos=$aval_dos->fetch_object();
		}else echo "Aval dos inexistente";

		$uni = $sql->Query("SELECT * FROM unidad_deposito WHERE ven_id='".$vent->ven_id."' ");
		if ($uni->num_rows>0) {
			$uni = $uni->fetch_object();
		}

		$color = $sql->Query("SELECT * FROM colores WHERE co_id='".$uni->und_color."' ");
		if ($color->num_rows>0) {
			$color = $color->fetch_object();
		}
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
	    <h2 id="h2com">CONVENIO DE  UNIDAD EN DEPÓSITO</h2>	
	    
	   	<table id="datos">
	   		<tr>
	   			<td>COMPRADOR</td>
	   			<td><?php echo $cli->cli_nombre." ".$cli->cli_apellido;?></td>
	   		</tr>
	   		<tr>
	   			<td>AVAL</td>
	   			<td><?php echo $av->av_nombre." ".$av->av_apellidos;?></td>
	   		</tr>
	   		<?php
	   		if ($vent->av_iddos!=0) {
	   			?>
	   			<tr>
		   			<td>SEGUNDO AVAL</td>
		   			<td><?php echo $aval_dos->av_nombre." ".$aval_dos->av_apellidos;?></td>
		   		</tr>
	   			<?php
	   		}
	   		?>
	   		<tr>
	   			<td>VENDEDOR</td>
	   			<td>Mauricio Eduardo Torres Nava</td>
	   		</tr>
	   	</table>

	   	<p>
	   		Con esta fecha y por así convenir a nuestros intereses, entrego voluntariamente al ING. MAURICIO E.  TORRES NAVA, el automóvil marca <b><?php echo $uni->und_marca;?></b>,  tipo: <b><?php echo $uni->und_tipo;?></b> modelo <b><?php echo $uni->und_modelo;?></b>  color <b><?php echo $color->co_nombre;?> </b> con Nº de serie:­­­­­­­­­­­­­­­­­­­­­­­­ <b><?php echo $uni->und_numserie;?> </b> y motor <b><?php echo $uni->und_motor;?></b> en las condiciones en que se encuentra para su revisión posterior.
	   	</p>

	   	<p>
	   		Pues dado el atraso que presento en mis pagos, entrego la unidad en calidad de depósito hasta ponerme al corriente en los mismos.
	   	</p>

	   	<p>
	   		Por lo que solicito se me otorgue un plazo no mayor  a  30 (Treinta) días para resolver mi situación económica, de lo contrario daremos por cancelada la operación de compra-venta según el contrato celebrado el día <?php echo strftime('%d de %B del %Y', strtotime($vent->ven_fecha)); ?>.
	   	</p>
	    
	    <p>Se firma el presente convenio estando ambas partes de acuerdo.</p>
	    <p>
		    <div class="firma">
		    ________________________________________<br>
		    	ING. MAURICIO E. TORRES NAVA
		    </div>
	        <div class="firma">
		    ________________________________________<br>
		    	<?php echo $cli->cli_nombre." ".$cli->cli_apellido;?>
		    </div>
	    </p>
	</div>

</body>
</html>