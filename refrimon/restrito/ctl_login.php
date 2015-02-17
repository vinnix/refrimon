<?php
  $acao = $_POST['acao'];
  $nm_usuario = $_POST['nm_usuario'];
  $senha = $_POST['senha'];
  $aceito = $_POST['aceito'];

   switch($acao)
   {
      case 'confirmar':
         include("../comum/acsbd.inc");
         $acsbd = new AcsBD();
         $acsbd->conectar();
         $aceito = $acsbd->confirmar_login($nm_usuario,$senha);
         $acsbd->desconectar();
         if(!isset($aceito) || empty($aceito) || $aceito == "")
         {
            $aviso="Login incorreto";
            include("login.php");
         }
         else
         {
            session_start();
	    $_SESSION['senha'] =  $senha;
	    $_SESSION['nm_usuario'] =  $nm_usuario;
            #session_register('senha','nm_usuario');
            include("menu_restrito.php");
         }
         break;
   }
?>
