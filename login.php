<?php 
  require_once('conn.php');
  
  $login = $_POST["login"];
  $pass = $_POST["pass"];

  $sesion = "SELECT Nombre FROM usuario WHERE Nombre = '$login' AND Contrasena = '$pass'";
  $data = mysqli_query($db,$sesion);
  if(mysqli_num_rows($data)==0){
  	header('Location: registro.php');
  }
  else {
  	session_start();
  	$_SESSION['user'] = $login;
     mysqli_query($db,"UPDATE usuario SET Estado = 'on' WHERE Nombre = '$_SESSION[user]'");
	header('Location: index.php');

  }

 ?>