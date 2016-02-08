<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

?>

<h1>Unidad de Depósito</h1>
<form class="col-xs-12" id="formatable" action="/admin.php?compras" method="post">


	<table class="table table-striped">
		<tr>
				<td>Nombre del comprador</td>
				<td> <input type="text" readonly="readonly"> </td>
				<td>Nombre del Aval</td>
				<td> <input type="text" readonly="readonly"> </td>
		</tr>
</table>