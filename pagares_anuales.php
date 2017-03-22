<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("num2letras.txt");
 setlocale (LC_TIME, "es_ES");
if (isset($_GET['ven_id'])) {
	
	$ven_id=__($_GET['ven_id']);
		
		// VENTA
		$venta = $sql->Query("SELECT * FROM ventas WHERE ven_id='".$ven_id."' ");
		if ($venta->num_rows>0) {
			$venta = $venta->fetch_object();

			// SUCURSAL
			$sucursal = $sql->Query("SELECT * FROM sucursales WHERE suc_id='".$venta->suc_id."' ");
			if ($sucursal->num_rows>0) {
				$suc = $sucursal->fetch_object();
			}
		}

		// PRESUPUESTO
		$pre = $sql->Query("SELECT * FROM presupuesto WHERE ven_id='".$ven_id."' ");
		if ($pre->num_rows>0) {
			$pre = $pre->fetch_object();

			// CLIENTE
			$datos=$sql->Query("SELECT * FROM clientes WHERE cli_id='".$pre->cli_id."' ");
			if ($datos->num_rows>0) {
				$datos=$datos->fetch_object();
			}else echo "Cliente inexistente";

			// AVAL
			$aval=$sql->Query("SELECT * FROM avales WHERE av_id='".$venta->av_id."' ");
			if ($aval->num_rows>0) {
				$aval=$aval->fetch_object();
			}else echo "Aval inexistente";

			// AVAL dos
			$aval_dos=$sql->Query("SELECT * FROM avales WHERE av_id='".$venta->av_iddos."' ");
			if ($aval_dos->num_rows>0) {
				$aval_dos=$aval_dos->fetch_object();
			}

			if (isset($_GET['tipo'])) {
				if ($_GET['tipo']=='anualidad') {
					$fechas = $pre->pre_fechapaganualidades;
					$num = $pre->pre_numanualidades;
					$cuanto = $pre->pre_anualidades;
				}else if ($_GET['tipo']=='enganche'){
					$fechas = $pre->pre_fechapagenganche;
					$num = $pre->pre_numpagenganche;
					$cuanto = $pre->pre_enganche;
				}else if ($_GET['tipo']=='mes'){
					$fechas = $pre->pre_fechapagmensualidades;
					$num = $pre->pre_nummensualidades;
					$cuanto = $pre->pre_menusalidades;
				}
			}
		}

}else{
	echo "Venta inexistente";
	return;
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
		<?php 
		$fechas = explode(',', $fechas);

		for ($i=0; $i <= $num-1; $i++) { 
			$j = $i + 1;

			if ($_GET['tipo']=='mes' ) {
				$fechas[$i] = $fechas[0];
				$fechas[$i] = strtotime ( '+'.$i.' month' , strtotime ( $fechas[$i] ) ) ;
				$fechas[$i] = date ( 'Y-m-j' , $fechas[$i] );
			}
		?>
		<div class="col-xs-12" style="margin-bottom: 40px;">
			<table class="table ">
				<tr>
					<td colspan=2 rowspan=3 height="60" align="left"><br><img src="<?php echo MEDIA; ?>/img/logo.png" width=170  hspace=4 vspace=4></td>
					<td></td> <td></td> <td></td> <td></td> <td></td>
				</tr>
				<tr>
					<td><b>Pagaré</b></td>
					<td align="left" sdnum="1033;0;@"><font size=1 ><?php echo $j." DE ".$num;?></font></td>
					<td></td>
					<td>BUENO POR$</td>
					<td align="right" ><b> $<?php echo number_format($cuanto,2); ?></b></td>
				</tr>
				<tr>
					<td><b><?php echo $suc->suc_ciudad.", ".$suc->suc_estado;?></b></td>
					<td></td>
					<td align="center" sdval="29" sdnum="1033;"><?php echo strftime('%d', strtotime($pre->pre_fecha));?></td>
					<td align="center"><?php echo ucwords(strftime('%B', strtotime($pre->pre_fecha)));?></td>
					<td align="center" sdval="2015" sdnum="1033;"><?php echo strftime('%Y', strtotime($pre->pre_fecha));?></td>
				</tr>
				<tr>
					<td colspan=4 height="20" align="left">Debe(mos) y pagare(mos) incondicionalmente a la orden de:</td>
					<td colspan=3 align="left"><b>Ing. Mauricio Eduardo Torres Nava</b></td>
				</tr>
				<tr>
					<td height="20" ><font size=1 >En</font></td>
					<td colspan=2 align="center"><b>Cualquier Plaza</b></td>
					<td align="center"><font size=1 >el</font></td>
					<td align="center" sdval="29" sdnum="1033;"><?php echo strftime('%d', strtotime($fechas[$i]));?></td>
					<td align="center"><?php echo ucwords(strftime('%B', strtotime($fechas[$i])));?></td>
					<td align="center" sdval="2015" sdnum="1033;"><?php echo strftime('%Y', strtotime($fechas[$i]));?></td>
				</tr>
				<tr> <td colspan=7 height="20" align="center"><b>(SON: <?php echo strtoupper(num2letras($cuanto)); ?>  00/100 M.N.)</b></td> </tr>
				<tr>
					<td colspan=7>
						Valor recibido a mi (nuestra) entera satisfacción. Este Pagaré forma parte del 1 al <?php echo $num; ?> y todos están sujetos a la condición de<br>
						que, al no pagarse cualquiera de ellos a su vencimiento, serán exigibles todos los que le sigan en número, además de los ya <br>
						vencidos, desde la fecha de su vencimiento de este documento hasta el día de su liquidación, causará intereses moratorios - <br>
						del 7% mensual, pagadero en esta ciudad juntamente con el  principal
					</td>
				</tr>
				
			</table>
			<table class="table">
				<tr class="campos">
					<td width="25%"><b>NOMBRE</b></td>
					<td width="25%"><?php echo $datos->cli_nombre." ".$datos->cli_apellido; ?></td>
					<td width="25%"><b>NOMBRE FIADOR</b></td>
					<td width="25%"><?php echo $aval->av_nombre." ".$aval->av_apellidos; ?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>DIRECCION</b></td>
					<td width="25%"><?php echo str_replace(' | ', ', ', $datos->cli_dom);?></td>
					<td width="25%"><b>DIRECCION</b></td>
					<td width="25%"><?php echo str_replace(' | ', ', ', $aval->av_dom);?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>POBLACIÓN</b></td>
					<td width="25%"><?php echo $datos->cli_ciudad." ".$datos->cli_estado;?></td>
					<td width="25%"><b>POBLACIÓN</b></td>
					<td width="25%"><?php echo $aval->av_ciudad." ".$aval->av_estado;?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>TELÉFONO</b></td>
					<td width="25%"><?php echo $datos->cli_tel;?></td>
					<td width="25%"><b>TELÉFONO</b></td>
					<td width="25%"><?php echo $aval->av_tel;?></td>
				</tr>	
				<tr class="campos">	
					<td width="25%"><b>CEL</b></td>
					<td width="25%"><?php echo $datos->cli_cel;?></td>
					<td width="25%"><b>CEL</b></td>
					<td width="25%"><?php echo $aval->av_cel;?></td>
				</tr>

				<tr>
					<td colspan="2" align="center" ><br><br><br><br>FIRMA</td>
					<td colspan="2" align="center" ><br><br><br><br>FIRMA</td>
				</tr>

			</table>	

			<?php
			if ($venta->av_iddos!=0) {
				?>
			<table class="table">
				<tr class="campos">
					<td width="25%"><b>NOMBRE SEGUNDO FIADOR</b></td>
					<td width="25%"><?php echo $aval_dos->av_nombre." ".$aval_dos->av_apellidos; ?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>DIRECCION</b></td>
					<td width="25%"><?php echo str_replace(' | ', ', ', $aval_dos->av_dom);?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>POBLACIÓN</b></td>
					<td width="25%"><?php echo $aval_dos->av_ciudad." ".$aval_dos->av_estado;?></td>
				</tr>
				<tr class="campos">	
					<td width="25%"><b>TELÉFONO</b></td>
					<td width="25%"><?php echo $aval_dos->av_tel;?></td>
				</tr>	
				<tr class="campos">	
					<td width="25%"><b>CEL</b></td>
					<td width="25%"><?php echo $aval_dos->av_cel;?></td>
				</tr>
				<tr>
					<td colspan="2" align="center" ><br><br><br><br>FIRMA</td>
				</tr>
			</table>
			<?php
			}
			?>

		</div>
		<?php
		}
		?>
	</div>
</body>
</html>