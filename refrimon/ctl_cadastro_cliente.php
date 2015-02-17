<?php
   include("comum/acsbd.inc");

   $acao_cadastro = $_POST['acao_cadastro'];
   $acao = $_POST['acao'];
   $dados = $_POST['dados'];
   $cliente_selecionado = $_POST['cliente_selecionado'];


   if($acao_cadastro=='voltar')
      include("lista_cliente.php");
   elseif($acao_cadastro=='confirmar')
   {
      $acsbd = new AcsBD();
      $acsbd->conectar();
      switch($acao)
      {
         case "incluir":
            $acsbd->inclui_cliente($dados);
            break;
         case "editar":
            $acsbd->altera_cliente($cliente_selecionado,$dados);
            break;
      }
      $acsbd->desconectar();
      include("lista_cliente.php");
   }
?>
