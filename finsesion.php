<?php 
	  require_once('sesion.php');
	  require_once('conn.php');


	  $estado = "UPDATE usuario SET Estado = 'off' WHERE Nombre = '$_SESSION[user]'";
	  mysqli_query($db,$estado);

      session_start();



      session_destroy();
      header('Location: index.php');
 ?>