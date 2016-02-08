<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");

// AGREGAR COMPRA
if (isset($_POST['guardar'])) {
	// PROVEEDOR
	if ($_POST['prov_id']!='seleccione') {
		if ($_POST['prov_id']=='nuevo') {
			$proveedor=$sql->Query("INSERT INTO proveedores (prov_id,prov_nombre,prov_apellidos,prov_direccion,prov_ciudad,prov_estado,prov_cp,prov_tel,prov_cel,prov_ifefolio) VALUES(NULL,'".__($_POST['prov_nombre'])."','".__($_POST['prov_apellidos'])."','".__($_POST['prov_dir1']).' | '.__($_POST['prov_dir2']).' | '.__($_POST['prov_dir3'])."','".__($_POST['prov_ciudad'])."','".__($_POST['prov_estado'])."','".__($_POST['prov_cp'])."','".__($_POST['prov_tel'])."','".__($_POST['prov_cel'])."','".__($_POST['prov_ifefolio'])."') ");
		    $prov_id=$sql->insert_id;
		}else{
			$prov_id= __($_POST['prov_id']);
			$update=$sql->Query("UPDATE proveedores SET prov_nombre='".__($_POST['prov_nombre'])."', prov_apellidos='".__($_POST['prov_apellidos'])."', prov_direccion='".__($_POST['prov_dir1']).' | '.__($_POST['prov_dir2']).' | '.__($_POST['prov_dir3'])."', prov_ciudad='".__($_POST['prov_ciudad'])."', prov_estado='".__($_POST['prov_estado'])."', prov_cp='".__($_POST['prov_cp'])."', prov_tel='".__($_POST['prov_tel'])."', prov_cel='".__($_POST['prov_cel'])."', prov_ifefolio='".__($_POST['prov_ifefolio'])."'  WHERE prov_id='".$prov_id."' ");
		} 
	}

	// NUEVA MARCA
	if ( $_POST['ve_marca']==0 AND $_POST['ma_nombre']!='') {
		$marka=$sql->Query("INSERT INTO marcas VALUES(NULL,'".__($_POST['ma_nombre'])."') ");
	    $ve_marca=$sql->insert_id;
	} else $ve_marca=$_POST['ve_marca'];

	// NUEVO COLOR EXTERIOR
	if ( $_POST['att_colorext']==0 AND $_POST['co_nombre']!='') {
		$color=$sql->Query("INSERT INTO colores VALUES(NULL,'".__($_POST['co_nombre'])."') ");
	    $att_colorext=$sql->insert_id;
	} else $att_colorext=$_POST['att_colorext'];

	// NUEVO COLOR INTERIOR
	if ( $_POST['att_colorint']==0 AND $_POST['co_nombre2']!='') {
		$color=$sql->Query("INSERT INTO colores VALUES(NULL,'".__($_POST['co_nombre2'])."') ");
	    $att_colorint=$sql->insert_id;
	} else $att_colorint=$_POST['att_colorint'];
	
	// VEHICULO
	$vehiculo=$sql->Query("INSERT INTO vehiculos VALUES(NULL,'".__($_POST['suc_id'])."','".date('Y-m-d')."','".$ve_marca."','".__($_POST['ve_tipo'])."','".__($_POST['ve_modelo'])."') ");
	$ve_id=$sql->insert_id;

	// COMPRA
	$compra=$sql->Query("INSERT INTO compra (com_id,ve_id,com_fechaopera,com_fecharegi,pro_id, 	com_formapago, com_tipocompra) VALUES(NULL,'".$ve_id."','".__($_POST['com_fechaopera'])."','".__($_POST['com_fecharegi'])."','".$prov_id."', '".__($_POST['com_formapago'])."', '".__($_POST['com_tipocompra'])."') ");
	
	// VEHICULO ATTR
	$attr=$sql->Query("INSERT INTO vehiculos_attr (att_id,ve_id,att_colorext,att_colorint,att_vestiduras,att_transmision,att_nummotor,att_numserie,att_placas,att_kilometraje,att_tenencias,att_aire,att_stereo,att_cd,att_quemacocos,att_rines,att_bolsasaire,att_cilindros,att_vidrios,att_seguros,att_anotaciones,att_fechafac,att_fechafacoriginal,att_expedida,att_folio,att_foliooriginal,att_preciocompra) VALUES(NULL,'".$ve_id."','".$att_colorext."','".$att_colorint."','".__($_POST['att_vestiduras'])."','".__($_POST['att_transmision'])."','".__($_POST['att_nummotor'])."','".__($_POST['att_numserie'])."','".__($_POST['att_placas'])."','".__($_POST['att_kilometraje'])."','".__($_POST['att_tenencias'])."','".__($_POST['att_aire'])."','".__($_POST['att_stereo'])."','".__($_POST['att_cd'])."','".__($_POST['att_quemacocos'])."','".__($_POST['att_rines'])."','".__($_POST['att_bolsasaire'])."','".__($_POST['att_cilindros'])."','".__($_POST['att_vidrios'])."','".__($_POST['att_seguros'])."','".__($_POST['att_anotaciones'])."','".__($_POST['att_fechafac'])."','".__($_POST['att_fechafacoriginal'])."','".__($_POST['att_expedida'])."','".__($_POST['att_folio'])."','".__($_POST['att_foliooriginal'])."','".__($_POST['att_preciocompra'])."') ");

	// guardamos datos en session para imprimir
	$_SESSION['compra']=$_POST;

	echo '<div class="alert alert-success" role="alert">Compra de unidad guardada exitosamente<br><a href="/imprimir.php" target="_blank" class="btn btn-info">Imprimir</a> </div>';
}

// ELIMINAR COMPRA
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM compra WHERE com_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Compra eliminada</div>";
		header('Location: /admin.php?compras');
	}
}

// EDITAR SUCURSAL
if (isset($_POST['editar'])) {

	// editar proveedor
	// PROVEEDOR
	if ($_POST['prov_id']!='seleccione') {
		if ($_POST['prov_id']=='nuevo') {
			$proveedor=$sql->Query("INSERT INTO proveedores (prov_id,prov_nombre,prov_apellidos,prov_direccion,prov_ciudad,prov_estado,prov_cp,prov_tel,prov_cel,prov_ifefolio) VALUES(NULL,'".__($_POST['prov_nombre'])."','".__($_POST['prov_apellidos'])."','".__($_POST['prov_dir1']).' | '.__($_POST['prov_dir2']).' | '.__($_POST['prov_dir3'])."','".__($_POST['prov_ciudad'])."','".__($_POST['prov_estado'])."','".__($_POST['prov_cp'])."','".__($_POST['prov_tel'])."','".__($_POST['prov_cel'])."','".__($_POST['prov_ifefolio'])."') ");
		    $prov_id=$sql->insert_id;
		}else{
			$prov_id= __($_POST['prov_id']);
			$update=$sql->Query("UPDATE proveedores SET prov_nombre='".__($_POST['prov_nombre'])."', prov_apellidos='".__($_POST['prov_apellidos'])."', prov_direccion='".__($_POST['prov_dir1']).' | '.__($_POST['prov_dir2']).' | '.__($_POST['prov_dir3'])."', prov_ciudad='".__($_POST['prov_ciudad'])."', prov_estado='".__($_POST['prov_estado'])."', prov_cp='".__($_POST['prov_cp'])."', prov_tel='".__($_POST['prov_tel'])."', prov_cel='".__($_POST['prov_cel'])."', prov_ifefolio='".__($_POST['prov_ifefolio'])."'  WHERE prov_id='".$prov_id."' ");
		} 
	}else $prov_id=null;

	// NUEVA MARCA
	if ( $_POST['ve_marca']==0 AND $_POST['ma_nombre']!='') {
		$marka=$sql->Query("INSERT INTO marcas VALUES(NULL,'".__($_POST['ma_nombre'])."') ");
	    $ve_marca=$sql->insert_id;
	} else $ve_marca=__($_POST['ve_marca']);

	// NUEVO COLOR EXTERIOR
	if ( $_POST['att_colorext']==0 AND $_POST['co_nombre']!='') {
		$color=$sql->Query("INSERT INTO colores VALUES(NULL,'".__($_POST['co_nombre'])."') ");
	    $att_colorext=$sql->insert_id;
	} else $att_colorext=$_POST['att_colorext'];

	// NUEVO COLOR INTERIOR
	if ( $_POST['att_colorint']==0 AND $_POST['co_nombre2']!='') {
		$color=$sql->Query("INSERT INTO colores VALUES(NULL,'".__($_POST['co_nombre2'])."') ");
	    $att_colorint=$sql->insert_id;
	} else $att_colorint=$_POST['att_colorint'];

	// editar vehiculo
	$vehiculo=$sql->Query("UPDATE vehiculos SET suc_id='".__($_POST['suc_id'])."', ve_fechaad='".date('Y-m-d')."', ve_marca='".$ve_marca."', ve_tipo='".__($_POST['ve_tipo'])."', ve_modelo='".__($_POST['ve_modelo'])."' WHERE ve_id= '".__($_POST['ve_id'])."' ");

	// editar compra
	$compra=$sql->Query("UPDATE  compra SET  ve_id='".__($_POST['ve_id'])."',  com_fechaopera='".__($_POST['com_fechaopera'])."', com_fecharegi='".__($_POST['com_fecharegi'])."', pro_id='".$prov_id."', com_formapago='".__($_POST['com_formapago'])."', com_tipocompra='".__($_POST['com_tipocompra'])."' WHERE com_id='".__($_POST['com_id'])."' ");

	// editar atributos del vehiculo
	$attr=$sql->Query("UPDATE vehiculos_attr SET att_colorext='".$att_colorext."', att_colorint='".$att_colorint."', att_vestiduras='".__($_POST['att_vestiduras'])."', att_transmision='".__($_POST['att_transmision'])."', att_nummotor='".__($_POST['att_nummotor'])."', att_numserie='".__($_POST['att_numserie'])."', att_placas='".__($_POST['att_placas'])."', att_kilometraje='".__($_POST['att_kilometraje'])."', att_tenencias='".__($_POST['att_tenencias'])."', att_aire='".__($_POST['att_aire'])."', att_stereo='".__($_POST['att_stereo'])."', att_cd='".__($_POST['att_cd'])."', att_quemacocos='".__($_POST['att_quemacocos'])."', att_rines='".__($_POST['att_rines'])."', att_bolsasaire='".__($_POST['att_bolsasaire'])."', att_cilindros='".__($_POST['att_cilindros'])."', att_vidrios='".__($_POST['att_vidrios'])."', att_seguros='".__($_POST['att_seguros'])."', att_anotaciones='".__($_POST['att_anotaciones'])."', att_fechafac='".__($_POST['att_fechafac'])."', att_fechafacoriginal='".__($_POST['att_fechafacoriginal'])."' ,att_expedida='".__($_POST['att_expedida'])."', att_folio='".__($_POST['att_folio'])."',att_foliooriginal='".__($_POST['att_foliooriginal'])."', att_preciocompra='".__($_POST['att_preciocompra'])."' WHERE att_id='".__($_POST['att_id'])."' ");

	// guardamos datos en session para imprimir
	$_SESSION['compra']=$_POST; 

	echo '<div class="alert alert-success" role="alert">Compra de unidad editada exitosamente<br><a href="/imprimir.php" target="_blank" class="btn btn-info">Imprimir</a> </div>';
}


if (isset($_GET['a']) OR isset($_GET['c']) ){

	if (isset($_GET['c'])) {
		$titulo='Editar Compra';
		$name='editar';
		$sel=$sql->Query("SELECT * FROM compra WHERE com_id='".addslashes(strip_tags($_GET['c']))."' ");
		if ($sel->num_rows>0){

			// fetch de la compra
			$sel=$sel->fetch_object(); 

			// fetch de el vehiculo
			$vei=$sql->Query("SELECT * FROM vehiculos WHERE ve_id='".$sel->ve_id."' ");
			if($vei->num_rows>0){$vei=$vei->fetch_object(); }

			// fetch de los atributos del vehiculo
			$att=$sql->Query("SELECT * FROM vehiculos_attr WHERE ve_id='".$sel->ve_id."' ");
			if($att->num_rows>0){$att=$att->fetch_object(); }


		}  else { echo "<div class='alert alert-danger'>Compra no existe</div"; return; }
	}else{
		$titulo='Agregar Compra';
		$name='guardar';
	}
?>
<h1><?php echo $titulo;?></h1>
<form class="col-xs-12" id="formatable" action="/admin.php?compras" method="post">


	<table class="table table-striped">
		<tr>
				<td colspan="2"><b>Fecha:</b> <?php if (isset($sel->com_id)) echo "<input type='hidden' value='".$sel->com_id."' name='com_id' >"; ?> </td>
				<td colspan="2"><b>Fecha:</b></td>
				<td colspan="2"></td>
		</tr>
		<tr>
				<td>Operación:</td>
				<td><input name="com_fechaopera" type="text" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
				<td>Registro:</td>
				<td><input name="com_fecharegi" type="date" value="<?php echo $sel->com_fecharegi; ?>" placeholder="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
				<td></td>
				<td></td>
		</tr>
		<tr>
			<td><b>Proveedor:</b></td>
			<td>
			  <select id="prov_id" class="form-control" name="prov_id" onchange="checar(this.value)">
				<option value="seleccione" >Seleccione</option>
				<option value="nuevo">Nuevo</option>
				<?php
				$prove=$sql->Query("SELECT prov_id,prov_nombre FROM proveedores ORDER BY prov_id DESC");
				if ($prove->num_rows>0) {
						while ($p=$prove->fetch_object()) {
							$selected=(isset($sel->pro_id) AND $sel->pro_id==$p->prov_id)?'selected':null;
							echo "<option value='".$p->prov_id."' ".$selected." >".$p->prov_nombre."</option>";
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
		<tr class="prove">
			<td>Nombre(s):</td>
			<td colspan="2"><input id="prov_nombre" name='prov_nombre' type="text" class="form-control"></td>
			<td>Apellido(s):</td>
			<td colspan="2"><input id="prov_apellidos" name='prov_apellidos' type="text" class="form-control"></td>
		</tr>
		<tr class="prove">
			<td colspan="6">Dirección:</td>
		</tr>
		<tr class="prove">
			<td>Calle:</td>
			<td><input id="prov_dir1" name="prov_dir1" type="text" class="form-control"></td>
			<td>Número:</td>
			<td><input id="prov_dir2" name="prov_dir2" type="text" class="form-control"></td>
			<td>Colonia:</td>
			<td><input id="prov_dir3" name="prov_dir3" type="text" class="form-control"></td>
		</tr>
		<tr class="prove">
			<td>Ciudad:</td>
			<td><input id="prov_ciudad" name="prov_ciudad" type="text" class="form-control"></td>
			<td>Estado:</td>
			<td><input id="prov_estado" name="prov_estado" type="text" class="form-control"></td>
			<td>CP:</td>
			<td><input id="prov_cp" name="prov_cp" type="text" class="form-control"></td>
		</tr>
		<tr class="prove">
			<td>Tel. (Local):</td>
			<td><input id="prov_tel" name="prov_tel" type="text" class="form-control"></td>
			<td>Tel. (Celular):</td>
			<td><input id="prov_cel" name="prov_cel" type="text" class="form-control"></td>
			<td>Folio (IFE):</td>
			<td><input id="prov_ifefolio" name="prov_ifefolio" type="text" class="form-control"></td>
		</tr>
		<tr>
			<td colspan="6"><b>Unidad: <?php if (isset($vei->ve_id)) echo "<input type='hidden' value='".$vei->ve_id."' name='ve_id' >"; ?> </b></td>
		</tr>
		<tr>
			<td>Marca:</td>
			<td>
				<select name="ve_marca" class="form-control" onchange="veri_marca(this.value)">
					<?php
					$marcas=$sql->Query("SELECT * FROM marcas ORDER BY ma_id DESC");
					if ($marcas->num_rows>0) {
						while ($ma=$marcas->fetch_object()) {
							$selected=(isset($vei->ve_marca) AND $vei->ve_marca==$ma->ma_id)?'selected':null;
						    echo "<option value='".$ma->ma_id."' ".$selected.">".$ma->ma_nombre."</option>";
						}
						echo "<option value='0' >-- Agregar Otro --</option>";
					}
					
					?>
				</select>
				<label id="otramarca" style="display:none">Por favor ingresa otra marca: <input name="ma_nombre"  class="form-control" ></label>
			</td>
			<td>Tipo:</td>
			<td><input name="ve_tipo" value="<?php echo $vei->ve_tipo;?>" type="text" class="form-control"></td>
			<td>Modelo:</td>
			<td>
				<select name="ve_modelo" class="form-control">
					<?php
						for ($i=2000; $i <= date('Y')+2; $i++) { 
							$selected=(isset($vei->ve_modelo) AND $vei->ve_modelo==$i)?'selected':null;
							echo "<option value='".$i."' ".$selected.">".$i."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>No. de Motor:</td>
			<td><input value="<?php echo $att->att_nummotor;?>" name="att_nummotor" type="text" class="form-control"></td>
			<td>No. de Serie:</td>
			<td><input value="<?php echo $att->att_numserie;?>" name="att_numserie" type="text" class="form-control"></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Kilometraje:</td>
			<td><input value="<?php echo $att->att_kilometraje;?>" name="att_kilometraje" type="text" class="form-control"></td>
			<td>Color (ext):</td>
			<td>
				<select name="att_colorext" class="form-control" onchange="veri_color(this.value)">
					<?php
					$colores=$sql->Query("SELECT * FROM colores ORDER BY co_id DESC");
					if ($colores->num_rows>0) {
						while ($co=$colores->fetch_object()) {
							$selected=(isset($att->att_colorext) AND $att->att_colorext==$co->co_id)?'selected':null;
						    echo "<option value='".$co->co_id."' ".$selected.">".$co->co_nombre."</option>";
						}
					}
					echo "<option value='0' >-- Agregar Otro --</option>";
					?>
				</select>
				<label id="otrocolor" style="display:none">Por favor ingresa otro color: <input name="co_nombre"  class="form-control" ></label>
			</td>
			<td>Color (int):</td>
			<td>
				<select name="att_colorint" class="form-control" onchange="veri_color2(this.value)">
					<?php
					$colores=$sql->Query("SELECT * FROM colores ORDER BY co_id DESC");
					if ($colores->num_rows>0) {
						while ($co=$colores->fetch_object()) {
							$selected=(isset($att->att_colorint) AND $att->att_colorint==$co->co_id)?'selected':null;
						    echo "<option value='".$co->co_id."' ".$selected.">".$co->co_nombre."</option>";
						}
					}
					echo "<option value='0' >-- Agregar Otro --</option>";
					?>
				</select>
				<label id="otrocolor2" style="display:none">Por favor ingresa otro color: <input name="co_nombre2"  class="form-control" ></label>
			</td>
		</tr>
		<tr>
			<td>Vestiduras:</td>
			<td>
				<select name="att_vestiduras" class="form-control">
					<?php
					foreach ($vestiduras as $k => $v) {
						$selected=(isset($att->att_vestiduras) AND $att->att_vestiduras==$k)?'selected':null;
						echo "<option value='".$k."' ".$selected." >".$v."</option>";
					}
					?>
				</select>
			</td>
			<td>Transmisión:</td>
			<td>
				<select name="att_transmision" class="form-control">
					<?php
					foreach ($transmision as $k => $v) {
						$selected=(isset($att->att_transmision) AND $att->att_transmision==$k)?'selected':null;
						echo "<option value='".$k."' ".$selected." >".$v."</option>";
					}
					?>
				</select>
			</td>
			<td>Entidad de placas:</td>
			<td><input value="<?php echo $att->att_placas;?>" type="text" class="form-control" name="att_placas"></td>
		</tr>
		<tr>
			<td  colspan="6"><b>Equipamiento: <?php if (isset($att->att_id)) echo "<input type='hidden' value='".$att->att_id."' name='att_id' >"; ?></b></td>
		</tr>
		<tr>
			<td>A/C:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_aire) AND $att->att_aire==1) echo 'checked'; ?> value="1" type="radio" name="att_aire" ></label><label class="radito"> No <input <?php if(isset($att->att_aire) AND $att->att_aire==0) echo 'checked'; ?> value="0" type="radio"  name="att_aire" ></label></td>
			<td>Estereo:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_stereo) AND $att->att_stereo==1) echo 'checked'; ?> value="1" type="radio" name="att_stereo" ></label><label class="radito"> No <input  <?php if(isset($att->att_stereo) AND $att->att_stereo==0) echo 'checked'; ?> value="0" type="radio"  name="att_stereo" ></label></td>
			<td>CD:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_cd) AND $att->att_cd==1) echo 'checked'; ?> value="1" type="radio" name="att_cd" ></label><label class="radito"> No <input <?php if(isset($att->att_cd) AND $att->att_cd==0) echo 'checked'; ?> value="0" type="radio"  name="att_cd" ></label></td>
		</tr>
		<tr>
			<td>Quemacocos:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_quemacocos) AND $att->att_quemacocos==1) echo 'checked'; ?> value="1" type="radio" name="att_quemacocos" ></label><label class="radito"> No <input <?php if(isset($att->att_quemacocos) AND $att->att_quemacocos==0) echo 'checked'; ?> value="0" type="radio"  name="att_quemacocos" ></label></td>
			<td>Rines:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_rines) AND $att->att_rines==1) echo 'checked'; ?> value="1" type="radio" name="att_rines" ></label><label class="radito"> No <input <?php if(isset($att->att_rines) AND $att->att_rines==0) echo 'checked'; ?> value="0" type="radio"  name="att_rines" ></label></td>
			<td>Bolsas de aire:</td>
			<td><label class="radito"> Si <input <?php if(isset($att->att_bolsasaire) AND $att->att_bolsasaire==1) echo 'checked'; ?> value="1" type="radio" name="att_bolsasaire" ></label><label class="radito"> No <input <?php if(isset($att->att_bolsasaire) AND $att->att_bolsasaire==0) echo 'checked'; ?> value="0" type="radio"  name="att_bolsasaire" ></label></td>
		</tr>
		<tr>
			<td>Número de cilindros:</td>
			<td> 
				<select name="att_cilindros"  class="form-control">
					<?php
					for ($i=3; $i < 9; $i++) { 
						$selected=(isset($att->att_cilindros) AND $att->att_cilindros==$i)?'selected':null;
						echo "<option value='".$i."' ".$selected." >v".$i."</option>";
					}
					?>
				</select> 
			</td>
			<td>Vidrios:</td>
			<td> 
				<select name="att_vidrios"  class="form-control">
					<option <?php if(isset($att->att_vidrios) AND $att->att_vidrios==0) echo 'selected'; ?> value="0">Eléctricos</option>
					<option <?php if(isset($att->att_vidrios) AND $att->att_vidrios==1) echo 'selected'; ?> value="1">Manuales</option>
				</select> 
			</td>
			<td>Seguros:</td>
			<td> 
				<select name="att_seguros"  class="form-control">
					<option <?php if(isset($att->att_seguros) AND $att->att_seguros==0) echo 'selected'; ?> value="0">Eléctricos</option>
					<option <?php if(isset($att->att_seguros) AND $att->att_seguros==1) echo 'selected'; ?> value="1">Manuales</option>
				</select> 
			</td>
		</tr>
		<tr>
			<td>Anotaciones y/o Comentarios:</td>
			<td colspan="2"> <textarea name="att_anotaciones" class="form-control" rows="5"><?php if(isset($att->att_anotaciones)) echo $att->att_anotaciones; ?></textarea>  </td>
			<td>Subir fotografias </td>
			<td colspan="2"> <input type="file"><br> <input type="file"><br> <input type="file"></td>
		</tr>
		<tr>
			<td>Fecha (fac) origen:</td>
			<td><input value="<?php if(isset($att->att_fechafac)) echo $att->att_fechafac; ?>" type="date" name="att_fechafac" class="form-control"></td>
			<td>Folio: (fac) origen:</td>
			<td><input value="<?php if(isset($att->att_folio)) echo $att->att_folio; ?>" type="text" name="att_folio" class="form-control"></td>
			<td>Expedida por:</td>
			<td><input value="<?php if(isset($att->att_expedida)) echo $att->att_expedida; ?>"  type="text" name="att_expedida" class="form-control"></td>
		</tr>
		<tr>
		    <td>Fecha (fac) original:</td>
			<td><input value="<?php if(isset($att->att_fechafacoriginal)) echo $att->att_fechafacoriginal; ?>" type="date" name="att_fechafacoriginal" class="form-control"></td>
			<td>Folio: (fac) original: </td>
			<td><input value="<?php if(isset($att->att_foliooriginal)) echo $att->att_foliooriginal; ?>" type="text" name="att_foliooriginal" class="form-control"></td>
			<td colspan="2"></td>
			
		</tr>
		<tr>
			<td>Tenencias pagadas hasta:</td>
			<td><input value="<?php if(isset($att->att_tenencias)) echo $att->att_tenencias; ?>" type="text" name="att_tenencias" class="form-control"></td>
			<td>Forma de pago:</td>
			<td>
				<select name="com_formapago" class="form-control">
					<?php
					foreach ($formapago as $k => $v) {
						$selected=(isset($sel->com_formapago) AND $sel->com_formapago==$k)?'selected':null;
						echo "<option value='".$k."' ".$selected.">".$v."</option>";
					}
					?>
				</select>
			</td>
			<td>Tipo de compra:</td>
			<td>
				<select name="com_tipocompra" class="form-control">
					<?php
					foreach ($tipocompra as $k => $v) {
						$selected=(isset($sel->com_tipocompra) AND $sel->com_tipocompra==$k)?'selected':null;
						echo "<option value='".$k."' ".$selected.">".$v."</option>";
					}
					?>
				</select>
			</td>
		</tr>	
		<tr>	
			<td>Costo:</td>
			<td><input value="<?php if(isset($att->att_preciocompra)) echo $att->att_preciocompra; ?>" type="text" name="att_preciocompra" class="form-control"></td>
			<td>Sucursal:</td>
			<td>
				<select name="suc_id" class="form-control">
					<?php
					$sucu=$sql->Query("SELECT suc_id,suc_nombre FROM sucursales ORDER BY suc_id DESC");
					if ($sucu->num_rows>0) {
						while ($s=$sucu->fetch_object()) {
							$selected=(isset($vei->suc_id) AND $vei->suc_id==$s->suc_id)?'selected':null;
							echo "<option value='".$s->suc_id."'  ".$selected." >".$s->suc_nombre."</option>";
						}
					}
					?>
				</select>
			</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="6"><input type="submit" value="<?php echo $titulo;?>" name="<?php echo $name;?>"  class="btn btn-success"></td>
		</tr>
	</table>
</form>
<?php
}
else  {
	$usu=$sql->Query("SELECT * FROM compra ORDER BY com_id DESC");
	?>
	<h1>Administrador de compras</h1>
	<div class="panel panel-primary">
		<div class="panel-heading">Compras actuales</div>
		<table class="table table-striped">
			<tr> <td>Id</td>  <td>Fecha de registro</td>  <td>Vehículo</td> <td>Proveedor</td>  <td>Acciones</td> </tr>
			<?php
				if ($usu->num_rows>0) {
					while ($u=$usu->fetch_object()) {
						$marka=$sql->Query("SELECT ve_marca FROM vehiculos WHERE ve_id='".$u->ve_id."'  ");
						if ($marka->num_rows>0) {
							$marka=$marka->fetch_object(); $mark=$marka->ve_marca; 
							$verima=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$mark."' ");
							if ($verima->num_rows>0) {
								$m=$verima->fetch_object(); $mark=$m->ma_nombre;
							}
						} else $mark='No asignada';

						$pro=$sql->Query("SELECT prov_nombre FROM proveedores WHERE prov_id='".$u->pro_id."'  ");
						if ($pro->num_rows>0) {$pro=$pro->fetch_object(); $provas=$pro->prov_nombre; } else $provas='No asignada';

						echo "<tr> <td>".$u->com_id."</td> <td>".$u->com_fecharegi."</td> <td>".$mark."</td> <td>".$provas."</td>   <td> <a href='/admin.php?compras&c=".$u->com_id."' class='btn btn-warning'>Editar</a> <a href='/admin.php?compras&e=".$u->com_id."' class='btn btn-danger'>Eliminar</a></td> </tr>";
					}
				}
			?>
		</table>
	</div>
	<?php
}
?>
<script>
$( document ).ready(function() {
	checar($("#prov_id").val());
});
	function checar(prov_id){
		if (prov_id=='nuevo' || prov_id=='seleccione' ) {
			$("#prov_nombre, #prov_apellidos, #prov_dir1, #prov_dir2, #prov_dir3, #prov_ciudad, #prov_estado, #prov_cp, #prov_tel, #prov_cel, #prov_ifefolio").val(''); 
		}else{
			$.ajax({
	            type: 'post',
	            dataType: "json",
	            url: 'verificapro.php',
	            contentType: "application/x-www-form-urlencoded",
	            processData: true,
	            data:"prov_id="+prov_id,
	            success: function(response){
	                $("#prov_nombre").val(response.prov_nombre); 
	                $("#prov_apellidos").val(response.prov_apellidos); 
	                $("#prov_dir1").val(response.prov_dir1); 
	                $("#prov_dir2").val(response.prov_dir2); 
	                $("#prov_dir3").val(response.prov_dir3); 
	                $("#prov_ciudad").val(response.prov_ciudad); 
	                $("#prov_estado").val(response.prov_estado); 
	                $("#prov_cp").val(response.prov_cp); 
	                $("#prov_tel").val(response.prov_tel); 
	                $("#prov_cel").val(response.prov_cel); 
	                $("#prov_ifefolio").val(response.prov_ifefolio); 
	            }
	        });
		}
	}
	function veri_marca (v) {
		if (v==0)  $("#otramarca").show();  else $("#otramarca").hide();
	}
	function veri_color (v) {
		if (v==0)  $("#otrocolor").show();  else $("#otrocolor").hide();
	}
	function veri_color2 (v) {
		if (v==0)  $("#otrocolor2").show();  else $("#otrocolor2").hide();
	}
	

</script>