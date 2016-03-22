<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("num2letras.txt");
 setlocale (LC_TIME, "es_ES");
if (isset($_GET['id'])) {
	$pag_id=__($_GET['id']);
	$numpagare=__($_GET['num']);
	// PAGOS
	$pago = $sql->Query("SELECT * FROM pagos WHERE pag_id='".$pag_id."' ");
	if ($pago->num_rows>0) {
		$pago = $pago->fetch_object();
	
		// PRESUPUESTO
		$pre = $sql->Query("SELECT * FROM presupuesto WHERE pre_id='".$pago->pre_id."' ");
		if ($pre->num_rows>0) {
			$pre = $pre->fetch_object();

			// CLIENTE
			$datos=$sql->Query("SELECT cli_id,cli_nombre,cli_apellido,cli_tel,cli_dom FROM clientes WHERE cli_id='".$pre->cli_id."' ");
			if ($datos->num_rows>0) {
				$datos=$datos->fetch_object();
			}else echo "Cliente inexistente";

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
    <style>.table b{font-size: 12px} .table td{font-size: 14px} .campos td{padding: 3px!important; border-top: 1px solid #000000!Important; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000}</style>
  </head>
<body> 
	<style type="text/css" media="print">
	.nover {display:none}
	
	</style>
	<div class="container" id="impricom">
		<input type="button" onclick="window.print();" class="nover" value="Imprimir" />
		<table class="table ">
			<tr>
				<td colspan=2 rowspan=3 height="60" align="left"><br><img src="http://media.autos2000.mx/img/logo.jpg" width=171 height=54 hspace=4 vspace=4></td>
				<td></td> <td></td> <td></td> <td></td> <td></td>
			</tr>
			<tr>
				<td><b>pagaré</b></td>
				<td align="left" sdnum="1033;0;@"><font size=1 ><?php echo $numpagare." DE ".$pre->pre_nummensualidades;?></font></td>
				<td></td>
				<td>BUENO POR$</td>
				<td align="right" ><b> $<?php echo number_format($pago->pag_pago,2); ?></b></td>
			</tr>
			<tr>
				<td><b>Torreón, Coah.,</b></td>
				<td></td>
				<td align="center" sdval="29" sdnum="1033;"><?php echo strftime('%d', strtotime($pre->pre_fechapagmensualidades));?></td>
				<td align="center"><?php echo strftime('%B', strtotime($pre->pre_fechapagmensualidades));?></td>
				<td align="center" sdval="2015" sdnum="1033;"><?php echo strftime('%Y', strtotime($pre->pre_fechapagmensualidades));?></td>
			</tr>
			<tr>
				<td colspan=4 height="20" align="left">Debe(mos) y pagare(mos) incondicionalmente a la orden de:</td>
				<td colspan=3 align="left"><b>Ing. Mauricio Eduardo Torres Nava</b></td>
			</tr>
			<tr>
				<td height="20" ><font size=1 >En</font></td>
				<td colspan=2 align="center"><b>Cualquier Plaza</b></td>
				<td align="center"><font size=1 >el</font></td>
				<td align="center" sdval="29" sdnum="1033;"><?php echo strftime('%d', strtotime($pago->pag_fecha));?></td>
				<td align="center"><?php echo strftime('%B', strtotime($pago->pag_fecha));?></td>
				<td align="center" sdval="2015" sdnum="1033;"><?php echo strftime('%Y', strtotime($pago->pag_fecha));?></td>
			</tr>
			<tr> <td colspan=7 height="20" align="center"><b>(SON: <?php echo strtoupper(num2letras($pago->pag_pago)); ?>  00/100 M.N.)</b></td> </tr>
			<tr>
				<td colspan=7>
					Valor recibido a mi (nuestra) entera satisfacción. Este Pagaré forma parte del <?php echo $numpagare." al ".$pre->pre_nummensualidades;?> y todos están sujetos a la condición de<br>
					que, al no pagarse cualquiera de ellos a su vencimiento, serán exigibles todos los que le sigan en número, además de los ya <br>
					vencidos, desde la fecha de su vencimiento de este documento hasta el día de su liquidación, causará intereses moratorios - <br>
					del 7% mensual, pagadero en esta ciudad juntamente con el  principal
				</td>
			</tr>
			
		</table>
		<table class="table">
			<tr class="campos">
				<td><b>NOMBRE</b></td>
				<td><?php echo $datos->cli_nombre." ".$datos->cli_apellido; ?></td>
				<td><b>NOMBRE</b></td>
				<td></td>
			</tr>
			<tr class="campos">	
				<td><b>DIRECCION</b></td>
				<td><?php echo $datos->cli_dom;?></td>
				<td><b>DIRECCION</b></td>
				<td></td>
			</tr>
			<tr class="campos">	
				<td><b>POBRACIÓN</b></td>
				<td>Torreón Coahuila</td>
				<td><b>POBRACIÓN</b></td>
				<td></td>
			</tr>
			<tr class="campos">	
				<td><b>TELÉFONO</b></td>
				<td><?php echo $datos->cli_tel;?></td>
				<td><b>TELÉFONO</b></td>
				<td></td>
			</tr>	

			<tr>
				<td colspan="2" align="center" ><br><br><br><br>FIRMA</td>
				<td colspan="2" align="center" ><br><br><br><br>FIRMA</td>
			</tr>

		</table>
	</div>
</body>
</html>