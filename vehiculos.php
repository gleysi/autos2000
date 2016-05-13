<?php
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
//Convertir imagenes convert($imagen,$calidad,$width,$formato,$retorno) //

$_POST['att_fotos']=1; // eliminar cuanod se suban fotos
// agregar vehiculo
if (isset($_POST['guardar'])) {
	$sql->Query("INSERT INTO vehiculos (ve_id,suc_id,ve_fechaad,ve_marca,ve_tipo,ve_modelo) VALUES (NULL,'".__($_POST['suc_id'])."','".date('Y-m-d')."','".__($_POST['marca'])."','".__($_POST['tipo'])."','".__($_POST['modelo'])."')");
	$vid=$sql->insert_id;
	
	$sql->Query("INSERT INTO vehiculos_attr  VALUES (NULL, '".$vid."', '".__($_POST['att_colorext'])."', '".__($_POST['colorint'])."', '".__($_POST['vestiduras'])."', '".__($_POST['transmision'])."', '".__($_POST['nummotor'])."', '".__($_POST['numserie'])."', '".__($_POST['att_placas'])."', '".__($_POST['att_placasenti'])."', '".__($_POST['kilometraje'])."', '".__($_POST['att_tenencias'])."', '".__($_POST['att_equipamiento'])."', '".__($_POST['aire'])."', '".__($_POST['stereo'])."', '".__($_POST['cd'])."', '".__($_POST['quemacocos'])."', '".__($_POST['rines'])."', '".__($_POST['bolsasaire'])."', '".__($_POST['cilindros'])."', '".__($_POST['vidrios'])."', '".__($_POST['seguros'])."', '".__($_POST['att_qty'])."', '".__($_POST['comentarios'])."', '".__($_POST['fechafac'])."', '".__($_POST['attr_fechafacoriginal'])."', '".__($_POST['expedida'])."', '".__($_POST['folio'])."', '".__($_POST['attr_foliooriginal'])."', '".__($_POST['att_vu'])."', '".__($_POST['att_fotos'])."', '".__($_POST['att_preciocompra'])."', '".__($_POST['att_precioventa'])."', '".__($_POST['att_preciooferta'])."', '".__($_POST['att_disponible'])."', '".__($_POST['att_web'])."')");
	
	$destino = "/home/autosmx/public_html/media/fotos/".date("Y/m/");
	if(!file_exists($destino)) {
    	mkdir($destino, 0777, tru);
	}	
	foreach ($_FILES["f"]["error"] as $i => $error) {
      	move_uploaded_file($_FILES['f']['tmp_name'][$i],$destino.$_FILES['f']['name'][$i]);
    	$tipo = $_FILES['f']['type'][$i];
      	if (($tipo == "image/gif") ||  ($tipo == "image/jpeg") || ($tipo=="image/png")) {
     	   	if(file_exists($destino.$_FILES['f']['name'][$i])) {
            	$sql->Query("INSERT INTO fotos (ve_id) VALUES ('".$vid."')");
         		$idfoto=$sql->insert_id;
         		$thu=$idfoto.'_100.jpg';
         		$med=$idfoto.'_400.jpg';
            	$big=$idfoto.'_800.jpg';
            	$ori=$idfoto.'.jpg';
            	convert($destino.$_FILES['f']['name'][$i],75,100,"jpg",$destino.$thu);//Thumbnail
            	convert($destino.$_FILES['f']['name'][$i],75,400,"jpg",$destino.$med);//Mediana
            	convert($destino.$_FILES['f']['name'][$i],75,800,"jpg",$destino.$big);//Big
            	convert($destino.$_FILES['f']['name'][$i],100,0,"jpg",$destino.$ori);//Original
         		unlink($destino.$_FILES['f']['name'][$i]);
         	}
    	}
   	}	

	echo "<div class='alert alert-success'>Vehículo Agregado</div>";
}
// ELIMINAR FOTO DE VEHICULO
if(isset($_GET['del'])) {
	$fecha = $sql->Query("SELECT ve_fechaad FROM vehiculos WHERE ve_id='".addslashes(strip_tags($_GET['c']))."'");
	$f = $fecha->fetch_object();
	$sql->Query("DELETE FROM fotos WHERE id ='".addslashes(strip_tags($_GET['del']))."'");
	unlink("/home/autosmx/public_html/media/fotos/".date("Y/m/",strtotime($f->ve_fechaad)).$_GET['del'].".jpg");
	unlink("/home/autosmx/public_html/media/fotos/".date("Y/m/",strtotime($f->ve_fechaad)).$_GET['del']."_100.jpg");
	unlink("/home/autosmx/public_html/media/fotos/".date("Y/m/",strtotime($f->ve_fechaad)).$_GET['del']."_400.jpg");
	unlink("/home/autosmx/public_html/media/fotos/".date("Y/m/",strtotime($f->ve_fechaad)).$_GET['del']."_800.jpg");
	echo "<div class='alert alert-success'>Fotografia eliminada</div>";
}
// ELIMINAR vehiculo
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM vehiculos WHERE ve_id='".addslashes(strip_tags($_GET['e']))."' ");
		$eli=$sql->Query("DELETE FROM vehiculos_attr WHERE ve_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Vehículo eliminado</div>";
	}
}

// EDITAR vehiculo
if (isset($_POST['editar'])) {
	$sql->Query("UPDATE  vehiculos SET suc_id='".__($_POST['suc_id'])."',  ve_marca='".__($_POST['marca'])."', ve_tipo='".__($_POST['tipo'])."', ve_modelo='".__($_POST['modelo'])."' WHERE ve_id='".__($_POST['ve_id'])."' ");
	$sql->Query("UPDATE  vehiculos_attr SET att_colorext='".__($_POST['att_colorext'])."', att_colorint = '".__($_POST['colorint'])."', att_vestiduras='".__($_POST['vestiduras'])."', att_transmision='".__($_POST['transmision'])."', att_nummotor='".__($_POST['nummotor'])."', att_numserie='".__($_POST['numserie'])."', att_placas='".__($_POST['att_placas'])."', att_placasenti='".__($_POST['att_placasenti'])."', att_kilometraje='".__($_POST['kilometraje'])."', att_tenencias='".__($_POST['att_tenencias'])."', att_equipamiento='".__($_POST['att_equipamiento'])."', att_aire='".__($_POST['aire'])."', att_stereo='".__($_POST['stereo'])."', att_cd='".__($_POST['cd'])."', att_quemacocos='".__($_POST['quemacocos'])."', att_rines='".__($_POST['rines'])."', att_bolsasaire='".__($_POST['bolsasaire'])."', att_cilindros='".__($_POST['cilindros'])."', att_vidrios='".__($_POST['vidrios'])."', att_seguros='".__($_POST['seguros'])."', att_qty='".__($_POST['att_qty'])."', att_anotaciones='".__($_POST['comentarios'])."', att_fechafac='".__($_POST['fechafac'])."', att_expedida='".__($_POST['expedida'])."', att_folio='".__($_POST['folio'])."', att_vu='".__($_POST['att_vu'])."', att_fotos='".__($_POST['att_fotos'])."', att_preciocompra='".__($_POST['att_preciocompra'])."', att_precioventa='".__($_POST['att_precioventa'])."', att_preciooferta='".__($_POST['att_preciooferta'])."', att_disponible='".__($_POST['att_disponible'])."', att_web='".__($_POST['att_web'])."'WHERE ve_id='".__($_POST['ve_id'])."' ");
	echo '<div class="alert alert-success" role="alert">Edición de vehiculo guardada exitosamente</div>';
}

 $feve=$eve=false;
if (isset($_GET['a']) OR isset($_GET['c']) ){

	if (isset($_GET['c'])) {
		$titulo='Editar Vehículo';
		$name='editar';
		$sel=$sql->Query("SELECT * FROM vehiculos WHERE ve_id='".addslashes(strip_tags($_GET['c']))."' ");
		if ($sel->num_rows>0){

			// fetch del vehiculo
			$sel=$sel->fetch_object(); 
			$eve=true;

			// fetch de los atributos del vehiculo
			$att=$sql->Query("SELECT * FROM vehiculos_attr WHERE ve_id='".$sel->ve_id."' ");
			if($att->num_rows>0){$att=$att->fetch_object(); $feve=true; } 


		}  else { echo "<div class='alert alert-danger'>El Vehículo no existe en la BD</div"; return; }
	}else{
		$titulo='Agregar Vehículo';
		$name='guardar';
	}
?>
<h1><?php echo $titulo;?></h1>
<form class="col-xs-12" id="formatable" action="" method="post" enctype="multipart/form-data">
	<table class="table table-striped">
			<tr>
				<td colspan="6"><b>Número económico</b><input type="hidden" value="<?php echo __($_GET['c']); ?>" name="ve_id"></td>
			</tr>
			<tr>
				<td>VU</td>
				<td><input  class="form-control" name="att_vu" value="<?php if($feve) echo $att->att_vu; ?>"></td>
				<td colspan="4"></td>
			</tr>
			<tr> <td colspan="6"><b>Unidad</b></td> </tr>
			<tr>
				<td>Marca:</td>
				<td>
					<select name="marca" class="form-control">
						<?php
						$markas1=$sql->Query("SELECT * FROM marcas  ");
						if ($markas1->num_rows>0) {
							while ($Mar=$markas1->fetch_object()) {

								$selected=($eve AND $sel->ve_marca==$Mar->ma_id)?'selected':null;
								echo "<option value='".$Mar->ma_id."' ".$selected.">".$Mar->ma_nombre."</option>";
							}
						}
						?>
					</select>
				</td>
				<td>Tipo:</td>
				<td><input name="tipo" type="text" class="form-control" value="<?php if($eve) echo $sel->ve_tipo; ?>"></td>
				<td>Modelo:</td>
				<td>
					<select name="modelo" class="form-control">
					<?php
						for ($i=2000; $i <= date('Y')+2; $i++) { 
							$selected=($eve AND $sel->ve_modelo==$i)?'selected':null;
							echo "<option value='".$i."'  ".$selected." >".$i."</option>";
						}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td>No. de Motor:</td>
				<td><input name="nummotor" type="text" class="form-control" value="<?php if($feve) echo $att->att_nummotor; ?>"></td>
				<td>No. de Serie:</td>
				<td><input name="numserie" type="text" class="form-control" value="<?php if($feve) echo $att->att_numserie; ?>"></td>
				<td>Cilindros:</td>
				<td><input name="cilindros" type="text" class="form-control" value="<?php if($feve) echo $att->att_cilindros; ?>"></td>
			</tr>
			<tr>
				<td>Kilometraje:</td>
				<td><input name="kilometraje" type="text" class="form-control" value="<?php if($feve) echo $att->att_kilometraje; ?>"></td>
				<td>Color (ext):</td>
				<td>
					<select name="att_colorext" class="form-control">
						<?php
						foreach ($colorext as $k => $v) {
							$selected=($feve AND $att->att_colorext==$k)?'selected':null;
							echo "<option value='".$k."' ".$selected." >".$v."</option>";
						}
						?>
					</select>
				</td>
				<td>Color (int):</td>
				<td>
					<select name="colorint" class="form-control">
						<?php
						foreach ($colorext as $k => $v) {
							$selected=($feve AND $att->att_colorint==$k)?'selected':null;
							echo "<option value='".$k."'  ".$selected." >".$v."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Vestiduras:</td>
				<td>
					<select name="vestiduras" class="form-control">
						<?php
						foreach ($vestiduras as $k => $v) {
							$selected=($feve AND $att->att_vestiduras==$k)?'selected':null;
							echo "<option value='".$k."' ".$selected."  >".$v."</option>";
						}
						?>
					</select>
				</td>
				<td>Transmisión:</td>
				<td>
					<select name="transmision" class="form-control">
						<?php
						foreach ($transmision as $k => $v) {
							$selected=($feve AND $att->att_transmision==$k)?'selected':null;
							echo "<option value='".$k."' ".$selected." >".$v."</option>";
						}
						?>
					</select>
				</td>
				<td>Vidrios:</td>
				<td> 
					<select name="vidrios"  class="form-control">
						<option value="0" <?php if($feve AND $att->att_vidrios==0) echo 'selected';  ?> >Eléctricos</option>
						<option value="1" <?php if($feve AND $att->att_vidrios==1) echo 'selected';  ?>>Manuales</option>
					</select> 
				</td>
			</tr>
			<tr>
				<td>Seguros:</td>
				<td>
					<select name="seguros"  class="form-control">
						<option value="0" <?php if($feve AND $att->att_seguros==0) echo 'selected';  ?>>Eléctricos</option>
						<option value="1" <?php if($feve AND $att->att_seguros==1) echo 'selected';  ?>>Manuales</option>
					</select>
				</td>
				<td>Placas:</td>
				<td>  <input name="att_placas" type="text" class="form-control" value="<?php if($feve) echo $att->att_placas; ?>"></td>
				<td>Entidad de placas:</td>
				<td> <input name="att_placasenti" type="text" class="form-control" value="<?php if($feve) echo $att->att_placasenti; ?>"></td>
			</tr>
			<tr>
				<td>Tenencias pagadas hasta:</td>
				<td> <input name="att_tenencias" type="text" class="form-control" value="<?php if($feve) echo $att->att_tenencias; ?>"></td>
				<td>Equipamiento:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="att_equipamiento" <?php if($feve AND $att->att_equipamiento==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="att_equipamiento" <?php if($feve AND $att->att_equipamiento==0) echo 'checked';?> ></label></td>
				<td>Cantidad de unidades:</td>
				<td> <input name="att_qty" type="number" class="form-control" value="<?php if($feve) echo $att->att_qty; ?>"></td>
			</tr>
			<tr> <td  colspan="6"><b>Equipamiento:</b></td> </tr>
			<tr>
				<td>A/C:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="aire"  <?php if($feve AND $att->att_aire==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="aire" <?php if($feve AND $att->att_aire==0) echo 'checked';  ?>></label></td>
				<td>Estereo:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="stereo" <?php if($feve AND $att->att_stereo==1) echo 'checked';?>></label><label class="radito"> No <input value="0" type="radio"  name="stereo" <?php if($feve AND $att->att_stereo==0) echo 'checked';?>></label></td>
				<td>CD:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="cd" <?php if($feve AND $att->att_cd==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="cd" <?php if($feve AND $att->att_cd==0) echo 'checked';?> ></label></td>
			</tr>
			<tr>
				<td>Quemacocos:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="quemacocos" <?php if($feve AND $att->att_quemacocos==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="quemacocos" <?php if($feve AND $att->att_quemacocos==0) echo 'checked';?> ></label></td>
				<td>Rines:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="rines" <?php if($feve AND $att->att_rines==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="rines" <?php if($feve AND $att->att_rines==0) echo 'checked';?>></label></td>
				<td>Bolsas de aire:</td>
				<td><label class="radito"> Si <input checked value="1" type="radio" name="bolsasaire" <?php if($feve AND $att->att_bolsasaire==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="bolsasaire" <?php if($feve AND $att->att_bolsasaire==0) echo 'checked';?>></label></td>
			</tr>
			<tr>
				<td>Comentarios:</td>
				<td colspan="5"><textarea name="comentarios" class="form-control" rows="3" value="<?php if($feve) echo $att->att_anotaciones;?>"><?php if($feve) echo $att->att_anotaciones;?></textarea> </td>
			</tr>
			<tr> <td colspan="6"><b>Facturación</b></td> </tr>
			<tr>
				<td>Fecha (fac):</td>
				<td><input type="date" name="fechafac" class="form-control" value="<?php if($feve) echo $att->att_fechafac;?>"></td>
				<td>Fecha (factura original):</td>
				<td><input type="date" name="attr_fechafacoriginal" class="form-control" value="<?php if($feve) echo $att->attr_fechafacoriginal;?>"></td>
				<td></td>
				<td></td>
			</tr>
			<tr>	
				<td>Folio (fac):</td>
				<td><input type="text" name="folio" class="form-control" value="<?php if($feve) echo $att->att_folio;?>"></td>
				<td>Folio (factura original):</td>
				<td><input type="text" name="attr_foliooriginal" class="form-control" value="<?php if($feve) echo $att->attr_foliooriginal;?>"></td>
				<td>Expedida por:</td>
				<td><input type="text" name="expedida" class="form-control" value="<?php if($feve) echo $att->att_expedida;?>"></td>
			</tr>
			<tr> <td colspan="6"><b>Fotografias</b></td> </tr>
			<tr>
				<td>Subir fotografias </td>
				<td colspan="2"> 
					<input type="file" name="f[]" class="form-control input-md" multiple="" accept=".jpg,.jpeg,.png">
				</td>
				<td colspan="3">
					<style>
					.delfoto {
						position: absolute;
					    top: 0;
					    right: 15px;
					    width: 30px;
					    background: rgba(255, 255, 255, 0.79);
					}
					.delfoto img {
						width: 100%;
					}
					</style>
					<?php 
					if(isset($_GET['c'])) {
						$foto = $sql->Query("SELECT id FROM fotos WHERE ve_id='".$sel->ve_id."'");
						$date = $sel->ve_fechaad;
						if($foto->num_rows>0) {
							while ($f = $foto->fetch_object()) {
								echo '<div class="col-sm-3"><img src="'.MEDIA."/fotos/".date("Y/m/",strtotime($date)).$f->id.'_100.jpg" style="width:100%;margin-right:5px;"> <a href="?car&c='.$_GET['c'].'&del='.$f->id.'" class="delfoto"><img src="'.MEDIA.'/iconos/delete.png"></a></div>';
								//$fotos[$f->id] =  MEDIA."/fotos/".date("Y/m/",strtotime($date)).$f->id."_".$w.".jpg";
							}
						}
					}
					?>
				</td>
			</tr>
			<tr>
				<td>Precio compra:</td>
				<td><input type="number" name="att_preciocompra" class="form-control" value="<?php if($feve) echo $att->att_preciocompra;?>"></td>
				<td>Precio venta:</td>
				<td><input type="number" name="att_precioventa" class="form-control" value="<?php if($feve) echo $att->att_precioventa;?>"></td>
				<td>Precio Oferta:</td>
				<td><input type="number" name="att_preciooferta" class="form-control" value="<?php if($feve) echo $att->att_preciooferta;?>"></td>
			</tr>
			<tr> <td colspan="6"><b>Locación</b></td> </tr>
			<tr>
				<td>Sucursal</td>
				<td>
					<select name="suc_id" class="form-control">
						<?php
						$sucu=$sql->Query("SELECT suc_id,suc_nombre FROM sucursales ORDER BY suc_id DESC");
						if ($sucu->num_rows>0) {
							while ($s=$sucu->fetch_object()) {
								$selected=($eve AND $sel->suc_id==$s->suc_id)?'selected':null;
								echo "<option value='".$s->suc_id."' ".$selected.">".$s->suc_nombre."</option>";
							}
						}
						?>
					</select>
				</td>
				<td>Disponibilidad</td>
				<td>
					<label class="radito"> Si <input checked value="1" type="radio" name="att_disponible" <?php if($feve AND $att->att_disponible==1) echo 'checked';?>></label><label class="radito"> No <input value="0" type="radio"  name="att_disponible" <?php if($feve AND $att->att_disponible==0) echo 'checked';?>></label>
				</td>
				<td>Web</td>
				<td>
					<label class="radito"> Si <input checked value="1" type="radio" name="att_web" <?php if($feve AND $att->att_web==1) echo 'checked';?> ></label><label class="radito"> No <input value="0" type="radio"  name="att_web" <?php if($feve AND $att->att_web==0) echo 'checked';?>></label>
				</td>
			</tr>
			<tr> <td colspan="6" class="text-center"><input value="<?php echo $titulo;?>" name="<?php echo $name;?>"  type="submit"   class="btn-lg btn btn-success"></td> </tr>
	</table>
</form>
<?php
}
else{
	$usu=$sql->Query("SELECT * FROM vehiculos ORDER BY ve_id DESC");
	?>
	<h1>Administrador de vehículos</h1>
	<div class="panel panel-primary">
		<div class="panel-heading">Vehículos actuales</div>
		<table class="table table-striped">
			<tr> <td>Id</td>  <td>Fecha de registro</td>  <td>Vehículo</td> <td>Modelo</td>  <td>Acciones</td> </tr>
			<?php
				if ($usu->num_rows>0) {
					while ($u=$usu->fetch_object()) {

						$markas=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$u->ve_marca."' ");
						if ($markas->num_rows>0) {
							$mark=$markas->fetch_object(); $mark=$mark->ma_nombre;
						}

						echo "<tr> <td>".$u->ve_id."</td> <td>".$u->ve_fechaad."</td> <td>".$mark."</td> <td>".$u->ve_modelo."</td>   <td> <a href='".$_SERVER['REQUEST_URI']."&c=".$u->ve_id."' class='btn btn-warning'>Editar</a> <button data-alt='".$_SERVER['REQUEST_URI']."&e=".$u->ve_id."' data-name='".$u->ve_id."' class='borrar btn btn-danger' data-toggle='modal' data-target='#myModal'>Eliminar</button></td> </tr>";
					}
				}
			?>
		</table>
	</div>
	<script type="text/javascript">
	$(".borrar").click(function () {
		$('.modal-body').html('Está usted seguro de eliminar el vehículo número: <b>'+$(this).attr('data-name')+'</b>');
		$('#borrau').attr('href',$(this).attr('data-alt'));
	});
	</script>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Confirmación de eliminar vehículo</h4>
	      </div>
	      <div class="modal-body">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <a href="" type="button" id="borrau" class="btn btn-primary">Eliminar</a>
	      </div>
	    </div>
	  </div>
	</div>
	<?php
}
?>