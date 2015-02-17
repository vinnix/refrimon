<?php
   
   $acao = $_POST['acao'];
   $senha_nova = $_POST['senha_nova'];
   $senha_confirmacao = $_POST['senha_confirmacao'];
   $senha_antiga = $_POST['senha_antiga'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      session_start();
      $nm_usuario =  $_SESSION['nm_usuario'];
      $senha = $_SESSION['senha'];

      if($senha_antiga!=$senha)
         $aviso="Senha antiga n&atilde;o confere";
      if(!$aviso)
         if($senha_nova!=$senha_confirmacao)
            $aviso="A confirma&ccedil;&atilde;o da senha n&atilde;o est&aacute; igual";
      if(!$aviso)
      {
         include("../comum/acsbd.inc");
         $acsbd = new AcsBD();
         $acsbd->conectar();
         $acsbd->altera_senha_usuario($nm_usuario,$senha_nova);
         $acsbd->desconectar();
         $senha = $senha_nova;
         $_SESSION['senha'] = $senha;
         include("senha_trocada.php");
      }
      else
         include("troca_senha.php");
   }
?>
