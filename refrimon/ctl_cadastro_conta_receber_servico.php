<?php

   $acao = $_POST['acao'];
   $acao_cadastro = $_POST['acao_cadastro'];
   $acao_cadastro_conta = $_POST['acao_cadastro_conta'];
   $chamada_selecionada = $_POST['chamada_selecionada'];
   $conta_selecionada = $_POST['conta_selecionada'];
   $cliente_selecionado = $_POST['cliente_selecionado'];
   $dados_servico = $_POST['dados_servico'];
   
   $inic = $_POST['inic'];
   $lista_contas_receber = $_POST['lista_contas_receber'];

   $data_recebimento = $_POST['data_recebimento'];

   $modo_listagem = $_POST['modo_listagem'];
   $servico_selecionado = $_POST['servico_selecionado'];
   $tela_anterior = $_POST['tela_anterior'];
   $valor_conta = $_POST['valor_conta'];

   $lista_pecas_usadas = $_POST['lista_pecas_usadas'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $veiculo_selecionado = $_POST['veiculo_selecionado'];


   switch($acao_cadastro_conta)
   {
      case "voltar":
         include("cadastro_servico.php");
         break;
      case "incluir":
         include("comum/comum.inc");
         if(!$valor_conta=formata_decimal_mysql($valor_conta))
            $aviso = "Valor da conta inv&aacute;lido";
         if((!$aviso)&&(!$data_aux=formata_data_mysql($data_recebimento)))
            $aviso = "Data de recebimento inv&aacute;lida";
         if(!$aviso)
         {
            if(!isset($lista_contas_receber))
               $i=1;
            else
               $i=count($lista_contas_receber)+1;
            $lista_contas_receber[$i]["data"]=$data_recebimento;
            $lista_contas_receber[$i]["valor"]=$valor_conta;
         }
         include("cadastro_conta_receber_servico.php");
         break;
      case "excluir":
         if(isset($conta_selecionada)) {
            if($lista_contas_receber[$conta_selecionada]["ANTIGA"]=="SIM")
              $lista_contas_receber[$conta_selecionada]["ANTIGA"] = "APAGAR";
            else
              unset($lista_contas_receber[$conta_selecionada]);
         }
         else
            $aviso = "Selecione uma conta para excluir da lista";
         include("cadastro_conta_receber_servico.php");
         break;
   }
?>
