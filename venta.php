<?php
//session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
$cli_id=$av_id=0;
// AGREGAR COMPRA
if (isset($_POST['guardar'])) {

	// CLIENTE
	if ($_POST['cli_id']!='seleccione') {
		if ($_POST['cli_id']=='nuevo') {
			$proveedor=$sql->Query("INSERT INTO clientes  VALUES(NULL,'".__($_POST['cli_nombre'])."','".__($_POST['cli_apellido'])."','".__($_POST['cli_dir1']).' | '.__($_POST['cli_dir2']).' | '.__($_POST['cli_dir3'])."','".__($_POST['cli_ciudad'])."','".__($_POST['cli_estado'])."','".__($_POST['cli_cp'])."','".__($_POST['cli_tel'])."','".__($_POST['cli_cel'])."','".__($_POST['cli_folio'])."','".__($_POST['cli_rfc'])."') ");
		    $cli_id=$sql->insert_id;
		}else{
			$cli_id= __($_POST['cli_id']);
			$update=$sql->Query("UPDATE clientes SET cli_nombre='".__($_POST['cli_nombre'])."', cli_apellido='".__($_POST['cli_apellido'])."', cli_dom='".__($_POST['cli_dir1']).' | '.__($_POST['cli_dir2']).' | '.__($_POST['cli_dir3'])."', cli_ciudad='".__($_POST['cli_ciudad'])."', cli_estado='".__($_POST['cli_estado'])."', cli_cp='".__($_POST['cli_cp'])."', cli_tel='".__($_POST['cli_tel'])."', cli_cel='".__($_POST['cli_cel'])."', cli_folio='".__($_POST['cli_folio'])."', cli_rfc='".__($_POST['cli_rfc'])."'  WHERE cli_id='".$cli_id."' ");
		} 
	}

	// insertar aval
	$aval=$sql->Query("INSERT INTO avales VALUES (NULL,'".__($_POST['av_nombre'])."','".__($_POST['av_apellidos'])."','".__($_POST['av_dir1']).' | '.__($_POST['av_dir2']).' | '.__($_POST['av_dir3'])."','".__($_POST['av_ciudad'])."','".__($_POST['av_estado'])."' ,'".__($_POST['av_cp'])."','".__($_POST['av_tel'])."','".__($_POST['av_cel'])."','".__($_POST['av_folio'])."','".__($_POST['av_stcivil'])."','".__($_POST['av_rfc'])."','".__($_POST['av_parentezco'])."' ) ");
	$av_id=$sql->insert_id;

	// insertar venta
	$compra=$sql->Query("INSERT INTO ventas (ven_id,ve_id,ve_vu,usu_id,suc_id,cli_id,ven_fecha,av_id,ven_tipo) VALUES (NULL,'".__($_POST['ve_id'])."','".__($_POST['att_vu'])."','".__($_POST['usu_id'])."','".__($_POST['suc_id'])."','".$cli_id."','".__($_POST['ven_fecha'])."','".$av_id."','".__($_POST['ven_tipo'])."')");
	$ven_id=$sql->insert_id;

	// insertar presupuesto
	if ($_POST['ven_tipo']==1) { // cr{edito}
		$pre_fpe= implode($_POST['pre_fpe'], ',');
		$pre_fpa= implode($_POST['pre_fpa'], ',');
	}else{ // contado
		$pre_fpe= null;
		$pre_fpa= null;
	}
	
	$pre_fpm=$_POST['pre_fpm1']; // asi se queda solo una fecha de cada mes   MENSUALIDADES
	
	$pres=$sql->Query("INSERT INTO presupuesto VALUES (
		NULL,
		'".__($_POST['ve_id'])."',
		'".__($_POST['att_vu'])."',
		'".$ven_id."',
		'".$cli_id."',
		'".date('Y-m-d')."',
		'".__($_POST['pre_precio'])."',
		'".__($_POST['pre_gps'])."',
		'".__($_POST['pre_enganche'])."',
		'".__($_POST['pre_numpagenganche'])."',
		'".$pre_fpe."',
		'".__($_POST['pre_intereses'])."',
		'".__($_POST['pre_iva'])."',
		'".__($_POST['pre_mensualidades'])."',
		'".__($_POST['pre_nummensualidades'])."',
		'".__($_POST['pre_anualidades'])."',
		'".__($_POST['pre_numanualidades'])."',
		'".$pre_fpm."',
		'".$pre_fpa."',
		'".__($_POST['pre_costototal'])."',
		'".__($_POST['pre_primerpago'])."') ");

	echo '<div class="alert alert-success" role="alert">Venta de unidad guardada exitosamente<br>';
	
	if ($_POST['ven_tipo']==0) { // contado
	  echo '<a href="contado.php?ven_id='.$ven_id.'" target="_blank" class="btn btn-info">Generar contrato de Compra-Venta-Contado</a>'; 
	}else{// crédito
	  echo '<a href="contratocp.php?ven_id='.$ven_id.'" target="_blank" class="btn btn-info">Generar contrato de Compra-Venta-Crédito</a>'; 
	}
	//echo ' <a href="'.$_SERVER['REQUEST_URI'].'admin.php?cartadeposito" target="_blank" class="btn btn-info">Generar Carta de unidad de depósito</a> </div>';
}

// ELIMINAR COMPRA
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM venta WHERE ven_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Venta eliminada</div>";
	}
}

// EDITAR COMPRA
if (isset($_POST['editar'])) {
	echo '<div class="alert alert-success" role="alert">Venta de unidad editada exitosamente<br><a href="/imprimir.php" target="_blank" class="btn btn-info">Imprimir</a> </div>';
}

if (isset($_GET['a']) OR isset($_GET['c']) ){

	if (isset($_GET['c'])) {
		$titulo='Editar venta';
		$name='editar';

		$sel=$sql->Query("SELECT * FROM ventas WHERE ven_id='".addslashes(strip_tags($_GET['c']))."' ");
		if ($sel->num_rows>0){

			// fetch de la venta
			$sel=$sel->fetch_object(); 

		}  else { echo "<div class='alert alert-danger'>Venta no existe</div"; return; }
	}else{
		$titulo='Agregar venta';
		$name='guardar';
	}
?>
<h1><?php echo $titulo;?></h1>
<form class="col-xs-12" id="formatable" action="?venta" method="post" name="formatable" id="formatable">
	<table class="table table-striped">
		<tr>
			<td>Operación:</td>
			<td><input name="ven_fecha" type="text" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="6"><b>Vendedor</b></td>
		</tr>
		<tr>
			<td>Usuario<input type="hidden" name="usu_id" value="<?php echo $_SESSION['idUsr'];?>"></td>
			<td colspan="2"><input name="usu_nombre" type="text" readonly="readonly" value="<?php echo $_SESSION['userAdmn'];?>" class="form-control"></td>
			<td>Sucursal<input type="hidden" name="suc_id" value="<?php echo $_SESSION['sucursalid'];?>"></td>
			<td colspan="2"><input name="usu_sucursal" type="text" readonly="readonly" value="<?php echo $_SESSION['sucursal'];?>" class="form-control"></td>
		</tr>
		<tr>
			<td>Nombre(s)</td>
			<td colspan="2"><input name="usu_nombre" type="text" readonly="readonly" value="<?php echo $_SESSION['alias'];?>" class="form-control"></td>
			<td>Apellidos</td>
			<td colspan="2"><input name="usu_apellidos"  type="text" readonly="readonly" value="<?php echo $_SESSION['apellidos'];?>" class="form-control"></td>
		</tr>
		<tr>
			<td><b>Cliente</b></td>
			<td>
				<select id="cli_id" class="form-control" name="cli_id" onchange="checar(this.value)" required>
					<option value="" >Seleccione</option>
					<option value="nuevo">Nuevo</option>
					<?php
					$cli=$sql->Query("SELECT * FROM clientes ORDER BY cli_id DESC");
					if ($cli->num_rows>0) {
							while ($p=$cli->fetch_object()) {
								$selected=(isset($sel->cli_id) AND $sel->cli_id==$p->cli_id)?'selected':null;
								echo "<option value='".$p->cli_id."' ".$selected." >".$p->cli_nombre."</option>";
							}
					}
					?>
			  </select>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</table>

		<table class="table table-striped" id="datoscliente" style="display:none">
		<tr class="clie">
			<td>Nombre(s):</td>
			<td colspan="2"><input id="cli_nombre" name='cli_nombre' type="text" class="form-control" required></td>
			<td>Apellido(s):</td>
			<td colspan="2"><input id="cli_apellido" name='cli_apellido' type="text" class="form-control" required></td>
		</tr>
		<tr class="prove">
			<td colspan="6">Dirección:</td>
		</tr>
		<tr class="clie">
			<td>Calle:</td>
			<td><input id="cli_dir1" name="cli_dir1" type="text" class="form-control" required></td>
			<td>Número:</td>
			<td><input id="cli_dir2" name="cli_dir2" type="text" class="form-control" required></td>
			<td>Colonia:</td>
			<td><input id="cli_dir3" name="cli_dir3" type="text" class="form-control" required></td>
		</tr>
		<tr class="clie">
			<td>Ciudad:</td>
			<td><input id="cli_ciudad" name="cli_ciudad" type="text" class="form-control" required></td>
			<td>Estado:</td>
			<td><input id="cli_estado" name="cli_estado" type="text" class="form-control" required></td>
			<td>CP:</td>
			<td><input id="cli_cp" name="cli_cp" type="text" class="form-control" ></td>
		</tr>
		<tr class="clie"> 
			<td>Tel. (Local):</td>
			<td><input id="cli_tel" name="cli_tel" type="text" class="form-control" ></td>
			<td>Tel. (Celular):</td>
			<td><input id="cli_cel" name="cli_cel" type="text" class="form-control" ></td>
			<td>Folio (IFE):</td>
			<td><input id="cli_folio" name="cli_folio" type="text" class="form-control" ></td>
		</tr>
		<tr>
			<td>RFC</td>
			<td><input id="cli_rfc" name="cli_rfc" type="text" class="form-control"></td>
			<td colspan="4"></td>
		</tr>
		</table>

		<table class="table table-striped" >
		<tr>
			<td colspan="6"><b>Aval</b></td>
		</tr>
		<tr class="clie">
			<td>Nombre(s):</td>
			<td colspan="2"><input id="av_nombre" name='av_nombre' type="text" class="form-control" required></td>
			<td>Apellido(s):</td>
			<td colspan="2"><input id="av_apellidos" name='av_apellidos' type="text" class="form-control" required></td>
		</tr>
		<tr class="prove">
			<td colspan="6">Dirección:</td>
		</tr>
		<tr class="clie">
			<td>Calle:</td>
			<td><input id="av_dir1" name="av_dir1" type="text" class="form-control"></td>
			<td>Número:</td>
			<td><input id="av_dir2" name="av_dir2" type="text" class="form-control"></td>
			<td>Colonia:</td>
			<td><input id="av_dir3" name="av_dir3" type="text" class="form-control"></td>
		</tr>
		<tr class="clie">
			<td>Ciudad:</td>
			<td><input id="av_ciudad" name="av_ciudad" type="text" class="form-control"></td>
			<td>Estado:</td>
			<td><input id="av_estado" name="av_estado" type="text" class="form-control"></td>
			<td>CP:</td>
			<td><input id="av_cp" name="av_cp" type="text" class="form-control"></td>
		</tr>
		<tr class="clie"> 
			<td>Tel. (Local):</td>
			<td><input id="av_tel" name="av_tel" type="text" class="form-control"></td>
			<td>Tel. (Celular):</td>
			<td><input id="av_cel" name="av_cel" type="text" class="form-control"></td>
			<td>Folio (IFE):</td>
			<td><input id="av_folio" name="av_folio" type="text" class="form-control"></td>
		</tr>
		<tr>
		    <td>Estado Civil:</td>
			<td><input id="av_stcivil" name="av_stcivil" type="text" class="form-control"></td>
			<td>Parentezco:</td>
			<td><input id="av_parentezco" name="av_parentezco" type="text" class="form-control" required></td>
			<td>RFC:</td>
			<td><input id="av_rfc" name="av_rfc" type="text" class="form-control"></td>
		</tr>


		<tr>
			<td><b>Unidad</b><input type="hidden" name="att_vu" id="att_vu" class="form-control" readonly="readonly"></td>
			<td>
				<select id="ve_id" class="form-control" name="ve_id" onchange="unidad(this.value)" required>
					<option value="" >Seleccione</option>
					<?php
					$usu=$sql->Query("SELECT * FROM vehiculos ORDER BY ve_id DESC");
					if ($usu->num_rows>0) {
						while ($u=$usu->fetch_object()) {

							$markas=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$u->ve_marca."' ");
							if ($markas->num_rows>0) {
								$mark=$markas->fetch_object(); $mark=$mark->ma_nombre;
							}
							echo "<option value='".$u->ve_id."' ".$selected." > ".$u->ve_id." - ".$mark."</option>";
						}
					}
					?>
			  </select>
			</td>
			<td> (<small>Buscar por VU</small>)</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr class="vehicu" style="display:none">
			<td>Marca</td>
			<td><input name="ve_marca" id="ve_marca" class="form-control" readonly="readonly"></td>
			<td>Tipo</td>
			<td><input name="ve_tipo" id="ve_tipo" class="form-control" readonly="readonly"></td>
			<td>Modelo</td>
			<td><input name="ve_modelo" id="ve_modelo" class="form-control" readonly="readonly"></td>
		</tr>

		<tr>
			<td colspan="2"><b>Presupuesto</b></td>
			<td colspan="2">Tipo de venta:</td>
			<td colspan="2"><select class="form-control" name="ven_tipo" id="ven_tipo" onchange="tipoventa(this.value)" required> <option value="">Seleccione</option> <option value="0">Contado</option><option value="1">Crédito</option></select></td>
		</tr>
		</table>
		<!-- CONTADO -->
		<table class="table table-striped" id="tipocontado" style="display:none">
			<tr><td colspan="2"><b>Tipo de compra contado</b></td></tr>
			<tr>
				<td>Precio Venta</td>
			    <td colspan="2"><input onkeyup="costototal();" name="pre_precio_contado" type="number" class="att_precioventa form-control"> </td>
			</tr>
		</table>
		<!-- CONTADO -->
		<!-- CRÉDITO -->
		<table class="table table-striped" id="tipocredito" style="display:none">
		<tr><td colspan="2"><b>Tipo de compra crédito</b></td></tr>
		<tr>
			<td>Precio Venta</td>
			<td colspan="2"><input onkeyup="costototal();" name="pre_precio" type="number" class="att_precioventa form-control"> </td>
			<td>Cobro por GPS (3,800)</td>
			<td colspan="2"> <select onchange="costototal();" name="pre_gps" class="form-control"> <option value="0">No</option>  <option value="1">Si</option> </select> </td>
		</tr>
		<tr>
			<td>Enganche</td>  
			<td colspan="2"><input onkeyup="costototal();" name="pre_enganche" type="number" class="form-control"> </td>
			<td>Números de pagos de enganche</td>
			<td colspan="2">
			  <select name="pre_numpagenganche" id="pre_numpagenganche" class="form-control" onchange="enganches(this.value)">
			  		<?php
			  		for ($i=0; $i <=20 ; $i++) { 
			  			echo "<option ".$i." >".$i."</option>";
			  		}
			  		?>
			  </select>
		</tr>
		<tr>
			<td>Fecha de los pagos de enganche</td>
			<td colspan="5"> <div id="PagosEnganche"></div></td>
		</tr>
		<tr>
			<td>Intereses</td>
			<td> <input  name="pre_intereses" class="form-control" type="number" id="pre_intereses"> </td>
			<td></td>
			<td>IVA</td>
			<td><input id="pre_iva" name="pre_iva" class="form-control" type="number" readonly="readonly"> </td>
			<td>IVA al 16% de los intereses</td>
		</tr>
		<tr style="background: #43B4BF;">
			<td>Menusalidades de:</td>
			<td colspan="2"> <input name="pre_mensualidades" class="form-control" type="number"> </td>
			<td>No. de mensualidades</td>
			<td colspan="2"><input value="1" onkeyup="costototal();" name="pre_nummensualidades" class="form-control" type="number">  </td>
		</tr>
		<tr style="background: #43B4BF;">
			<td>Fecha de pago de las mensualidades:</td>
			<td colspan="5"> <input name="pre_fpm1" class="form-control" type="date"> </td>
		</tr>
		<tr style="background: #43C287;">
			<td>Anualidades de:</td>
			<td colspan="2"> <input name="pre_anualidades" class="form-control" type="number"> </td>
			<td>No. de anualidades</td>
			<td colspan="2">
			<select name="pre_numanualidades" id="pre_numanualidades" class="form-control" onchange="anualidades(this.value)">
			  		<?php
			  		for ($i=0; $i <=20 ; $i++) { 
			  			echo "<option ".$i." >".$i."</option>";
			  		}
			  		?>
			  </select>
			</td>
		</tr>
		<tr style="background: #43C287;">
			<td>Fecha de pago de las anualidades:</td>
			<td colspan="5"> <div id="NumAnualidades"></div>  </td>
		</tr>
		
		<!-- CRÉDITO -->
		</table>
		<table class="table table-striped">
			<tr>
				<td>Costo Total</td>
				<td colspan="2"><input id="pre_costototal" name="pre_costototal" class="form-control" type="number" readonly="readonly" ></td>
				<td>Fecha del primer pago</td>
				<td colspan="2"> <input name="pre_primerpago" class="form-control" type="date">  </td>
			</tr>
			<tr>
				<td colspan="6"><input type="submit" value="<?php echo $titulo;?>" name="<?php echo $name;?>"  class="btn btn-success" ></td>
			</tr>
	    </table>

</form>
<?php
}
else  {
	echo "<h1>Administrador de Ventas</h1>";
}
?>
<script src="app.js"></script>