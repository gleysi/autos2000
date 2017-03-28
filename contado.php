<?php
session_start(); 
require_once("../config.php");
if (!isset($_SESSION['userAdmn'])) {
	header('Location: /');
}
include("marcas.php");
include("num2letras.txt");
setlocale (LC_TIME, "es_ES");

if (isset($_GET['ven_id'])) {
  // venta
  $venta = $sql->Query("SELECT * FROM ventas WHERE ven_id='".__($_GET['ven_id'])."' ");
  if ($venta->num_rows>0) {
    $venta = $venta->fetch_object();

    // sucursal/vendedor
    $suc = $sql->Query("SELECT * FROM sucursales WHERE suc_id='".$venta->suc_id."' ");
    if ($suc->num_rows>0) {
      $suc = $suc->fetch_object();
      $usu = $sql->Query("SELECT * FROM usuarios WHERE suc_id='".$suc->suc_id."' ");
      if ($usu->num_rows>0) {
        $usu = $usu->fetch_object();
      }
    }
    // cliente
    $cliente = $sql->Query("SELECT * FROM clientes WHERE cli_id='".$venta->cli_id."' ");
    if ($cliente->num_rows>0) {
      $cliente = $cliente->fetch_object();
      $domi = explode('|', $cliente->cli_dom);
    }
    // presupuesto 
    $presu = $sql->Query("SELECT * FROM presupuesto WHERE ven_id='".$venta->ven_id."' ");
    if ($presu->num_rows>0) {
      $presu = $presu->fetch_object();
    }

    // vehiculo
    $vehicu = $sql->Query("SELECT * FROM vehiculos WHERE ve_id='".$venta->ve_id."' ");
    if ($vehicu->num_rows>0) {
      $vehicu = $vehicu->fetch_object();
      // atributos vehiculo
      $att = $sql->Query("SELECT * FROM vehiculos_attr WHERE ve_id='".$venta->ve_id."' ");
      if ($att->num_rows>0) {
        $att = $att->fetch_object();

        // color
        $col = $sql->Query("SELECT * FROM colores WHERE co_id='".$att->att_colorext."' ");
        if($col->num_rows>0) $col = $col->fetch_object();
      }
      // marca
      $marca = $sql->Query("SELECT * FROM marcas WHERE ma_id='".$vehicu->ve_marca."' ");
      if ($marca->num_rows>0) {
        $marca = $marca->fetch_object();
      }
    }else echo "Vehiculo inexistente";
    
  }else {
    echo "Venta inexistente";
    return;
  }

}else{
  echo "Venta inexistente";
  return;
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
    <style>.bottom{    margin-top: 250px;} .space{ margin: 10px 0;} .underline{text-decoration: underline;} .firma{text-decoration: } .fir{     text-align: center; border-top: 1px solid #000; padding-top: 10px; margin: 150px 20px 0 20px; width: 45%; float: left;}</style>
  </head>
<body> 
<style type="text/css" media="print">
.nover {display:none}
</style>

	<div style="font-size: 12px;line-height: 15px;" class="container" id="impricom">
	<input style="float: left;" type="button" onclick="window.print();" class="nover" value="Imprimir" />
	   <p style="text-align:left"><img style=" width: 130px;"src="<?php echo MEDIA;?>/img/logo.png"></p>
	   <h2  style="text-align:center">SEMINUEVOS <br>CONTRATO DE VENTA DE CONTADO</h2>	
	   <p style="text-align: right;"><br><br>TORREÓN COAH. A <span class="text-uppercase"><?php echo strftime('%d de %B del %Y', strtotime(date('Y-m-d')));  ?></span></p>
	   <p><br><br>
	   		<b>VEHICULO:</b>    Marca <b><?php echo $marca->ma_nombre; ?></b>  Tipo <b><?php echo $vehicu->ve_tipo;?></b> transmisión <b><?php echo $transmision[$att->att_transmision]; ?></b>, modelo <b><?php echo $vehicu->ve_modelo;?></b>, color <b><?php echo $col->co_nombre; ?></b>, <br>
        serie # <b><?php echo $att->att_numserie;?></b> y motor <b><?php echo $att->att_nummotor;?></b> <br>
        <b>VENDEDOR</b>: <?php echo $usu->usu_nombre." ".$usu->usu_apellidos;?>, <!-- NO HAY USUARIOS CON DIRECCION con domicilio: Av. Doroteo Arango 217 Col. El Dorado, Gomez Palacio Dgo.,  87 12 18 91 69 --><br>
        <b>COMPRADOR</b>: <?php echo $cliente->cli_nombre." ".$cliente->cli_apellido; ?>, con domicilio:  <?php echo $domi[0]." #".$domi[1]." ".$domi[2].", ".$cliente->cli_ciudad." ".$cliente->cli_estado." Tel: ".$cliente->cli_tel;  ?> <br><br>
     </p>
     <p  class="text-center">CLÁUSULAS</p>
     <ul>
       <li>Tanto vendedor como comprador pactan el precio de contado del vehículo en la cantidad de $<?php echo number_format($presu->pre_costototal,2);?> (SON: <?php echo strtoupper(num2letras($presu->pre_costototal)); ?> ) de mutuo acuerdo,  los cuales se pagan de la siguiente manera: Se entrega la cantidad de $<?php echo number_format($presu->pre_costototal,2);?> (SON: <?php echo strtoupper(num2letras($presu->pre_costototal)); ?> ) el día de hoy liquidando la compra.</li>
       <li>El vehículo se entrega en las condiciones físicas y mecánicas en que se encuentra, con previa revisión del comprador, por lo que <b class="text-uppercase">no se acepta reclamación posterior de ninguna índolE</b></li>
       <li>La papelería original del vehículo se entregara hasta la liquidación total del mismo, que consiste en factura original , copia de la factura de agencia, tenencias hasta el año <?php echo $att->att_tenencias?>.</li>
     </ul>
      <p class="space">Tanto comprador como vendedor están de acuerdo que en la firma de este contrato no existe dolo, engaño o falsedad por ambas partes.-</p>
      <div class="col-xs-12">
          <div class="fir">Vendedor<br> <?php echo $usu->usu_nombre." ".$usu->usu_apellidos;?></div>
          <div class="fir">Comprador<br> <?php echo $cliente->cli_nombre." ".$cliente->cli_apellido; ?></div>
      </div>
  </div>
</body>
</html>