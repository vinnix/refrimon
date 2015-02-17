<?php
   $acao = $_POST['acao'];
   $usuario_selecionado = $_POST['usuario_selecionado'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      switch($acao)
      {
         case "confirmar":
            include("../comum/acsbd.inc");
            $acsbd= new AcsBD;
            $acsbd->conectar();
            $acsbd->desativa_usuario_peca($usuario_selecionado);
            $acsbd->desconectar();
            include("lista_usuario_peca.php");
            break;
         case "voltar":
           include("lista_usuario_peca.php");
           break;
      }
   }
?>
