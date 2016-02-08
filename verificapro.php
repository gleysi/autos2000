<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
if (isset($_POST['prov_id'])) {
	$pro=$sql->Query("SELECT * FROM proveedores WHERE prov_id='".__($_POST['prov_id'])."'  ");
	if ($pro->num_rows>0) {
		$pro=$pro->fetch_object();
		$direccion=explode(' | ', $pro->prov_direccion);
		$a = array(
			'prov_nombre' => $pro->prov_nombre, 
			'prov_apellidos' => $pro->prov_apellidos, 
			'prov_dir1' => $direccion[0], 
			'prov_dir2' => $direccion[1], 
			'prov_dir3' => $direccion[2], 
			'prov_ciudad' => $pro->prov_ciudad, 
			'prov_estado' => $pro->prov_estado, 
			'prov_cp' => $pro->prov_cp, 
			'prov_tel' => $pro->prov_tel, 
			'prov_cel' => $pro->prov_cel, 
			'prov_ifefolio' => $pro->prov_ifefolio, 
		);

	  echo  json_encode($a);
	  return;
	}
}

if (isset($_POST['cli_id'])) {
	$pro=$sql->Query("SELECT * FROM clientes WHERE cli_id='".__($_POST['cli_id'])."'  ");
	if ($pro->num_rows>0) {
		$pro=$pro->fetch_object();
		$direccion=explode(' | ', $pro->cli_dom);
		$a = array(
			'cli_nombre' => $pro->cli_nombre, 
			'cli_apellido' => $pro->cli_apellido, 
			'cli_dir1' => $direccion[0], 
			'cli_dir2' => $direccion[1], 
			'cli_dir3' => $direccion[2], 
			'cli_ciudad' => $pro->cli_ciudad, 
			'cli_estado' => $pro->cli_estado, 
			'cli_cp' => $pro->cli_cp, 
			'cli_tel' => $pro->cli_tel, 
			'cli_cel' => $pro->cli_cel, 
			'cli_folio' => $pro->cli_folio, 
			'cli_rfc' => $pro->cli_rfc, 
		);

	  echo  json_encode($a);
	  return;
	}
}

if (isset($_POST['ve_id'])) {

	$ve=$sql->Query("SELECT * FROM vehiculos WHERE ve_id='".__($_POST['ve_id'])."' ");
	if ($ve->num_rows>0) {
		$ve=$ve->fetch_object();

		$att=$sql->Query("SELECT att_vu FROM vehiculos_attr WHERE ve_id='".__($_POST['ve_id'])."' ");
		if($att->num_rows>0) $att=$att->fetch_object();

		$a = array(
			've_marca' =>$marcas[$ve->ve_marca], 
			've_tipo' =>$ve->ve_tipo, 
			've_modelo' =>$ve->ve_modelo, 
			'att_vu' =>$att->att_vu,  
		);
	echo  json_encode($a);
	return;
	}	
}
?>