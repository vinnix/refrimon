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
            $acsbd->exclui_peca_usada_usuario($usuario_selecionado);
            $acsbd->desconectar();
            include("lista_peca_usada_usuario.php");
            break;
         case "voltar":
            include("lista_peca_usada_usuario.php");
           break;
      }
   }
?>
