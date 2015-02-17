<?php
   switch($acao)
   {
      case "incluir":
         include("comum/acsbd.inc");
         $acsbd = new AcsBD();
         $acsbd->conectar();
         $acsbd->inclui_veiculo($nm_novo_veiculo);
         $acsbd->desconectar();
         include("cadastro_veiculo.php");
         break;
      case "excluir":
         if(!isset($veiculo_selecionado))
            $aviso="Selecione um ve&iacute;culo para excluir";
         else
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $lista_pecas_usadas = $acsbd->obtem_lista_peca_usada_veiculo($veiculo_selecionado);
            if(!empty($lista_pecas_usadas))
               $aviso="Este ve&iacute;culo n&atilde;o pode ser excluido pois tem pe&ccedil;as a serem repostas";
            else
               $acsbd->exclui_veiculo($veiculo_selecionado);
            $acsbd->desconectar();
         }
         include("cadastro_veiculo.php");
         break;
   }
?>
