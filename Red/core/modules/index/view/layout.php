<?php

if(Session::exists("user_id")){
  Session::$user = UserData::getById(Session::get("user_id"));
  Session::$profile = ProfileData::getByUserId(Session::get("user_id"));
}

?>
<html>
<head>
<title>Carmen Verde</title>
<link rel="stylesheet" type="text/css" href="res/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="res/messages.css">
<script src="res/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="res/font-awesome/css/font-awesome.min.css">
<!-- bootstrap css -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<!-- style css -->
<link rel="stylesheet" href="../css/style.css">
<!-- Responsive-->
<link rel="stylesheet" href="../css/responsive.css">  
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
<!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body>
<header  role="banner">
<!--  ediciones  -->
    <!-- header inner -->
<!--  ediciones -->
    <div class="header-top">
      <div class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-3 col logo_section">
              <div class="full">
                <div class="center-desk">
                  <div class="logo">
                    <a href="../index.php"><img src="../images/Logo_Verde.png" alt="#" /></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-9">         
               <div class="menu-area">
                <div class="limit-box">
                  <nav class="main-menu ">
                    <ul class="menu-area-main">                      
                     
                    <?php if(!Session::exists("user_id")):?>
                      <li><a href="./">Inicio</a></li>
                        <?php else:?>
                      <li><a href="./?view=home">Inicio</a></li>
                          <?php endif; ?>                              
                      <li > <a href="../Menu/Mapas.php">Mapas</a> </li>
                      <li class="active"> <a href="../Menu/Instituciones.php">Instituciones</a> </li>                                                                 
                     </ul>
                   </nav>
                     <?php if(Session::exists("user_id")):?>
                      <form class="navbar-form navbar-left" role="search">
                      <div class="form-group">
                        <input type="hidden" name="view" value="search">
                        <input type="text" class="form-control" name="q" placeholder="Buscar personas ...">
                      </div>
                      <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>     
                      </form>
                      <?php endif; ?>

                     
                 </div>
               </div> 
              </div>
           </div>
         </div>
       </div>
     </div>
     <!-- end header inner -->
    </div>
     <!--  ediciones  -->


<ul class="nav navbar-nav navbar-right">
<?php if(Session::exists("user_id")):
$conversations = ConversationData::getConversations($_SESSION["user_id"]);
$nmsgs = 0;
foreach ($conversations as $conversation) {
  $nmsg = MessageData::countUnReadsByUC($_SESSION["user_id"],$conversation->id);
//  print_r($nmsg);
  $nmsgs += $nmsg->c;
}
$nnots = NotificationData::countUnReads($_SESSION["user_id"]);
?>
<li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="label <?php if($nnots->c>0){ echo "label-danger"; }else{ echo "label-default"; }?>"><?php echo $nnots->c;?></span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              <?php if($nnots->c>0):
              $notifications=NotificationData::getLast5($_SESSION["user_id"]);
              ?>

                <li class="dropdown-header"><?php echo $nnots->c; ?> Notificaciones</li>
                <?php foreach($notifications as $noti):
                $s = $noti->getSender();
                $sp = ProfileData::getByUserId($s->id);
                $img_url ="";
                if($sp->image!=""){
                $img_url = "storage/users/".$s->id."/profile/".$sp->image;
                }
                ?>
                <li class="message-preview">
                  <a href="#" >
                    <span class="avatar"><img src="<?php echo $img_url; ?>" style='width:40px;'></span>
                    <span class="name"><?php echo $s->getFullname(); ?></span>
                    <span class="message">
                    <?php if($noti->not_type_id==1){ echo "<i class='fa fa-thumbs-up'></i> Nuevo Like"; }
                    else if($noti->not_type_id==2){ echo "<i class='fa fa-comment'></i> Nuevo Comentario"; }
                    ?>
                    en 
                    <?php if($noti->type_id==1){ echo "Publicacion"; }
                    else if($noti->type_id==2){ echo "Imagen"; }
                    ?>
                    </span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
              <?php endforeach; ?>
              <?php endif; ?>
                <li><a href="./?view=notifications">Ver notificaciones</a></li>
              </ul>
            </li>
        
<li><a href="./?view=friendreqs"><i class="fa fa-male"></i> <?php $fq = FriendData::countUnReads(Session::$user->id); if($fq->c>0){ echo "<span class='label label-danger'>$fq->c</span>";} else{ echo "<span class='label label-default'>0</span>";} ?></a></li>
<li><a href="./?view=conversations"><i class="fa fa-envelope-o"></i> <?php if($nmsgs>0){ echo "<span class='label label-danger'>$nmsgs</span>";} else{ echo "<span class='label label-default'>0</span>";} ?></a></li>

<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Session::$user->name;?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="./?view=home">Perfil</a></li>
          <li><a href="./?view=user&id=<?php echo Session::$user->id; ?>">Perfil Publico</a></li>
          <li><a href="./?view=editinformation">Editar Informacion</a></li>
          <li><a href="./?view=configuration">Configuraci&oacute;n</a></li>
          <li class="divider"></li>
          <li><a href="./?action=processlogout">Salir</a></li>
        </ul>
      </li>
  <?php else:?>
<li>
      <form class="navbar-form navbar-left" role="search" method="post" action="./?action=processlogin">
      <div class="form-group">
      <input type="hidden" name="r" value="search/results">
<div class="row">
<div class="col-md-6">
        <input type="text"  name="email" class="form-control" placeholder="Email" required>
</div>
<div class="col-md-6">
        <input type="password"  name="password" class="form-control" placeholder="Contrase&ntilde;a" required>
</div>
</div>
      </div>
      <button type="submit" class="btn btn-default">Entrar</button>
    </form>
</li>
<?php endif; ?>
</ul>


    
  </div>
</header>
<!-- - - - - - - - - - - - - - - -->
<?php 
	View::load("index");
?>
<!-- - - - - - - - - - - - - - - -->
<br><br>
<div class="container">
<div class="row">
<div class="col-md-12">
<hr/>
</div>
</div>
<div class="row">
    <div class="col-md-3">
</div>
  </div>
    <div class="row">
      
    </div>
  </div>
<br>
    <!--  footer -->
    <footr>
      <div class="footer ">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
             <a href="#" class="logo_footer"> <img src="../images/logo_verde_2.png" alt="#"/></a>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
              <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                  <div class="address">
                    <h3>Direcciones</h3>
                    <ul class="loca">
                      <li>
                        <a href="#"></a>Comunicate con
                        <br>Nosotros</li>
                        <li>
                          <a href="#"></a>(+52 9384567890) </li>
                          <li>
                            <a href="#"></a>CarmenVerde@SocialVerde.com</li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="address">
                          <h3>Redes Sociales</h3>
                          <ul class="Menu_footer">
                            <li class="active"><a href="https://twitter.com/?lang=es"><img src="../icon/Redes_Sociales/twitter.png" alt="twitter">  Twitter</a> </li>
                            <li><a href="https://es-la.facebook.com/"><img src="../icon/Redes_Sociales/facebook.png" alt="Facebook">  Facebook</a> </li>                            
                            <li><a href="https://www.instagram.com/?hl=es"><img src="../icon/Redes_Sociales/instagram.png" alt="Instagram">  Instagram</a> </li>
                            <li><a href="https://www.youtube.com/"><img src="../icon/Redes_Sociales/youtube.png" alt="Youtube">  Youtube</a> </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-6 ">
                        <div class="address">
                          <h3>Mas Informacion</h3>
                          <ul class="loca">                            
                            <li><a">  Terminos y Condiciones</a> </li>                            
                            <li><a>  Politicas</a> </li>                            
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="copyright">
                <div class="container">
                  <p>Copyright © 2021 Desarrollado por <a href="https://www.unacar.mx/"> Estudiantes de la Universidad Autonoma del Carmen</a></p>
                </div>
              </div>
            </div>
          </footr>
          <!-- end footer -->

<script src="res/jquery.min.js"></script>
<script src="res/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>