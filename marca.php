<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
// AGREGAR MARCA
if (isset($_POST['guardar'])) {
		if($_POST['ma_nombre']!='' ){
			$insert=$sql->Query("INSERT INTO marcas VALUES(NULL,  '".__($_POST['ma_nombre'])."') ");
			echo "<div class='alert alert-success'>Marca Agregada</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
// ELIMINAR MARCA
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM marcas WHERE ma_id='".__($_GET['e'])."' ");
		echo "<div class='alert alert-success'>Marca eliminada</div>";
	}
}
// EDITAR MARCA
if (isset($_POST['editar'])) {
		if($_POST['ma_nombre']!='' ){
			$edit=$sql->Query("UPDATE marcas SET  ma_nombre='".__($_POST['ma_nombre'])."'  WHERE ma_id='".__($_GET['c'])."' ");
			echo "<div class='alert alert-success'>Marca Editada</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
?>
<h1>Administrador de Marcas</h1>
<?php
if (isset($_GET['a']) OR isset($_GET['c']) ){
	if (isset($_GET['c'])) {
		$titulo='Editar Marca';
		$name='editar';
		$sel=$sql->Query("SELECT * FROM marcas WHERE ma_id='".__($_GET['c'])."' ");
		if ($sel->num_rows>0) $sel=$sel->fetch_object(); else { echo "<div class='alert alert-danger'>Marca no existe</div"; return; }
	}else{
		$titulo='Agregar Marca';
		$name='guardar';
	}
	?>
	<h2><?php echo $titulo;?></h2>
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="formatable">
		<div class="form-group">
		    <label>Marca</label>
		    <input type="text" class="form-control"  placeholder="Nombre de la Marca" name="ma_nombre" value="<?php echo $sel->ma_nombre; ?>">
	    </div>
	    <button type="submit" class="btn btn-default" name='<?php echo $name;?>'><?php echo $titulo;?></button>
	</form>
	<?php
}
else  {
	$usu=$sql->Query("SELECT * FROM marcas ORDER BY ma_id DESC");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">Marcas actuales</div>
		<table class="table table-striped">
			<tr> <td>Id</td> <td>Nombre</td> </tr>
			<?php
				if ($usu->num_rows>0) {
					while ($u=$usu->fetch_object()) {
						echo "<tr> <td>".$u->ma_id."</td> <td>".$u->ma_nombre."</td> <td> <a href='/admin.php?marca&c=".$u->ma_id."' class='btn btn-warning'>Editar</a> <a href='/admin.php?marca&e=".$u->ma_id."' class='btn btn-danger'>Eliminar</a></td> </tr>";
					}
				}
			?>
		</table>
	</div>
	<?php
}
?>