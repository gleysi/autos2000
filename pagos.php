<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
?>
<h1>Realizar pagos</h1>
<form>
	<div class="panel panel-primary">
		<div class="panel-heading">Datos del cliente</div>
		<table class="table table-striped">
			<tr >
				<th>Número de compra:</th>
				<th>Vehículo</th>
				<th>VU</th>
				<th>Nombre del cliente:</th>
			</tr>
			<tr>
				<td>#4</td>
				<td>Nissan2000</td>
				<td>5454</td>
				<td>Juan Perez</td>
			</tr>
		</table>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading">Generar pago</div>
		<table class="table table-striped">
			<tr >
				<th>Número de compra:</th>
				<th>Vehículo</th>
				<th>VU</th>
				<th>Nombre del cliente:</th>
			</tr>
			<tr>
				<td>#4</td>
				<td>Nissan2000</td>
				<td>5454</td>
				<td>Juan Perez</td>
			</tr>
		</table>
	</div>
</form>