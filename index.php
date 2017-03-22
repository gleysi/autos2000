<?php   
session_start(); 
require_once("../config.php");
if(isset($_GET["logout"])) {
      session_destroy(); 
}
$error=$incativo=$verificarp=false;
if(isset($_POST['user']) && $_POST['pass']) { 
            $pass=md5($_POST['pass']);
            if ($_POST['pass'] == $_POST['verificarp']) {
               $dato=$sql->Query("SELECT * FROM usuarios WHERE usu_login='".addslashes(strip_tags($_POST['user']))."' AND usu_pass='".addslashes(strip_tags($pass))."' ");
               if($dato->num_rows!=0) {
                  $d=$dato->fetch_object();

                  $suc=$sql->Query("SELECT * FROM sucursales WHERE suc_id='".__($d->suc_id)."' ");
                  if($suc->num_rows>0) $suc=$suc->fetch_object();

                  if ($d->usu_estado==0) {
                    $incativo= true;
                  }else{
                     $_SESSION['idUsr'] = $d->usu_id;
                     $_SESSION['userAdmn'] = $_POST['user'];
                     $_SESSION['alias'] = $d->usu_nombre;
                     $_SESSION['sucursalid'] = $d->suc_id;
                     $_SESSION['sucursal'] = $suc->suc_nombre;
                     $_SESSION['apellidos'] = $d->usu_apellidos;
                      Header("Location: admin.php");
                  }
                  
               } else  $error=true;
            }else  $verificarp=true;
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="shortcut icon" href="<?php echo SITIO; ?>/favicon.ico" type="image/x-icon">
      <link rel="icon" href="<?php echo SITIO; ?>/favicon.ico" type="image/x-icon">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Administrador Autos2000</title>
      <link href="<?php echo MEDIA; ?>/bs/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo MEDIA; ?>/css/estilo.css" rel="stylesheet">
      <script src="<?php echo MEDIA; ?>/js/jquery.min.js"></script>
      <script src="<?php echo MEDIA; ?>/bs/js/bootstrap.min.js"></script>
      <script src="<?php echo MEDIA; ?>/js/autos.js"></script>
      <link  href="<?php echo MEDIA; ?>/css/jquery.cleditor.css" />
      <script src="<?php echo MEDIA; ?>/js/jquery.cleditor.min.js"></script>  
   </head>
   <body>
            <div class="header text-center" style="display:block">
                  <a href="/"><img style="max-width: 200px;" src="<?php echo MEDIA;?>/img/logo.png" alt="Autos2000" border="0"></a><hr>
            </div>
               <div class="col-sm-4"></div>     
               <div class="col-sm-4" style="border-radius: 5px;background-color:#eee;padding-top:15px;padding-bottom:15px;">
                 <?php
                  if ($error) {echo ' <div class="alert alert-danger" role="alert"><b>¡Error!</b> Favor de verificar tu usuario y contraseña.</div>'; } 
                  if($incativo) echo "<div class='alert alert-warning'>Usuario inactivo</div>";
                  if($verificarp) echo "<div class='alert alert-warning'>Las contraseñas no coinciden, por favor vuelva a intentar.</div>";
                 ?>
                     <form class="form-signin" action="index.php" method="post">       
                        <h2 class="form-signin-heading">Login</h2>
                        <input type="text" class="form-control input-sm" name="user" placeholder="Usuario" required autofocus><br>
                        <input type="password" class="form-control input-sm" name="pass" placeholder="Contraseña" required><br> 
                        <input type="password" class="form-control input-sm" name="verificarp" placeholder="Vuelva a escribir la contraseña" required>      
                        <br>
                        <button class="btn btn-sm btn-primary btn-block" type="submit">Entrar</button>   
                     </form>
               </div>
   </body>
</html>