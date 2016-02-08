<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
include("num2letras.txt");
 setlocale (LC_TIME, "es_ES");
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

//echo $_SESSION['compra']['prov_id'];
$sucursal=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".__($_SESSION['compra']['suc_id'])."' ");
if( $sucursal->num_rows>0) { $sucursal=$sucursal->fetch_object(); }

$markas=$sql->Query("SELECT * FROM marcas WHERE ma_id='".$_SESSION['compra']['ve_marca']."' ");
if ($markas->num_rows>0) {
	$mark=$markas->fetch_object(); $mark=$mark->ma_nombre;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Autos2000</title>
    <link href="<?php echo MEDIA; ?>/bs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo MEDIA; ?>/css/estilo.css" rel="stylesheet">
    <script src="<?php echo MEDIA; ?>/js/jquery.min.js"></script>
    <script src="<?php echo MEDIA; ?>/bs/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body> 
<style type="text/css" media="print">
.nover {display:none}
</style>

	<div class="container" id="impricom">
	<input type="button" onclick="window.print();" class="nover" value="Imprimir" />
	    <div class="col-xs-12" id="logcom">
	    	<img src="http://media.autos2000.mx/img/logo.jpg" >
	    	<p>
	    		COMPRA VENTA Y CONSIGNACIÓN <br>
	    		ING. MAURICIO E. TORRES NAVA<br>
	    		AV. ALLENDE #601 OTE.<br>
	    		ESQ. COMONFORT COL. CENTRO<br>
	    		TORREÓN COAH. (871)2-67-54-76<br>
	    	</p>
	    </div>
	    <h2 id="h2com">CONTRATO DE COMPRA DE UNIDAD</h2>	
	    <p id="fechacom">Torreón, Coah., <?php echo strftime('%d de %B del %Y', strtotime($_SESSION['compra']['com_fecharegi']));  ?>.</p>		
	    <p> COMPRADOR: Ing. Mauricio Eduardo Torres Nava, <?php echo $sucursal->suc_direccion.", ".$sucursal->suc_ciudad." ".$sucursal->suc_estado." Tel.".$sucursal->suc_tel;?>. </p>
	    <p> VENDEDOR: <?php echo $_SESSION['compra']['prov_nombre']." ".$_SESSION['compra']['prov_apellidos']." Dirección: ".$_SESSION['compra']['prov_dir1']." ".$_SESSION['compra']['prov_dir2']." ".$_SESSION['compra']['prov_dir3']." ".$_SESSION['compra']['prov_ciudad']." ".$_SESSION['compra']['prov_estado']." CP: ".$_SESSION['compra']['prov_cp']." Tel:".$_SESSION['compra']['prov_tel']; ?>. </p>
	    <p> VEHÍCULO: Marca <?php echo $mark.", tipo ".$_SESSION['compra']['ve_tipo'].", modelo ".$_SESSION['compra']['ve_modelo'].", color ".$colorext[$_SESSION['compra']['att_colorext']].", número de motor ".$_SESSION['compra']['att_nummotor'].", con número de serie: ".$_SESSION['compra']['att_numserie'];?>. </p>
	    <p> Tanto comprador como vendedor pactan el precio del vehículo en la cantidad de $<?php echo number_format($_SESSION['compra']['att_preciocompra'],2);?>  (SON: <?php echo strtoupper(num2letras($_SESSION['compra']['att_preciocompra'])); ?>  00/100 M.N.), cantidad que será tomada a cuenta para compra-venta de vehículo <?php echo $marcas[$_SESSION['compra']['ve_marca']]." ".$_SESSION['compra']['ve_tipo']." ".$_SESSION['compra']['ve_modelo']." ".$colorext[$_SESSION['compra']['att_colorext']];?>. </p>
	    <p id="justicom">
	    	-Copia de factura de origen con número de folio <?php echo $_SESSION['compra']['att_folio'];?>, con fecha del  <?php echo strftime('%d de %B del %Y', strtotime($_SESSION['compra']['att_fechafac'])); ?> expedida por <?php  echo  $_SESSION['compra']['att_expedida'];  ?>.<br><br>
	    	-Factura original con número de folio <?php echo $_SESSION['compra']['att_foliooriginal'];?>, con fecha del <?php echo strftime('%d de %B del %Y', strtotime($_SESSION['compra']['att_fechafacoriginal'])); ?>. <br><br>
	    	-Comprobantes de pago de tenencias originales hasta <?php echo $_SESSION['compra']['att_tenencias'];?>. <br><br>
	    </p>
	    <p>El presente contrato lo firman ambas partes sin existir engaño, dolo o falsedad.</p>
	    <p>
		    <div class="firma">
		    ________________________________________<br>
		    	ING. MAURICIO E. TORRES NAVA
		    </div>
	        <div class="firma">
		    ________________________________________<br>
		    	<?php echo strtoupper($_SESSION['compra']['prov_nombre']." ".$_SESSION['compra']['prov_apellidos']); ?>
		    </div>
	    </p>
	</div>

</body>
</html>