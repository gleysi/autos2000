function unidad(ve_id){
    $(".vehicu").show();
    $.ajax({
              type: 'post',
              dataType: "json",
              url: 'verificapro.php',
              contentType: "application/x-www-form-urlencoded",
              processData: true,
              data:"ve_id="+ve_id,
              success: function(response){
                  $("#ve_marca").val(response.ve_marca); 
                  $("#und_marca").val(response.ve_marca); 
                  $("#ve_tipo").val(response.ve_tipo); 
                  $("#und_tipo").val(response.ve_tipo); 
                  $("#ve_modelo").val(response.ve_modelo); 
                  $("#und_modelo").val(response.ve_modelo); 
                  $("#att_vu").val(response.att_vu); 
                  $(".att_precioventa").val(response.att_precioventa); 
                  $("#und_numserie").val(response.und_numserie); 
                  $("#und_motor").val(response.und_motor); 
                  $("#und_color").val(response.und_color); 
              }
    });
    setTimeout(function() { costototal();}, 2000);
   // costototal();
}

function enganches (eng) {
  $("#PagosEnganche").html("");
	for ( var i = 1; i <= eng; i++) {
         $("#PagosEnganche").append('<input name="pre_fpe['+i+']" class="form-control" type="date" >');
	}

  costototal();
}

// hacerla funcion
/*$("#pre_intereses").keyup(function(){ 
   var pre=$(this).val();
   $("#pre_iva").val(pre*.16);
   costototal();
 });*/

function anualidades (anu) {

  $("#NumAnualidades").html("");
	for ( var i = 1; i <= anu; i++) {
         $("#NumAnualidades").append('<input name="pre_fpa['+i+']" class="form-control" type="date">');
	}
  var CuanAnu = $("#pre_anualidades").val();
  CalSumMens(CuanAnu);
  costototal();
}

function costototal(){

  if ( $(formatable.ven_tipo).val() == 0 ) { 
    var pre_precio=  $(formatable.pre_precio_contado).val();
  }else { 
    var pre_precio=  $(formatable.pre_precio).val();  /// + más precio venta
  }
  //alert(pre_precio);
  var pre_enganche=  $(formatable.pre_enganche).val(); /// - menos enganche
  var pre_gps=  $(formatable.pre_gps).val(); /// + cobro GPS si es que tiene
  if (pre_gps==0) { pre_gps = 0; } else if(pre_gps=="2") {pre_gps = 1900;} else pre_gps=3800;

  var saldo = pre_precio-pre_enganche+pre_gps;  /// SALDO

  var NumMeses=$(formatable.pre_nummensualidades).val();   

  var InteresesManu = $("#InteresesManu").val(); 
  var porcentaje_in= (saldo*InteresesManu/100)*NumMeses; // más el porcentaje de intereses (1.5% de el saldo) NOTA: 1.5% de cada mensualidad


  // CalInt(InteresesManu);
  var int1 = saldo*NumMeses;
  var pre_intereses = (int1*InteresesManu)/100;
  $("#pre_intereses").val(Math.round(pre_intereses));
  //pre_ivaa(pre_intereses);

  $("#pre_iva").val( Math.round(pre_intereses*.16) );
  /// end CalInt


  var iva = pre_intereses*.16;    
  //var iva = $("#pre_intereses").val()*.16;    

  var total = saldo + porcentaje_in + iva;

  /*console.log("+ Precio de venta"+pre_precio);
  console.log("- Enganche"+pre_enganche);
  console.log("+ GPS"+pre_gps);
  console.log("Subtotal= Precio de venta - Enganche + GPS: "+saldo);
  console.log("Número de meses: "+NumMeses);
  console.log("Porcentaje de Intereses (cda mes)= 1.5% Subtotal: "+porcentaje_in);
  console.log("IVA= Intereses 16%"+iva);
  console.log("Total = Subtotal + Porcentaje de intereses + IVA"+total);*/
  
  $("#pre_costototal").val(Math.round(total));
  $("#subtotal").val(Math.round(saldo));

}

/*$( document ).ready(function() {
  checar($("#cli_id").val());
});*/

function checar(cli_id){
    $("#datoscliente").show();
    if (cli_id=='nuevo' || cli_id=='seleccione' ) {
      $("#cli_nombre, #cli_apellido, #cli_dir1, #cli_dir2, #cli_dir3, #cli_ciudad, #cli_estado, #cli_cp, #cli_tel, #cli_cel, #cli_folio, #cli_rfc").val(''); 
    }else{
      $.ajax({
              type: 'post',
              dataType: "json",
              url: 'verificapro.php',
              contentType: "application/x-www-form-urlencoded",
              processData: true,
              data:"cli_id="+cli_id,
              success: function(response){
                  $("#cli_nombre").val(response.cli_nombre); 
                  $("#cli_apellido").val(response.cli_apellido); 
                  $("#cli_dir1").val(response.cli_dir1); 
                  $("#cli_dir2").val(response.cli_dir2); 
                  $("#cli_dir3").val(response.cli_dir3); 
                  $("#cli_ciudad").val(response.cli_ciudad); 
                  $("#cli_estado").val(response.cli_estado); 
                  $("#cli_cp").val(response.cli_cp); 
                  $("#cli_tel").val(response.cli_tel); 
                  $("#cli_cel").val(response.cli_cel); 
                  $("#cli_folio").val(response.cli_folio); 
                  $("#cli_rfc").val(response.cli_rfc); 
              }
          });
    }
}



function tipoventa (v) {
  if(v==1) {
    $("#tipocontado").hide(); 
    $("#tipocredito").show(); 
    //setTimeout(function() { CalInt(1.5);}, 2000);
  } 
  else {
    $("#tipocontado").show();
    $("#tipocredito").hide();
  } 
}

function CalSumMens (v) {
  var NumAnu = $("#pre_numanualidades").val();
  var total_anu = v*NumAnu;
  $("#total_anualidad").val(total_anu);

  var precostototal = $("#pre_costototal").val();
  var total_mensua = precostototal-total_anu;
  $("#total_mensua").val(total_mensua);

  // calcular cunato por cada mes
  var NumMen = $("#pre_nummensualidades").val();
  $("#pre_mensualidades").val(Math.round(total_mensua/NumMen));
  $("#pre_mensualidadeshome").html(Math.round(total_mensua/NumMen));

}

function unideposito (v) {
   if(v==1) {
    $(".unidadsi").show(); 
  } 
  else {
    $(".unidadsi").hide();
  } 
}

function fiadordos (v) {
   if(v==1) {
    $(".fiadordosi").show(); 
  } 
  else {
    $(".fiadordosi").hide();
  } 
}

function cartas (v) {
   if(v==1) {
    $(".cartasi").show(); 
  } 
  else {
    $(".cartasi").hide();
  } 
}