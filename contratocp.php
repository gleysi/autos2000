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
//$sucursal=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".__($_SESSION['compra']['suc_id'])."' ");
//if( $sucursal->num_rows>0) { $sucursal=$sucursal->fetch_object(); }
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
	   <p style="text-align:left"><img style=" width: 130px;"src="<?php echo MEDIA;?>/img/logo.jpg"></p>
	   <h2  style="text-align:center">CONTRATO DE VENTA DE CRÉDITO</h2>	
	   <p style="text-align: right;"><br><br>TORREÓN COAH. A 13 DE JUNIO DEL 2015</p>
	   <p><br><br>
	   		Contrato de compra-venta con reserva de dominio de vehículo usado, que celebran por una parte el Ing. Mauricio Eduardo Torres Nava, propietario de la negociación denominada Autos 2000. A quien en lo sucesivo se le denominará “El Vendedor” y por otra parte Christian Jorge Hernández Acosta, quien en lo sucesivo se le denominará “El Comprador”, al tenor de las siguientes declaraciones y cláusulas:<br><br>
     </p>
     <div class="col-xs-12 space">
       <div class="col-sm-1">I.</div>
       <div class="col-sm-11" >
            Declara el vendedor:<br><br>
            Ser una persona física, cuya actividad preponderante u objeto social es la compra-venta de vehículos usados, que se encuentran debidamente registrados como socio activo de la Asociación Nacional de Comerciantes de Automóviles y Camiones Nuevos y Usados, A. C. (ANCA). Con el número de asociado 598, información que se puede consultar, así como obtener servicios de orientación para la venta y/o adquisición de vehículos usados en el teléfono de ANCA: 01-800-260-26-22; Fax: 5536-2608 y correo electrónico info@anca.org.mx de manera gratuita.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">II.</div>
       <div class="col-sm-11" >
            Tener su domicilio en Av. Allende 601 ote.,  Col. Centro C.P. 27000 en Torreón, Coah. Con Registro Federal de Contribuyentes TONM-620405-PB9, teléfono (871) 2-67-54-76, con horario de atención de 9:00 a 14:00 y de 4:00 a 7:30 horas.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">III.</div>
       <div class="col-sm-11" >
            Que cuenta con la infraestructura y capacidad necesaria para proporcionar en un establecimiento fijo comercialización de vehículos usados y cuenta con los permisos, avisos o autorizaciones necesarias para llevar a cabo su actividad.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">IV.</div>
       <div class="col-sm-11" >
            Que es legítimo propietario del vehículo en materia de este contrato y que previamente a la celebración del mismo, informo al comprador de todas y cada una de las condiciones generales del vehículo, para que en su caso fuese revisado por este último.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">V.</div>
       <div class="col-sm-11" >
            Declara el comprador llamarse como ha quedado expreso en el rubro de este contrato, tener su domicilio en C. Gregorio A. García No. 1084 Col. Río 2000, en Torreón, Coah. y número telefónico (871) 7-22-29-28 y con Registro Federal de Causantes HEMS890623-RI9, que tiene capacidad jurídica para obligarse en los términos de este contrato.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">VI.</div>
       <div class="col-sm-11" >
            Declaran ambos contratantes que es de su voluntad obligarse al tenor de la siguientes cláusulas.
       </div>
     </div>
     <div class="col-xs-12 space">
       <div class="col-sm-1">VII.</div>
       <div class="col-sm-11" >
            Que previamente a la celebración del presente contrato se le informó al comprador sobre el precio de contado del vehículo usado, objeto del presente contrato, el monto de los intereses, la tasa que se le calcula, el monto y detalle de los cargos, el número de pagos a realizar, su periodicidad, la cantidad total a pagar por dicho vehículo, y el derecho que tiene a liquidar anticipadamente con la consiguiente reducción de intereses.
       </div>
     </div>
     <p align="center"><br><br><br><br><b>Claúsulas</b><br><br></p>
     <p>
       <b>Primera:</b> El vendedor vende y el comprador compra el vehículo que a continuación se describe:
       <table width="250">
         <tr> <td>Marca:</td> <td><b>Nissan</b></td> </tr>
         <tr> <td>Tipo:</td> <td><b>X-Trail LE  </b></td> </tr>
         <tr> <td>Modelo:</td> <td><b>2011</b></td> </tr>
         <tr> <td>Serie:</td> <td><b>5N1HA1CBLVQ351623</b></td> </tr>
         <tr> <td>Motor:</td> <td><b>5NP4352</b></td> </tr>
         <tr> <td>Color:</td> <td><b>Blanco</b></td> </tr>
         <tr> <td>Kilometraje:</td> <td><b> 80,000 km. </b></td> </tr>
       </table>
     </p>
     <p>Observaciones acerca de las condiciones generales del vehículo: <b>Unidad usada, transmisión automática.</b></p>
	   <p> <b>Segunda:</b> El Vendedor en este acto exhibe al comprador la documentación en copia simple que ampara la propiedad del vehículo descrito en la cláusula anterior cerciorándose que dicha documentación corresponde fielmente al citado vehículo y se encuentra en regla, quedando en poder del vendedor la documentación original, hasta  en tanto no sea liquidado totalmente el precio pactado por tratarse de un <b>contrato bajo reserva de dominio.</b> </p>
     <hr>
     <p><b>Tercera:</b> El precio de compra-venta, lo han determinado de común acuerdo El Vendedor y El Comprador, sobre las siguientes bases:</p>
     <div class="col-xs-12 space">
         <table>
           <tr> <td valign="top" width="20">A) </td><td> Precio de la unidad: <b>$205,000 (SON: DOSCIENTOS CINCO MIL PESOS 00/100 M.N.)</b></td></tr>
           <tr><td valign="top" width="20">B) </td><td> Enganche: <b>$100,000 (SON CIEN MIL PESOS 00/100 M.N.)</b> Número de pagos: <b>1.</b></td></tr> 
           <tr><td valign="top" width="20">C) </td><td> <b>36</b> Pagos <b>mensuales</b> por la cantidad de: <b>$3,248 (SON: TRES MIL DOSCIENTOS CUARENTA Y OCHO PESOS 00/100 M.N.),</b> los días 23 de cada mes. A los pagos realizados por adelantado, se les bonificará el 100% de interés, entregándose el último pagaré de la serie.</b>
                              <br><b>3 </b>Pagos <b>anuales</b> por la cantidad de <b>$20,000 (SON: VEINTE MIL PESOS 00/100 M.N.).</b></td>
           </tr> 
           <tr><td valign="top" width="20">D) </td><td> <span class='underline'>Al llegar al vencimiento de la anualidad (en caso de existir en el financiamiento), ésta se tendrá que liquidar primero, antes de seguir con los pagos por adelantado, aún en el caso de adelanto de mensualidades.</span> </td> </tr> 
           <tr><td valign="top" width="20">E) </td><td>Forma de pago:<b>Efectivo.</b> </td></tr> 
           <tr><td valign="top" width="20">F) </td><td>Fecha de entrega del vehículo: <b>10 de noviembre de 2015.</b></td></tr>
           <tr><td valign="top" width="20">G) </td><td>Intereses moratorios al <b>7% mensual</b> en caso de retraso en el pago.</td></tr> 
         </table>
      </div>
      <p class="space"><b>Cuarta.</b> El Comprador se obliga a no vender, ni a grabar en forma alguna el vehículo, objeto de este contrato, hasta que liquide el precio en su totalidad.</p>
      <p class="space"><b>Quinta.</b> Para dar cumplimiento a lo previsto por el artículo 70 de la Ley Federal de Protección al Consumidor, los contrayentes de común acuerdo y para el caso de que se rescindiera el presente contrato, deberán restituirse mutuamente las presentaciones que se hubieran hecho, si el comprador hubiera pagado más de la tercera parte del importe de la compra-venta, podrá optar por la recisión o el pago del adeudo vencido, en términos de lo previsto en el artículo 71 del citado ordenamiento legal.</p>
      <p class="space"><b>Sexta.</b> El Comprador asumirá al momento de recibir el vehículo, la responsabilidad sobre el buen uso del mismo, desde la entrega del bien, y se hace responsable de los daños que pudiera ocasionar con el vehículo.</p>
      <p class="space"><b>Séptima.</b> El Vendedor podrá demandar la recisión del contrato o el vencimiento del saldo del adeudo del presente contrato y en consecuencia exigir su pago total, cuando ocurra cualquiera de las siguientes causas:</p>
      <div class="col-xs-12 space">
        <table>
          <tr><td valign="top" width="20">A)</td><td>Cuando el vehículo objeto de la Compra- Venta sufra destrucción total o daños parciales que afecten su naturaleza o éste sea materia de embargo, secuestro judicial u otro acontecimiento semejante a los citados en esta cláusula de lo que sea responsable el comprador, por cesión o traspaso de derechos o arrendamiento del vehículo y de cualquiera de los derechos que adquiere el comprador sin que medie el consentimiento otorgado por escrito por el vendedor.</td></tr>
          <tr><td valign="top" width="20">B)</td><td>Por haber cambiado su domicilio sin aviso al proveedor, en términos de la cláusula novena del presente contrato.</td></tr>
          <tr><td valign="top" width="20">C)</td><td>Es motivo de rescisión de contrato el vencimiento de dos o más pagarés, si en su caso lo considera conveniente el Vendedor.</td></tr>
        </table>
      </div>
      <p class="space"><b>Octava.</b> El Vendedor se hace responsable de cualquier situación legal que anteceda a la fecha de la Compra-Venta relacionada con el vehículo anteriormente descrito sin ninguna responsabilidad para el comprador.</p>
      <p class="space"><b>Novena.</b> Por la rescisión del presente contrato se penalizará económicamente por la cantidad de $5,000 (CINCO MIL PESOS 00/100 M.N.) más la cantidad de $250 (DOSCIENTOS CINCUENTA PESOS 00/100 M.N.) diarios por concepto de pago de renta por el uso del vehículo a partir de la firma del presente contrato y hasta la rescisión del mismo.</p>
      <p class="space"><b>Décima.</b> Autoriza el Comprador que al vencimiento de 1 (UN) pagaré, el vehículo quedará en calidad de depósito en el domicilio del “Vendedor” hasta en tanto se ponga la cuenta al corriente en el plazo fijado por el Vendedor.</p>
      <p class="space"><b>Décima primera.</b> Para garantizar y asegurar el cumplimiento de todas y cada una de las obligaciones por el Comprador en el presente contrato se le constituye Fiador (a) del Comprador y se le obliga con éste al cumplimiento de dichas obligaciones y acepta expresamente que su responsabilidad no finaliza hasta que termine cualquier causa del presente contrato, como consecuencia de la obligación que contrae en la presente cláusula el Fiador conviene y se le obliga a firmar como avalista los pagarés expedidos por el Vendedor.</p>
      <table width="450" class="space">
         <tr> <td  width="90">Fiador:</td> <td>Evaristo Vega de la Cruz.</td> </tr>
         <tr> <td  width="90">Parentesco:</td> <td>Hermanos</td> </tr>
         <tr> <td  width="90">Domicilio:</td> <td>Priv. Simón Bolivar #263 Col. Carolinas. En Torreón, Coah.</td> </tr>
         <tr> <td  width="90">Teléfono:</td> <td>87-11-22-22-22</td> </tr> 
      </table>
      <p class="space"><b>Décima segunda:</b> Para todos los efectos legales de este contrato, los contrayentes se someten a la competencia del la Procuraduría Federal del Consumidor y tribunales del lugar en que se haya suscrito en el presente contrato, se regirá por las disposiciones aplicables de la Ley de Protección al Consumidor.</p>
      <div class="col-xs-12">
          <div class="fir">Vendedor<br> Ing. Mauricio Eduardo Torres Nava</div>
          <div class="fir">Comprador<br> Christian Jorge Hernández Acosta</div>
      </div>
      <div class="col-xs-12">
          <div class="fir">1er Fiador<br>Evaristo Vega de la Cruz</div>
          <div class="fir">2do Fiador</div>
      </div>
      <p class="col-xs-12 bottom">Contrato Registrado ante la Procuraduría Federal del Consumidor bajo el No. De registro 4882-2011 de fecha 20 de junio de 2011, emitido por el ciudadano Carlos Meneses Toribio y solo podrá ser utilizado por socios activos de la Asociación Nacional de Comerciantes en Automóviles y Camiones Usados, A.C., quedando estrictamente prohibido su uso por particulares o personas morales afiliados a la A.N.C.A., A.C.</p>
  </div>
</body>
</html>