<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

// CLIENTE
$datos=$sql->Query("SELECT cli_nombre,cli_apellido FROM clientes WHERE cli_id='".__($_GET['cli_id'])."' ");
if ($datos->num_rows>0) {
	$datos=$datos->fetch_object();
}else echo "Cliente inexistente";

// MARCA
?>
<h1>Realizar pagos</h1>
<form class="col-xs-12">
    <div class="col-sm-6">
		<div class="panel panel-primary ">
			<div class="panel-heading">Datos del cliente</div>
			<table class="table table-striped">
				<tr >
					<th>Número de compra:</th>
					<th>Vehículo</th>
					<th>VU</th>
					<th>Nombre del cliente:</th>
				</tr>
				<tr>
					<td>#<?php echo __($_GET['cli_id']); ?></td>
					<td>Nissan2000</td>
					<td>5454</td>
					<td><?php echo $datos->cli_nombre." ".$datos->cli_apellido; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-info">
			<div class="panel-heading">Generar pago</div>
				<table class="table table-striped">
					<tr>
						<td>Fecha de pago</td>
						<td> <input class="form-control" type="date" name="pag_fecha"></td>
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