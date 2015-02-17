<?php
   $acao = $_POST['acao'];
   $acao_cadastro = $_POST['acao_cadastro'];
   $dados = $_POST['dados'];
   $fornecedor_selecionado = $_POST['fornecedor_selecionado'];
 
   include("comum/acsbd.inc");
   if($acao_cadastro=='voltar')
      include("lista_fornecedor.php");
   elseif($acao_cadastro=='confirmar')
   {
      $acsbd = new AcsBD();
      $acsbd->conectar();
      switch($acao)
      {
         case "incluir":
            $acsbd->inclui_fornecedor($dados);
            break;
         case "editar":
            $acsbd->altera_fornecedor($fornecedor_selecionado,$dados);
            break;
      }
      $acsbd->desconectar();
      include("lista_fornecedor.php");
   }
?>
