<?php
   $acao = $_POST['acao'];
   $nm_usuario_peca = $_POST['nm_usuario_peca'];
   $usuario_selecionado = $_POST['usuario_selecionado'];
   $usuarios = $_POST['usuarios'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      switch($acao)
      {
         case 'incluir':
            include("../comum/acsbd.inc");
            $acsbd= new AcsBD;
            $acsbd->conectar();
            $acsbd->inclui_usuario_peca($nm_usuario_peca);
            $acsbd->desconectar();

            include("lista_usuario_peca.php");
            break;
         case 'remover':
            include("remove_usuario_peca.php");
            break;
      }
   }
?>
