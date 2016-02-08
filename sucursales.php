<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
// AGREGAR SUCURSAL
if (isset($_POST['guardar'])) {
		if($_POST['suc_nombre']!='' AND  $_POST['suc_direccion']!='' AND  $_POST['suc_ciudad']!='' AND  $_POST['suc_estado']!=''){
			$insert=$sql->Query("INSERT INTO sucursales VALUES(NULL,  '".addslashes(strip_tags($_POST['suc_nombre']))."', '".addslashes(strip_tags($_POST['suc_direccion']))."', '".addslashes(strip_tags($_POST['suc_ciudad']))."', '".addslashes(strip_tags($_POST['suc_estado']))."', '".addslashes(strip_tags($_POST['suc_tel']))."' ) ");
			echo "<div class='alert alert-success'>Sucursal Agregada</div>";
			header('Location: /admin.php?sucursales');
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
// ELIMINAR SUCURSAL
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM sucursales WHERE suc_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Sucursal eliminada</div>";
		header('Location: /admin.php?sucursales');
	}
}
// EDITAR SUCURSAL
if (isset($_POST['editar'])) {
		if($_POST['suc_nombre']!='' AND  $_POST['suc_direccion']!='' AND  $_POST['suc_ciudad']!='' AND  $_POST['suc_estado']!=''){
			$edit=$sql->Query("UPDATE sucursales SET  suc_nombre='".addslashes(strip_tags($_POST['suc_nombre']))."', suc_direccion='".addslashes(strip_tags($_POST['suc_direccion']))."',  suc_ciudad='".addslashes(strip_tags($_POST['suc_ciudad']))."', suc_estado='".addslashes(strip_tags($_POST['suc_estado']))."', suc_tel='".addslashes(strip_tags($_POST['suc_tel']))."' WHERE suc_id='".addslashes(strip_tags($_GET['c']))."' ");
			echo "<div class='alert alert-success'>Sucursal Editada</div>";
			header('Location: /admin.php?sucursales');
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
	}else{
		$titulo='Agregar Sucursal';
		$name='guardar';
	}
	?>
	<h2><?php echo $titulo;?></h2>
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="formatable">
		<div class="form-group">
		    <label>Sucursal</label>
		    <input type="text" class="form-control"  placeholder="Sucursal" name="suc_nombre" value="<?php echo $sel->suc_nombre; ?>">
	    </div>
	    <div class="form-group">
		    <label>Dirección:</label>
		    <input type="text" class="form-control"  placeholder="Dirección" name="suc_direccion" value="<?php echo $sel->suc_direccion; ?>">
		</div>
		<div class="form-group">
		    <label>Ciudad:</label>
		    <input type="text" class="form-control"  placeholder="Ciudad" name="suc_ciudad" value="<?php echo $sel->suc_ciudad; ?>">
		</div>
		<div class="form-group">
		    <label>Teléfono:</label>
		    <input type="text" class="form-control"  placeholder="Teléfono" name="suc_tel" value="<?php echo $sel->suc_tel; ?>">
		</div>
		<div class="form-group">
		    <label>Estado:</label>
		    <input type="text" class="form-control"  placeholder="Estado" name="suc_estado" value="<?php echo $sel->suc_estado; ?>">
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
						echo "<tr> <td>".$u->suc_id."</td> <td>".$u->suc_nombre."</td> <td>".$u->suc_direccion."</td> <td>".$u->suc_ciudad."</td> <td>".$u->suc_estado."</td> <td> <a href='/admin.php?sucursales&c=".$u->suc_id."' class='btn btn-warning'>Editar</a> <a href='/admin.php?sucursales&e=".$u->suc_id."' class='btn btn-danger'>Eliminar</a></td> </tr>";
					}
				}
			?>
		</table>
	</div>
	<?php
}
?>