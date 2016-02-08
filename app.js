function enganches (eng) {
    $("#PagosEnganche").html("");
	for ( var i = 1; i <= eng; i++) {
         $("#PagosEnganche").append('<input name="pre_fpe['+i+']" class="form-control" type="date" >');
	}

  costototal();
}

$("#pre_intereses").keyup(function(){ 
   var pre=$(this).val();
   $("#pre_iva").val(pre*.16);
   costototal();
 });

function anualidades (anu) {
  $("#NumAnualidades").html("");
	for ( var i = 1; i <= anu; i++) {
         $("#NumAnualidades").append('<input name="pre_fpa['+i+']" class="form-control" type="date">');
	}
  costototal();
}

function costototal(){
  var pre_precio=  $(formatable.pre_precio).val();  /// + más precio venta
  var pre_enganche=  $(formatable.pre_enganche).val(); /// - menos enganche
  var pre_gps=  $(formatable.pre_gps).val(); /// + cobro GPS si es que tiene
  if (pre_gps==0) { pre_gps = 0;} else pre_gps=3800;

  var saldo = pre_precio-pre_enganche+pre_gps;  /// SALDO

  var NumMeses=$(formatable.pre_nummensualidades).val();    
  var porcentaje_in= (saldo*1.5/100)*NumMeses; // más el porcentaje de intereses (1.5% de el saldo) NOTA: 1.5% de cada mensualidad

  var iva = $(formatable.pre_intereses).val()*.16;    

  var total = saldo + porcentaje_in + iva;

  console.log("+ Precio de venta"+pre_precio);
  console.log("- Enganche"+pre_enganche);
  console.log("+ GPS"+pre_gps);
  console.log("Saldo= Precio de venta - Enganche + GPS: "+saldo);
  console.log("Número de meses: "+NumMeses);
  console.log("Porcentaje de Intereses (cda mes)= 1.5% Saldo: "+porcentaje_in);
  console.log("IVA= Intereses 16%"+iva);
  console.log("Total = Saldo + Porcentaje de intereses + IVA"+total);
  
  $("#pre_costototal").val(total);
}