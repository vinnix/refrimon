<?php
   $acao = $_POST['acao'];
   $acao_conta = $_POST['acao_conta'];
   $cliente_selecionado = $_POST['cliente_selecionado'];
   $conta_receber_selecionada = $_POST['conta_receber_selecionada'];
   $dados_conta_recebida = $_POST['dados_conta_recebida'];
   $inic = $_POST['inic'];
   $lista_contas_receber = $_POST['lista_contas_receber'];
   $modo_listagem = $_POST['modo_listagem'];
   $valor_pesquisa = $_POST['valor_pesquisa'];


   switch($acao_conta)
   {
      case "muda_conta":
         include("cadastro_recebimento_conta.php");
         break;
      case "voltar":
         include("lista_cliente.php");
         break;
      case "confirmar":
         include("comum/comum.inc");
         if(!$valor_conta_mysql=formata_decimal_mysql($dados_conta_recebida["valor"]))
            $aviso="Valor pago inv&aacute;lido";
         if(!$aviso)
            if(!$data_conta_mysql=formata_data_mysql($dados_conta_recebida["data"]))
               $aviso="Data do pagamento inv&aacute;lida";
         if(!$aviso)
            if(($dados_conta_recebida["valor"]+$lista_contas_receber[$conta_receber_selecionada]["valor_pago"])>$lista_contas_receber[$conta_receber_selecionada]["valor"])
               $aviso="O valor pago ultrapassa o valor total do servi&ccedil;o";
         if(!$aviso)
         {
            $dados_conta_recebida["valor"]=$valor_conta_mysql;
            if(($dados_conta_recebida["valor"]+$lista_contas_receber[$conta_receber_selecionada]["valor_pago"])<$lista_contas_receber[$conta_receber_selecionada]["valor"])
            {
               include("comum/acsbd.inc");
               $acsbd = new AcsBD();
               $acsbd->conectar();
               $lista_contas_restantes=$acsbd->obtem_lista_contas_receber_servico($lista_contas_receber[$conta_receber_selecionada]["id_servico"]);
               $acsbd->desconectar();
               while(list($i,$conta)=each($lista_contas_restantes))
               {
                  $lista_contas_restantes[$i]["data"]=formata_data_padrao($conta["data"]);
                  if($conta["id_conta"]==$lista_contas_receber[$conta_receber_selecionada]["id_conta"])
                     $chave=$i;
               }
               unset($lista_contas_restantes[$chave]);
               include("cadastro_conta_receber_recebimento.php");
            }
            else
               include("confirmacao_conta_encerrada.php");
         }
         else
            include("cadastro_recebimento_conta.php");
         break;
   }
?>
