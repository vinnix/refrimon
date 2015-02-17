<?php
   if($acao_exibicao=="voltar")
      include("lista_peca.php");
   elseif($acao_exibicao=="confirmar")
   {
      include("comum/acsbd.inc");
      switch($acao)
      {
         case "excluir":
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $existe_peca_usada = $acsbd->existe_peca_usada_servico($peca_selecionada);
            $existe_peca_usada = $existe_peca_usada || $acsbd->existe_peca_usada_usuario($peca_selecionada);
            if($existe_peca_usada)
               $aviso="Esta pe&ccedil;a n&atilde;o pode ser excluida pois existem registros vinculados a ela";
            else
               $acsbd->exclui_peca($peca_selecionada);
            $acsbd->desconectar();
            if($aviso)
               include("exibe_peca.php");
            else
               include("lista_peca.php");
            break;
      }
   }
?>
