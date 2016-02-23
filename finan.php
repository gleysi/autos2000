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
				$doc= $sql->Query("SELECT * FROM pagos WHERE pre_id='".$f->pre_id."' AND pag_tipo='1' ");
				$verde=$amarillo=$rojo=null;
				$Npagos=0;
				$hoy = date('Y-m-d');
				$fecha_mensu=$f->pre_fechapagmensualidades;

				$NumPagosHechos =$doc->num_rows; // NUMERO DE PAGOS HECHOS
				$NumPagares=$f->pre_nummensualidades;// NUMERO DE PAGARES
				$NumVencidos = $NumPagares - $NumPagosHechos;
				//				6		   -	0            = 10
				if ($doc->num_rows>0) {

					// CERO PAGARÉS VENCIDOS //
					if ($NumVencidos==0) {
						$amarillo=null; 
						$rojo=null;
						$verde='success'; 
					}
					// DE 1 A 3 PAGARÉS VENCIDOS  //
					elseif ($NumVencidos>=1 AND $NumVencidos<=3) {
						$amarillo='warning'; 
						$rojo=null;
						$verde=null;
					}
					// MÁS DE 3 PAGARÉS VENCIDOS //
					elseif ($NumVencidos>=4) {
						$amarillo=null; 
						$rojo='danger';
						$verde=null;
					}

					while ($pagos=$doc->fetch_object()) {
						$Npagos += $pagos->pag_pago;
					}
					
					
				}else {
					// DE 1 A 3 PAGARÉS VENCIDOS  //
				//	2016-02-08  >  2016-03-01 and 5 <=3          
					if ($hoy>$fecha_mensu AND $NumPagares<=3) {
						$amarillo='warning'; 
						$rojo=null;
						$verde=null; 
					}
					// MÁS DE 3 PAGARÉS VENCIDOS //
					elseif ($hoy>$fecha_mensu AND $NumPagares>=4) {
						$amarillo=null; 
						$rojo='danger';
						$verde=null; 
					}
					// CERO PAGARÉS VENCIDOS //
					elseif($hoy < $fecha_mensu){
						$amarillo=null; 
						$rojo=null;
						$verde='success'; 
						$NumVencidos=0;
					}

				}

				$adeudo = $f->pre_costototal-$Npagos;

				echo "<tr class='alert alert-".$amarillo.$verde.$rojo." '>
					<td>#".$f->pre_id."</td>
					<td>".$f->ve_vu."</td>
					<td>".$cli->cli_nombre." ".$cli->cli_apellido."</td>
					<td>".$veh->ve_modelo." ".$mar->ma_nombre."</td>
					<td>".$f->pre_nummensualidades." meses, ".$f->pre_numanualidades." anualidades</td>
					<td>".$NumVencidos."</td>
					<td>$".number_format($adeudo,2)."</td>
					<td><a href='?pagos&id=".$f->pre_id."&cli_id=".$cli->cli_id."' class='btn btn-info' >Realizar pagos o abonar</a></td>
				</tr>";
			}
		}
		?>
</table> 