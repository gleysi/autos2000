<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

// PESUPUESTO
$presu=$sql->Query("SELECT ve_id,ve_vu,cli_id,pre_id, pre_fechapagmensualidades FROM presupuesto WHERE pre_id='".__($_GET['id'])."' ");
if ($presu->num_rows>0) $presu=$presu->fetch_object(); else echo "No existe presupuesto";

// CLIENTE
$datos=$sql->Query("SELECT cli_id,cli_nombre,cli_apellido FROM clientes WHERE cli_id='".$presu->cli_id."' ");
if ($datos->num_rows>0) {
	$datos=$datos->fetch_object();
}else echo "Cliente inexistente";

// VEHICULO
$vehiculo=$sql->Query("SELECT ve_id,ve_marca,ve_modelo FROM vehiculos WHERE ve_id='".$presu->ve_id."' ");
if($vehiculo->num_rows>0) $vehiculo=$vehiculo->fetch_object(); else echo "No existe vehículo para está venta";

// MARCA
$marca=$sql->Query("SELECT ma_nombre FROM marcas WHERE ma_id='".$vehiculo->ve_marca."' ");
if($marca->num_rows>0) $marca=$marca->fetch_object(); else echo "No existe la marca para este vehículo";

echo "<h1>Realizar pagos</h1>";
if (isset($_POST['guardar'])) {
	if ($_POST['pag_fecha']!='' AND $_POST['pag_pago']!='') {
		$insert=$sql->Query("INSERT INTO pagos VALUES(NULL,'".__($_GET['id'])."', '".$presu->cli_id."','".$presu->ve_id."', '".__($_POST['pag_fecha'])."', '".__($_POST['pag_pago'])."', '1'  ) ");
	    echo "<div class='alert alert-success'>Su pago ah sido agregado exitosamente</div>";
	}
	else{echo "<div class='alert alert-warning'>Por favor agregue todos los campos</div>";}
}
?>
<form class="col-xs-12" name="pago" method="post" >
    <div class="col-sm-6">
		<div class="panel panel-primary ">
			<div class="panel-heading">Datos del cliente</div>
			<table class="table table-striped">
				<tr >
					<th>Número de compra:</th>
					<th>Vehículo</th>
					<th>VU</th>
					<th>Nombre del cliente:</th>
					<th>Fecha de pago</th>
				</tr>
				<tr>
					<td>#<?php echo __($_GET['id']); ?></td>
					<td><?php echo $marca->ma_nombre." ".$vehiculo->ve_modelo; ?> </td>
					<td><?php echo $presu->ve_vu;?></td>
					<td><?php echo $datos->cli_nombre." ".$datos->cli_apellido; ?></td>
					<td><strong><?php echo date('d',strtotime($presu->pre_fechapagmensualidades));?> de cada mes </strong><br> Empieza a pagar a partir de:<br> <?php echo strftime('%d de %B del %Y', strtotime($presu->pre_fechapagmensualidades));?></td>
				</tr>
			</table>
		</div>

		<div class="panel panel-primary ">
			<div class="panel-heading">PAGOS</div>
			<table class="table table-striped">
				<tr >
					<th>Número de pago:</th>
					<th>Fecha de pago</th>
					<th>Depósito</th>
					<th>Imprimir</th>
				</tr>
				    <?php
				    
				    $pa=$sql->Query("SELECT pag_id,pag_fecha,pag_pago FROM pagos WHERE pre_id='".__($_GET['id'])."' ORDER BY pag_fecha DESC ");
				    if ($pa->num_rows>0) {
				    	$i=$pa->num_rows;
				    	while ($p=$pa->fetch_object()) {
				    		?>
							<tr>
				    		<td>#<?php echo $i;?></td>
							<td><?php echo $p->pag_fecha; ?> </td>
							<td><?php echo $p->pag_pago;?></td>
							<td><a href="pagares.php?id=<?php echo $p->pag_id; ?>&num=<?php echo $i;?>" target="_brank">Pagarés</a></td>
				    		</tr>
				    		<?php
				    		$i--;
				    	}
				    }
				    ?>
			</table>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-info">
			<div class="panel-heading">Generar pago</div>
				<table class="table table-striped">
					<tr>
						<td>Fecha de pago</td>
						<td> <input class="form-control" type="date" name="pag_fecha" value="<?php echo date('Y-m-d');?>"></td>
					</tr>
					<tr>
						<td>Depósito</td>
						<td><input class="form-control" type="number" name="pag_pago"> </td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="guardar" value="Guardar" class="btn btn-success"></td>
					</tr>
				</table>
		</div>
	</div>
</form>