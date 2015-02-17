<?php
  $acao = $_POST['acao'];
  $usuario_selecionado = $_POST['usuario_selecionado'];
  $usuarios = $_POST['usuarios'];

   switch($acao)
   {
      case 'listar':
        include("lista_peca_usada_usuario.php");
        break;
   }
?>
