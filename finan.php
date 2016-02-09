<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

?>
<h1>Financiamientos</h1>
<table class="table">
		<tr>
			<th>id</th>
			<th>VU</th>
			<th>Nombre</th>
			<th>Vehículo</th>
			<th>Plazo</th>
			<th>Documentos Vencidos</th>
			<th>Adeudo</th>
			<th></th>
		</tr>
		<?php
		$finan=$sql->Query("SELECT * FROM presupuesto ORDER BY pre_id DESC");
		if ($finan->num_rows>0) {
			while ($f=$finan->fetch_object()) {

				// Cliente ///
				$cli=$sql->Query("SELECT * FROM clientes WHERE cli_id='".$f->cli_id."' ");
				if ($cli->num_rows>0) $cli=$cli->fetch_object();

				// Vehículo //
				$veh=$sql->Query("SELECT ve_marca,ve_modelo FROM vehiculos WHERE ve_id='".$f->ve_id."' ");
				if ($veh->num_rows>0) $veh=$veh->fetch_object();

				// Marca //
				$mar=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$veh->ve_marca."' ");
				if ($mar->num_rows>0) $mar=$mar->fetch_object();

				// Documentos vencidos en mensualidades ///
				$doc= $sql->Query("SELECT * FROM pagos WHERE pre_id='".$f->pre_id."' AND pag_tipo='1' ");
				$verde=$amarillo=$rojo=null;
				$hoy = date('Y-m-d');
				$fecha_mensu=$f->pre_fechapagmensualidades;
				$num_pagares =$doc->num_rows;

				if ($num_pagares>0) {
					
						$verde='success'; // cero pagares vencidos
				}else {
					
					if ($hoy>$fecha_mensu) {
						$amarillo='warning'; // pagare vencido
					} else{
					    $verde='success'; // cero pagares vencidos
					}

				}

				echo "<tr class='alert alert-".$amarillo.$verde.$rojo." '>
					<td>#".$f->pre_id."</td>
					<td>".$f->ve_vu."</td>
					<td>".$cli->cli_nombre." ".$cli->cli_apellido."</td>
					<td>".$veh->ve_modelo." ".$mar->ma_nombre."</td>
					<td>".$f->pre_nummensualidades." meses, ".$f->pre_numanualidades." anualidades</td>
					<td>Documentos Vencidos</td>
					<td>Adeudo</td>
					<td><a href='?pagos' class='btn btn-info' >Realizar pagos o abonar</a></td>
				</tr>";
			}
		}
		?>
</table> 