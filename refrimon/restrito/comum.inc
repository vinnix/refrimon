<?php
   if(!defined("COMUM_RESTRITO_LIB"))
   {
      define("COMUM_RESTRITO_LIB","ON");


      function login_correto()
      {
         session_start();
         if(isset($_SESSION['nm_usuario']))
         {
            $senha = $_SESSION['senha'];
		    $nm_usuario = $_SESSION['nm_usuario'];
            include("../comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $correto = $acsbd->confirmar_login($nm_usuario,$senha);
            $acsbd->desconectar();
         }
         return $correto;
      }
   }
?>
