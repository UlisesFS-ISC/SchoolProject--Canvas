<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/foundation.css">
  <script src="js/js/jquery-1.11.2.min.js"></script>
	<script src="js/modernizr.js"></script>
   <script type="text/javascript">
  jQuery(document).ready(function ($) {
    $.post("numeros.php",function(resultado){
         $("#contenido").append(resultado);
        });
    setInterval(function(){
       $.post("numeros.php",function(resultado){
         $("#contenido").append(resultado);
        });
  }, 5000);
  });
</script>
	<title>Grid</title>
</head>
<body>
	 <div class="row menufondo fondo">
    <div class="large-3 columns fondo2">
      <h1 class = "letra">Servidor</h1>
    </div>
    <div class="large-9 columns fondo2">
      <ul class="right button-group">
      <li><a href="index.php" class="button">Inicio</a></li>
      
       <?php 
        require_once('sesion.php');
        if ($estado) {   
      ?>
         <li><a href="graficar.php" class="button">Grafica</a></li>
         li><a href="finsesion.php" class="button">Close</a></li>
     <?php
        }else{
       ?>
      <li><a href=""data-reveal-id="myModal" class="button">Login</a></li>
      <li><a href="registro.php" class="button">Registrate</a></li>
         <?php
        }
        if ($admin) {
          ?>
          <li><a href="operaciones.php" class="button">Operaciones</a></li>
          <?php
        }
        ?>
      </ul>
     </div>
   </div>
  <div class="row">
    <div id="myModal"  class="reveal-modal large-centered" data-reveal >
        <form method="post" action="login.php">
            <h3>Login</h3>
            <input name="login" type="text" placeholder="Ingrese usuario"/>
            <input name="pass" type="password" placeholder="Ingrese contraseña"/>
            <button type="submit"  class="colorbutton">Iniciar Sesion</button>
        </form>
        <a class="close-reveal-modal">&#215;</a>
    </div>
  </div>

    <div class="row">
      <div class="large-12 columns">
        <div id="slider"></div>
        <hr/>
      </div>
   </div>

  <?php 
        
        if ($estado) {   
      ?>  
   <div class="row fondo">
      <div class="large-12 columns">
        <div class="panel color">
          <div class="large-6 columns large-centered">
            
               <table>
                <thead>
                <tr>
                </tr>
                </thead>
              <tbody id="contenido">  
              </tbody>
              </table>
        </div>
        </div>
      </div>
  </div>
      <?php
        }
        ?>
 
<div class="row">
    <div class="large-12 columns">
    
      <div class="panel color">
        <h4>Sugerencias</h4>
            
        <div class="row">
          <div class="large-9 columns">
            <p>Nos gustaria mucho escuchar tu opinion</p>
          </div>
          <div class="large-3 columns">
            <a href="#" class="radius button right contacto">Contactanos</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
 
   
  
  <footer class="row">
    <div class="large-12 columns">
      <hr/>
      <div class="row">
        <div class="large-6 columns">
          <p>Biblioteca</p>
        </div>
        <div class="large-6 columns">
          <ul class="inline-list right">
            <li><a href="index.php" >Inicio</a></li>
      
       <?php 
        require_once('sesion.php');
        if ($estado) {   
      ?>
         <li><a href="finsesion.php" >Close</a></li>
     <?php
        }else{
       ?>
      <li><a href=""data-reveal-id="myModal" >Login</a></li>
      <li><a href="registro.php" >Registrate</a></li>
         <?php
        }
        if ($admin) {
          ?>
          <li><a href="operaciones.php" >Operaciones</a></li>
          <?php
        }
        ?>
          </ul>
        </div>
      </div>
    </div> 
  </footer>
	
</body>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>
</html>