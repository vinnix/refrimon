<?php
   $acao = $_POST['acao'];
   $acao_exibicao = $_POST['acao_exibicao'];
   $fornecedor_selecionado = $_POST['fornecedor_selecionado'];


   if($acao_exibicao=="voltar")
      include("lista_fornecedor.php");
   elseif($acao_exibicao=="confirmar")
   {
      include("comum/acsbd.inc");
      switch($acao)
      {
         case "excluir":
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->exclui_fornecedor($fornecedor_selecionado);
            $acsbd->desconectar();
            include("lista_fornecedor.php");
            break;
      }
   }
?>
