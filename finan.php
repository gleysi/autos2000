<?php 
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

?>
<h1>Financiamientos</h1>
<table class="table table-striped">
		<tr>
			<td>VU</td>
			<td>Nombre</td>
			<td>Vehículo</td>
			<td>Plazo</td>
			<td>Documentos Vencidos</td>
			<td>Adeudo</td>
		</tr>
</table> 