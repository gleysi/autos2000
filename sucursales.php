<?php
require_once("../config.php");
$show=false;
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
// AGREGAR SUCURSAL
if (isset($_POST['guardar'])) {
		if($_POST['suc_nombre']!='' AND  $_POST['suc_direccion']!='' AND  $_POST['suc_ciudad']!='' AND  $_POST['suc_estado']!=''){
			$insert=$sql->Query("INSERT INTO sucursales VALUES(NULL,  '".addslashes(strip_tags($_POST['suc_nombre']))."', '".addslashes(strip_tags($_POST['suc_direccion']))."', '".addslashes(strip_tags($_POST['suc_ciudad']))."', '".addslashes(strip_tags($_POST['suc_estado']))."', '".addslashes(strip_tags($_POST['suc_tel']))."', '".addslashes(strip_tags($_POST['suc_status']))."' ) ");
			echo "<div class='alert alert-success'>Sucursal Agregada</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
// ELIMINAR SUCURSAL
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM sucursales WHERE suc_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Sucursal eliminada</div>";
	}
}
// EDITAR SUCURSAL
if (isset($_POST['editar'])) {
		if($_POST['suc_nombre']!='' AND  $_POST['suc_direccion']!='' AND  $_POST['suc_ciudad']!='' AND  $_POST['suc_estado']!=''){
			$edit=$sql->Query("UPDATE sucursales SET  suc_nombre='".addslashes(strip_tags($_POST['suc_nombre']))."', suc_direccion='".addslashes(strip_tags($_POST['suc_direccion']))."',  suc_ciudad='".addslashes(strip_tags($_POST['suc_ciudad']))."', suc_estado='".addslashes(strip_tags($_POST['suc_estado']))."', suc_tel='".addslashes(strip_tags($_POST['suc_tel']))."', suc_status='".addslashes(strip_tags($_POST['suc_status']))."' WHERE suc_id='".addslashes(strip_tags($_GET['c']))."' ");
			echo "<div class='alert alert-success'>Sucursal Editada</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
?>
<h1>Administrador de sucursales</h1>
<?php
if (isset($_GET['a']) OR isset($_GET['c']) ){
	if (isset($_GET['c'])) {
		$titulo='Editar Sucursal';
		$name='editar';
		$sel=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".addslashes(strip_tags($_GET['c']))."' ");
		if ($sel->num_rows>0) $sel=$sel->fetch_object(); else { echo "<div class='alert alert-danger'>Sucursal no existe</div"; return; }
		$show=true;
	}else{
		$titulo='Agregar Sucursal';
		$name='guardar';
	}
	?>
	<h2><?php echo $titulo;?></h2>
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="formatable">
		<div class="form-group">
		    <label>Sucursal</label>
		    <input type="text" class="form-control"  placeholder="Sucursal" name="suc_nombre" value="<?php if($show) echo $sel->suc_nombre; ?>">
	    </div>
	    <div class="form-group">
		    <label>Dirección:</label>
		    <input type="text" class="form-control"  placeholder="Dirección" name="suc_direccion" value="<?php if($show) echo $sel->suc_direccion; ?>">
		</div>
		<div class="form-group">
		    <label>Ciudad:</label>
		    <input type="text" class="form-control"  placeholder="Ciudad" name="suc_ciudad" value="<?php if($show) echo $sel->suc_ciudad; ?>">
		</div>
		<div class="form-group">
		    <label>Teléfono:</label>
		    <input type="text" class="form-control"  placeholder="Teléfono" name="suc_tel" value="<?php if($show) echo $sel->suc_tel; ?>">
		</div>
		<div class="form-group">
		    <label>Estado:</label>
		    <input type="text" class="form-control"  placeholder="Estado" name="suc_estado" value="<?php if($show) echo $sel->suc_estado; ?>">
		</div>
		<div class="form-group">
		    <label>Mostrar en web:</label>
		    <select class="form-control" name="suc_status">
		    	<option value="1" <?php if ($show and $sel->suc_status=='1' ) echo "selected";?>>Si</option>
		    	<option value="0" <?php if ($show and $sel->suc_status=='0' ) echo "selected";?>>No</option>
		    </select>
		</div>
	    <button type="submit" class="btn btn-default" name='<?php echo $name;?>'><?php echo $titulo;?></button>
	</form>
	<?php
}
else  {
	$usu=$sql->Query("SELECT * FROM sucursales ORDER BY suc_id DESC");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">Sucursales actuales</div>
		<table class="table table-striped">
			<tr> <td>Id</td> <td>Nombre</td> <td>Dirección</td> <td>Ciudad</td> <td>Estado</td><td>Acciones</td> </tr>
			<?php
				if ($usu->num_rows>0) {
					while ($u=$usu->fetch_object()) {
						echo "<tr> <td>".$u->suc_id."</td> <td>".$u->suc_nombre."</td> <td>".$u->suc_direccion."</td> <td>".$u->suc_ciudad."</td> <td>".$u->suc_estado."</td> <td> <a href='".$_SERVER['REQUEST_URI']."&c=".$u->suc_id."' class='btn btn-warning'>Editar</a> <button class='borrar btn btn-danger' data-name='".$u->suc_nombre."' data-alt='".$_SERVER['REQUEST_URI']."&e=".$u->suc_id."' data-toggle='modal' data-target='#myModal' class='borrar btn btn-danger'>Eliminar</button></td> </tr>";
					}
				}
			?>
		</table>
	</div>

	<script type="text/javascript">
	$(".borrar").click(function () {
		$('.modal-body').html('Está usted seguro de eliminar la sucursal <b>'+$(this).attr('data-name')+'</b>');
		$('#borrau').attr('href',$(this).attr('data-alt'));
	});
	</script>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Confirmación de eliminar sucursal</h4>
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