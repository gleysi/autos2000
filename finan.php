<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

?>
<h1>Financiamientos</h1>
<p> <span class="label label-success">Cero pagarés vencidos</span> <span class="label label-warning">De 1 a 3 pagarés vencidos</span> <span class="label label-danger">De más de 3 pagarés vencidos</span> </p>
<table class="table">
		<tr>
			<th>id</th>
			<th>VU</th>
			<th>Nombre</th>
			<th>Vehículo</th>
			<th>Plazo</th>
			<th>Docu. Vencidos <br><small>en mensualidades</small></th>
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

				$ultimo = $f->pre_fechapagmensualidades;
				if ($ultimo >= date('Y-m-d')) {
					$ultimo = date('Y-m-d');
				}
				$verde=$amarillo=$rojo=null;
				$Npagos = 0;

				//$doc = $sql->Query("SELECT * FROM pagos WHERE pre_id='".$f->pre_id."' AND pag_tipo='1' ORDER BY pag_fecha DESC ");
				$doc = $sql->Query("SELECT * FROM pagos WHERE pre_id='".$f->pre_id."'  ORDER BY pag_fecha DESC ");
				if ($doc->num_rows>0) {
					$i=0;
					while ($pagos = $doc->fetch_object()) {
						if ($i==0) {
							$ultimo = $pagos->pag_fecha;
						}
						$i++;
						$Npagos += $pagos->pag_pago;
					}
				}
				
				//echo $ultimo;
				$ultimopago = date_create($ultimo);
				$hoy = date_create(date('Y-m-d'));
				$interval = date_diff($hoy,$ultimopago);
				$interval = $interval->format('%m'); // numero de pagares vencidos por mes
				//print_r($interval);

				$adeudo = $f->pre_costototal-$Npagos;
				
				if ($adeudo > 0) {
					// CERO PAGARÉS VENCIDOS //
					if ($interval==0) {
						$amarillo=null; 
						$rojo=null;
						$verde='success'; 
					}
					// DE 1 A 3 PAGARÉS VENCIDOS  //
					elseif ($interval<=3) {
						$amarillo='warning'; 
						$rojo=null;
						$verde=null;
					}
					// MÁS DE 3 PAGARÉS VENCIDOS //
					elseif ($interval>=4) {
						$amarillo=null; 
						$rojo='danger';
						$verde=null;
					}
				} else{
					$verde=$amarillo=$rojo=null;
				}


				echo "<tr class='alert alert-".$amarillo.$verde.$rojo." '>
					<td>#".$f->pre_id."</td>
					<td>".$f->ve_vu."</td>
					<td>".$cli->cli_nombre." ".$cli->cli_apellido."</td>
					<td>".$veh->ve_modelo." ".$mar->ma_nombre."</td>
					<td>".$f->pre_nummensualidades." meses, ".$f->pre_numanualidades." anualidades</td>
					<td>".$interval."</td>
					<td>$".number_format($adeudo,2)."</td>
					<td><a href='?pagos&id=".$f->pre_id."' class='btn btn-info' >Realizar pagos o abonar</a></td>
				</tr>";
			}
		}
		?>
</table> 