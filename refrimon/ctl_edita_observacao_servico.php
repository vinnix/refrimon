<?php
   switch($acao)
   {
      case 'voltar':
         include($tela_anterior);
         break;
      case 'confirmar':
         include("comum/acsbd.inc");
         $acsbd = new AcsBD();
         $acsbd->conectar();
         $acsbd->altera_observacao_servico($servico_selecionado,$dados_servico["observacao"]);
         $acsbd->desconectar();
         include($tela_anterior);
         break;
   }
?>
