<?php
   switch($acao)
   {
      case "voltar":
         include("lista_cliente.php");
         break;
      case "apagar_chamadas":
         if(empty($chk_apagar))
         {
            $aviso="Selecione as chamadas a apagar";
            include("lista_historico_cliente.php");
         }
         else
         {
            $tela_anterior="lista_historico_cliente.php";
            include("apaga_chamada.php");
         }
         break;
      case "confirmar_exclusao":
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $existe_chamada = $acsbd->existe_chamada_cliente($cliente_selecionado);
            $existe_conta_receber = $acsbd->existe_conta_receber_cliente($cliente_selecionado);
            if(($existe_chamada)&&($existe_conta_receber))
               $straux="chamada(s) e conta(s) a receber";
            elseif(($existe_chamada)&&(!$existe_conta_receber))
               $straux="chamada(s)";
            elseif((!$existe_chamada)&&($existe_conta_receber))
               $straux="conta(s) a receber";
            if($straux)
               $aviso="O cliente n&atilde;o pode ser excluido pois existe(m) $straux pendentes";
            if(!$aviso)
               $acsbd->exclui_cliente($cliente_selecionado);
            $acsbd->desconectar();
            if($aviso)
               include("lista_historico_cliente.php");
            else
               include("lista_cliente.php");
            break;
   }
?>
