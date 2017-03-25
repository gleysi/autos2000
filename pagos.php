<?php 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");



// PESUPUESTO
$presu=$sql->Query("SELECT * FROM presupuesto WHERE pre_id='".__($_GET['id'])."' ");
if ($presu->num_rows>0) $presu=$presu->fetch_object(); else echo "No existe presupuesto";

// VENTAS
$venta=$sql->Query("SELECT * FROM ventas WHERE ven_id='".$presu->ven_id."' ");
if ($venta->num_rows>0) $venta=$venta->fetch_object(); else echo "No existe venta";

// CLIENTE
$datos=$sql->Query("SELECT * FROM clientes WHERE cli_id='".$presu->cli_id."' ");
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

		// usar tipo de pago como mensualidad o anualidad

		$insert=$sql->Query("INSERT INTO pagos VALUES(NULL,'".__($_GET['id'])."', '".$presu->cli_id."','".$presu->ve_id."', '".__($_POST['pag_fecha'])."', '".__($_POST['pag_pago'])."', '".__($_POST['pag_tipo'])."', '".__($_POST['pag_monatorio'])."'  ) ");
	    echo "<div class='alert alert-success'>Su pago ha sido agregado exitosamente</div>";

	}
	else{echo "<div class='alert alert-warning'>Por favor agregue todos los campos</div>";}
}


if (isset($_POST['subirtestigo'])) {

// subir documentos
		$destino =  "/home/autosmx/public_html/media/pagos_docs/".date("Y/m/"); /// web
		//$destino = "/opt/lampp/htdocs/autos2000/admin/test/".date("Y/m/"); // local
		if(!file_exists($destino)) {
	    	mkdir($destino, 0777, tru);
		}
		foreach ($_FILES["f"]["error"] as $i => $error) {
	      	move_uploaded_file($_FILES['f']['tmp_name'][$i], $destino.$_FILES['f']['name'][$i]);
	    	$tipo = $_FILES['f']['type'][$i];
	      	if (($tipo == "image/gif") ||  ($tipo == "image/jpeg") || ($tipo=="image/png") || ($tipo=="application/pdf") || ($tipo=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")  ) {
	     	   	if(file_exists($destino.$_FILES['f']['name'][$i])) {
	            	$sql->Query("INSERT INTO pagos_docs (pad_id,pag_id,pre_id,pad_name,pad_date) VALUES (NULL, '".$_POST['pag_id']."', '".$_POST['pre_id']."', '".$_FILES['f']['name'][$i]."', '".date('Y-m-d')."' )");
	         	}
	    	}
	   	}
}
?>
<form class="col-xs-12" name="pago" method="post" >
		<div class="panel panel-primary ">
			<div class="panel-heading">Datos de la venta</div>
			<table class="table table table-bordered">
				<tr class="alert alert-info">
					<th>Número de compra:</th>
					<th>Vehículo</th>
					<th>VU</th>
				</tr>
				<tr>
					<td>#<?php echo __($_GET['id']); ?></td>
					<td><?php echo $marca->ma_nombre." ".$vehiculo->ve_modelo; ?> </td>
					<td><?php echo $presu->ve_vu;?></td>
				</tr>
				<tr class="alert alert-info">	
					<th>Nombre del cliente:</th>
					<th>Fecha de pago</th>
					<th>Teléfono del cliente</th>
				</tr>
				<tr>
					<td><?php echo $datos->cli_nombre." ".$datos->cli_apellido; ?></td>
					<td><strong><?php echo date('d',strtotime($presu->pre_fechapagmensualidades));?> de cada mes </strong><br> Empieza a pagar a partir de:<br> <?php echo strftime('%d de %B del %Y', strtotime($presu->pre_fechapagmensualidades));?></td>
					<td><?php echo "Tel: ".$datos->cli_tel." Cel: ".$datos->cli_cel;?></td>
				</tr>

				<tr class="alert alert-info">	
					<th>Costo del vehículo</th>
					<th>Fecha de compra</th>
					<th>Fecha del primer pago</th>
				</tr>
				<tr>
					<td><?php echo number_format($presu->pre_costototal,0); // pre_precio es el precio del vehiculo más no a lo que se vendio ?></td> 
					<td><?php echo strftime('%d de %B del %Y', strtotime($presu->pre_fecha)); ?></td>
					<td><?php echo $presu->pre_primerpago;?></td>
				</tr>


				<tr class="alert alert-info">
					<th>Incluye GPS</th>
					<?php
					if ($venta->ven_tipo == 1) {
						?>
						<th>IVA</th>
						<th>Intereses</th>
						<?php
					} else{
						echo "<th>Pago</th><td></td>";
					}
					?>
				</tr>
				<tr>
					<td><?php if($presu->pre_gps==1) echo "Si $3,800"; else if($presu->pre_gps==2) echo "Descuento 50%, $1,900"; else echo "No"; ?></td>
					<?php
					if ($venta->ven_tipo == 1) {
						?>
						<td><?php echo number_format($presu->pre_iva,0); ?></td>
						<td><?php echo number_format($presu->pre_intereses,0); ?></td>
						<?php
					} else{
						echo "<td>Contado</td><td></td>";
					}
					?>
				</tr>

				<?php
				if ($venta->ven_tipo == 1) {
				?>
				<tr class="alert alert-info">
					<th>Fechas de pagos de enganche</th>
					<th>Enganche de</th>
					<th>Números de pago de enganche</th>
				</tr>	
				<tr>
					<td><?php echo $presu->pre_fechapagenganche; ?></td>
					<td><?php echo number_format($presu->pre_enganche,0); ?></td>
					<td><?php echo $presu->pre_numpagenganche;?></td>
				</tr>	
				<tr class="alert alert-info">
					<th>Fecha de pagos de mensualidades</th>
					<th>Mensualidades de</th>
					<th>Números de pago de mensualidades</th>
				</tr>	
				<tr>	
					<td><?php echo $presu->pre_fechapagmensualidades; ?></td>
					<td><?php echo number_format($presu->pre_menusalidades,0); ?></td>
					<td><?php echo $presu->pre_nummensualidades;?></td>
				</tr>	
				<tr class="alert alert-info">
					<th>Fecha de pagos de anualidades</th>
					<th>Anualidades de</th>
					<th>Números de pago de anualidades</th>
				</tr>
				
				<tr>	
					<td><?php echo $presu->pre_fechapaganualidades; ?></td>
					<td><?php echo number_format($presu->pre_anualidades,0); ?></td>
					<td><?php echo $presu->pre_numanualidades;?></td>
				</tr>
				<?php
				}
				?>

				
			
			</table>
		</div>

		<div class="panel panel-primary ">
			<div class="panel-heading">PAGOS</div>
			<table class="table table-striped">
				<tr >
					<th>Número de pago:</th>
					<th>Tipo:</th>
					<th>Fecha de pago:</th>
					<th>Depósito:</th>
					<th>Imprimir:</th>
					<th>testigos:</th>
				</tr>
				    <?php
				    
				    $pa=$sql->Query("SELECT * FROM pagos WHERE pre_id='".__($_GET['id'])."' ORDER BY pag_fecha DESC ");
				    if ($pa->num_rows>0) {
				    	$i=$pa->num_rows;
				    	while ($p=$pa->fetch_object()) {
				    		if ($p->pag_tipo==1) $tipo = "Mensualidad"; else $tipo = "Anualidad";
				    		?>
							<tr>
				    		<td>#<?php echo $i;?></td>
				    		<td><?php echo $tipo; ?></td>
							<td><?php echo $p->pag_fecha; ?> </td>
							<td><?php echo $p->pag_pago;?></td>
							<td> 
							<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" onclick="subirtest(<?php echo $i.','.$p->pag_id.','.$p->pre_id;?>);">
							 Subir testigo
							</button>

							 </td>
							 <td>
							 	<?php
							 	$testigos = $sql->Query("SELECT * FROM pagos_docs WHERE pag_id='".$p->pag_id."' ");
					    		if ($testigos->num_rows>0) {
					    			while ($t = $testigos->fetch_object()) {
					    				echo "<a target='_blank' href='".MEDIA."/pagos_docs/".date("Y/m/",strtotime($t->pad_date)).$t->pad_name."'>Testigo:".$t->pad_id."</a>, ";
					    			}
					    		}
							 	?>
							 </td>
							<!--<td><a href="pagares.php?id=<?php echo $p->pag_id; ?>&num=<?php echo $i;?>" target="_brank">Pagarés</a></td>-->
				    		</tr>
				    		<?php
				    		$i--;
				    	}
				    }
				    ?>
			</table>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Generar pago</div>
				<table class="table table-striped">
					<tr>
						<td>Fecha de pago</td>
						<td> <input class="form-control" type="date" name="pag_fecha" value="<?php echo date('Y-m-d');?>"></td>
					</tr>
					<tr>
						<td>Tipo de pago</td>
						<td>
							<select class="form-control" type="number" name="pag_tipo" id="pag_tipo" onchange="interes($('#pag_monatorio').val());">
								<option value="1">Mensualidad</option>
								<option value="2">Anualidad</option>
							</select>
							<input type="hidden" id="t_mensualidad" name="t_mensualidad" value="<?php echo $presu->pre_menusalidades; ?>">
							<input type="hidden" id="t_anualidad" name="t_anualidad" value="<?php echo $presu->pre_anualidades; ?>">
						</td>
					</tr>
					<tr>
						<td>Interés moratorio</td>
						<td> 
							<select class="form-control" type="number" name="pag_monatorio" id="pag_monatorio" onchange="interes(this.value);">
								<option value="0">0%</option>
								<option value="3.5">3.5%</option>
								<option value="5">5%</option>
								<option value="7">7%</option>
							</select> 
						</td>
					</tr>
					<tr>
						<td>Depósito</td>
						<td> <!-- Es lo que vino pagando al final -->
							<input class="form-control" type="number" id="pag_pago" name="pag_pago" > 
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="guardar" value="Guardar" class="btn btn-success"></td>
					</tr>
				</table>
		</div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <form name="testigos" method="post" enctype="multipart/form-data" >
      <div class="modal-body">
      		Elija los testigos para el pago #<b id="num"></b>
      		<input type="hidden" name="pag_id" id="pag_id" value="">
      		<input type="hidden" name="pre_id" id="pre_id" value="">
           <input type="file" name="f[]" class="form-control input-md" multiple="" accept=".jpg,.jpeg,.png,.txt,.pdf,.docx" name="Subir testigo">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="subirtestigo" value="subirtestigo" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php

?>
<script>
	function subirtest (num,pag_id,pre_id) {
		$("#num").html(num);
		$("#pag_id").val(pag_id);
		$("#pre_id").val(pre_id);
	}
	function interes (interes) {
		if ($("#pag_tipo").val()==1) {
			var num = parseInt($("#t_mensualidad").val());
		}else{
			var num = parseInt($("#t_anualidad").val());
		}
		totalcobrar = num*interes/100;
		totalcobrar = parseInt(num+totalcobrar);
		$("#pag_pago").val(totalcobrar);
	}
</script>