<?php

   $acao = $_POST['acao'];
   $acao_cadastro_conta = $_POST['acao_cadastro_conta'];
   $acao_conta = $_POST['acao_conta'];

   $cliente_selecionado = $_POST['cliente_selecionado'];
   $conta_receber_selecionada = $_POST['conta_receber_selecionada'];
   $dados_conta_recebida = $_POST['dados_conta_recebida'];
   $lista_contas_receber = $_POST['lista_contas_receber'];
   $lista_contas_restantes = $_POST['lista_contas_restantes'];

   $inic = $_POST['inic']; 
   $modo_listagem = $_POST['modo_listagem'];
   $valor_pesquisa = $_POST['valor_pesquisa'];


   switch($acao_cadastro_conta)
   {
      case "voltar":
         include("cadastro_recebimento_conta.php");
         break;
      case "incluir":
         include("comum/comum.inc");
         if(!$valor_conta=formata_decimal_mysql($valor_conta))
            $aviso = "Valor da conta inv&aacute;lido";
         if((!$aviso)&&(!$data_aux=formata_data_mysql($data_recebimento)))
            $aviso = "Data de recebimento inv&aacute;lida";
         if(!$aviso)
         {
            if(!isset($lista_contas_restantes))
               $i=1;
            else
               $i=count($lista_contas_restantes)+1;
            $lista_contas_restantes[$i]["data"]=$data_recebimento;
            $lista_contas_restantes[$i]["valor"]=$valor_conta;
         }
         include("cadastro_conta_receber_recebimento.php");
         break;
      case "excluir":
         if(isset($conta_cadastro_selecionada))
            unset($lista_contas_restantes[$conta_cadastro_selecionada]);
         else
            $aviso = "Selecione uma conta para excluir da lista";
         include("cadastro_conta_receber_recebimento.php");
         break;
      case "confirmar":
         $valor_pago = $dados_conta_recebida["valor"]+$lista_contas_receber[$conta_receber_selecionada]["valor_pago"];
         if(($valor_pago<$lista_contas_receber[$conta_receber_selecionada]["valor"])&&(empty($lista_contas_restantes)))
            $aviso="Deve-se agendar o pr&oacute;ximo pagamento";
         if(!$aviso)
         {
            $valor_previsto_total=$valor_pago;
            if(isset($lista_contas_restantes))
            {
               reset($lista_contas_restantes);
               while(list($i,$conta)=each($lista_contas_restantes))
                  $valor_previsto_total+=$conta["valor"];
            }
            if($valor_previsto_total>$lista_contas_receber[$conta_receber_selecionada]["valor"])
               $aviso="O valor total previsto para o pagamento excede o valor do servi&ccedil;o";
         }
         if(!$aviso)
         {
            include("comum/comum.inc");
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->inclui_conta_recebida($lista_contas_receber[$conta_receber_selecionada]["id_servico"],formata_data_mysql($dados_conta_recebida["data"]),$dados_conta_recebida["valor"]);
            $acsbd->exclui_contas_receber_servico($lista_contas_receber[$conta_receber_selecionada]["id_servico"]);
            if(!empty($lista_contas_restantes))
            {
               reset($lista_contas_restantes);
               while(list($i,$conta)=each($lista_contas_restantes))
                  $acsbd->inclui_conta_receber($lista_contas_receber[$conta_receber_selecionada]["id_servico"],formata_data_mysql($conta["data"]),$conta["valor"]);
            }
            $acsbd->desconectar();
            include("lista_cliente.php");
         }
         else
            include("cadastro_conta_receber_recebimento.php");
         break;
   }
?>
