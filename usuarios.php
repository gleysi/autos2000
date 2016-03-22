<?php
require_once("../config.php");
$show=false;
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
// AGREGAR USUARIO
if (isset($_POST['guardar'])) {
		if($_POST['usu_login']!='' AND  $_POST['usu_pass']!='' AND  $_POST['usu_nombre']!='' AND  $_POST['usu_estado']!=''){
			$insert=$sql->Query("INSERT INTO usuarios VALUES(NULL, '1', '".addslashes(strip_tags($_POST['usu_login']))."', '".addslashes(strip_tags(md5($_POST['usu_pass'])))."', '".addslashes(strip_tags($_POST['usu_nombre']))."', '".addslashes(strip_tags($_POST['usu_apellidos']))."' , '".addslashes(strip_tags($_POST['usu_estado']))."') ");
			echo "<div class='alert alert-success'>Usuario Agregado</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
// ELIMINAR USUARIO
if (isset($_GET['e'])){
	if ($_GET['e']!='') {
		$eli=$sql->Query("DELETE FROM usuarios WHERE usu_id='".addslashes(strip_tags($_GET['e']))."' ");
		echo "<div class='alert alert-success'>Usuario eliminado</div>";
	}
}
// EDITAR USUARIO
if (isset($_POST['editar'])) {
		if($_POST['usu_login']!='' AND  $_POST['usu_pass']!='' AND  $_POST['usu_nombre']!='' AND  $_POST['usu_estado']!=''){
			$edit=$sql->Query("UPDATE usuarios SET suc_id='1', usu_login='".addslashes(strip_tags($_POST['usu_login']))."', usu_pass='".addslashes(strip_tags(md5($_POST['usu_pass'])))."', usu_nombre='".addslashes(strip_tags($_POST['usu_nombre']))."', usu_estado='".addslashes(strip_tags($_POST['usu_estado']))."', usu_apellidos='".addslashes(strip_tags($_POST['usu_apellidos']))."' WHERE usu_id='".addslashes(strip_tags($_POST['c']))."' ");
			echo "<div class='alert alert-success'>Usuario Editado</div>";
		}else{
			echo "<div class='alert alert-danger'>Por favor llene todos los campos</div>";
		}
}
?>
<h1>Administrador de usuarios</h1>
<?php
if (isset($_GET['a']) OR isset($_GET['c']) ){
	if (isset($_GET['c'])) {
		$titulo='Editar Usuario';
		$name='editar';
		$sel=$sql->Query("SELECT * FROM usuarios WHERE usu_id='".addslashes(strip_tags($_GET['c']))."' ");
		if ($sel->num_rows>0) $sel=$sel->fetch_object(); else { echo "<div class='alert alert-danger'>Usuario no existe</div"; return; }
		$show=true;
	}else{
		$titulo='Agregar usuario';
		$name='guardar';
	}
	?>
	<h2><?php echo $titulo;?></h2>
	<form action="?usuarios" method="post" id="formatable">
		<div class="form-group">
		    <label>Usuario</label> <input type="hidden" name="c" value="<?php if($show) echo $sel->usu_id; ?>">
		    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Usuario" name="usu_login" value="<?php if($show) echo $sel->usu_login; ?>">
	    </div>
	    <div class="form-group">
		    <label>Contraseña:</label>
		    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="usu_pass" value="<?php if($show) echo $sel->usu_pass; ?>">
		</div>
		<div class="form-group">
		    <label>Nombre(s):</label>
		    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nombre" name="usu_nombre" value="<?php if($show) echo $sel->usu_nombre; ?>">
		</div>
		<div class="form-group">
		    <label>Apellidos:</label>
		    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Apellidos" name="usu_apellidos" value="<?php if($show) echo $sel->usu_apellidos; ?>">
		</div>
		<div class="form-group">
			<label>Estado:</label><br> 
			<select name="usu_estado" class="form-control" >
				<option value="1" <?php if( $show AND $sel->usu_estado=='1' ) echo 'selected'; ?>>Activo</option>
				<option value="0" <?php if( $show AND $sel->usu_estado=='0') echo 'selected'; ?>>Inactivo</option>
			</select>
	    </div>
	    <button type="submit" class="btn btn-default" name='<?php echo $name;?>'><?php echo $titulo;?></button>
	</form>
	<?php
}
else  {
	$usu=$sql->Query("SELECT * FROM usuarios ORDER BY usu_id DESC");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">Usuarios actuales</div>
		<table class="table table-striped">
			<tr> <td>Id</td> <td>Nombre</td> <td>Sucursal</td> <td>Estado</td><td>Acciones</td> </tr>
			<?php
				if ($usu->num_rows>0) {
					while ($u=$usu->fetch_object()) {
						$estado=($u->usu_estado==1)?'Activo':'Inactivo';
						echo "<tr> <td>".$u->usu_id."</td> <td>".$u->usu_nombre."</td> <td>".$u->suc_id."</td> <td>".$estado."</td> <td> <a href='".$_SERVER['REQUEST_URI']."&c=".$u->usu_id."' class='btn btn-warning'>Editar</a> <button  class='borrar btn btn-danger' data-name='".$u->usu_nombre."' data-alt='".$_SERVER['REQUEST_URI']."&e=".$u->usu_id."' data-toggle='modal' data-target='#myModal'  >Eliminar</button></td> </tr>";
					}
				}
			?>
		</table>
	</div>

	<script type="text/javascript">
	$(".borrar").click(function () {
		$('.modal-body').html('Está usted seguro de eliminar al usuaio <b>'+$(this).attr('data-name')+'</b>');
		$('#borrau').attr('href',$(this).attr('data-alt'));
	});
	</script>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Confirmación de eliminar usuario</h4>
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