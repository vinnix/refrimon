<?php
   $acao = $_POST['acao'];
   $usuario_selecionado = $_POST['usuario_selecionado'];
   $usuarios = $_POST['usuarios'];


   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      switch($acao)
      {
         case 'listar':
            include("lista_peca_usada_usuario.php");
            break;
         case 'zerar':
            include("zera_peca_usada_usuario.php");
            break;
      }
   }
?>
