<?php



   $acao  =  $_POST['acao'];
   $acao_cadastro  =  $_POST['acao_cadastro'];
   $chamada_selecionada = $_POST['chamada_selecionada'];
   $cliente_selecionado = $_POST['cliente_selecionado'];
   $dados_servico = $_POST['dados_servico']; #ARRAY

   $lista_contas_receber = $_POST['lista_contas_receber'];
   $valor_pago_mysql = $_POST['valor_pago_mysql'];
   $chk_nao_apagar_chamada = $_POST['chk_nao_apagar_chamada'];
   
   $inic = $_POST['inic'];
   $lista_pecas_usadas = $_POST['lista_pecas_usadas'];
   $modo_listagem =  $_POST['modo_listagem'];
   $servico_selecionado =  $_POST['servico_selecionado'];
   $tela_anterior =  $_POST['tela_anterior'];
   $valor_pesquisa =  $_POST['valor_pesquisa'];
   $veiculo_selecionado =  $_POST['veiculo_selecionado'];


   switch($acao_cadastro)
   {
      case "seleciona_chamada":
         include("cadastro_servico.php");
         break;
      case "pecas_usadas":
         include("cadastro_peca_usada_servico.php");
         break;
      case "pagamentos":
         include("cadastro_conta_receber_servico.php");
         break;
      case "voltar":
         include($tela_anterior);
         break;
      case "confirmar":
         include("comum/acsbd.php");
         include("comum/comum.php");
         if(!$data_mysql=formata_data_mysql($dados_servico["data"]))
            $aviso = "Data inv&aacute;lida";
         if(!$aviso)
            if(!$valor_mysql=formata_decimal_mysql($dados_servico["valor"]))
               $aviso = "Valor do servi&ccedil;o inv&aacute;lido";
         if($acao=="incluir_servico") {
           if(!$aviso)
              if(!$valor_pago_mysql=formata_decimal_mysql($dados_servico["valor_pago"]))
                 $aviso = "Valor pago inv&aacute;lido";
           if(!$aviso)
              if(($valor_pago_mysql+0)>($valor_mysql+0))
                 $aviso="Valor pago &eacute; maior que o valor do servi&ccedil;o";
           if(!$aviso)
              if((($valor_pago_mysql+0)<($valor_mysql+0))&&(empty($lista_contas_receber)))
                 $aviso="Deve-se agendar o pagamento do restante da conta";
           if(!$aviso)
              if(isset($lista_contas_receber))
              {
                 reset($lista_contas_receber);
                 $valor_total=$valor_pago_mysql+0;
                 while(list($i,$conta)=each($lista_contas_receber))
                    $valor_total+=$conta["valor"];
                 if($valor_total>($valor_mysql+0))
                    $aviso="Valor total previsto para pagamento &eacute; maior que o valor estipulado";
              }
         }
         if($aviso)
            include("cadastro_servico.php");
         else
         {
            $dados_servico["data"]=$data_mysql;
            $dados_servico["valor"]=$valor_mysql;
            $acsbd = new AcsBD();
            $acsbd->conectar();
            if($acao=="incluir_servico")
            {
               $dados_servico["valor_pago"]=$valor_pago_mysql;
               $dados_servico["id_cliente"]=$cliente_selecionado;
               if((isset($chamada_selecionada))&&($chamada_selecionada!='NENHUMA'))
                 $dados_servico["id_chamada"] = $chamada_selecionada;
               else
                 $dados_servico["id_chamada"] = $acsbd->obtem_novo_id_chamada();
               $acsbd->inclui_servico($dados_servico);
               $dados_servico["id_servico"] = $acsbd->obtem_codigo_gerado();
               if(isset($dados_servico["valor_pago"])&&($dados_servico["valor_pago"]!=0))
                  $acsbd->inclui_conta_recebida($dados_servico["id_servico"],$dados_servico["data"],$dados_servico["valor_pago"]);
               if((isset($chamada_selecionada))&&($chamda_selecionada!="NENHUMA")&&(!isset($chk_nao_apagar_chamada)))
                  $acsbd->exclui_chamada($chamada_selecionada);
            }
            elseif($acao=="editar_servico") {
               $dados_servico["id_servico"]=$servico_selecionado;
               $acsbd->altera_servico($dados_servico);
            }
            if(isset($lista_pecas_usadas))
            {
               reset($lista_pecas_usadas);
               while(list($k,$registro)=each($lista_pecas_usadas))
                 if((!isset($registro["ANTIGA"]))||($registro["ANTIGA"])=="")
                 {
                    if($veiculo_selecionado!=0)
                       $acsbd->registra_peca_usada_veiculo($veiculo_selecionado,$registro["id_peca"],$registro["quantidade"],$dados_servico["data"]);
                    $acsbd->registra_peca_usada_servico($dados_servico["id_servico"],$registro["id_peca"],$registro["quantidade"]);
                    $acsbd->diminui_quantidade_peca($registro["id_peca"],$registro["quantidade"]);
                 }
            }
            if(isset($lista_contas_receber))
            {
               reset($lista_contas_receber);
               while(list($i,$conta)=each($lista_contas_receber))
                 if((!isset($conta["ANTIGA"]))||($conta["ANTIGA"])=="")
                    $acsbd->inclui_conta_receber($dados_servico["id_servico"],formata_data_mysql($conta["data"]),$conta["valor"]);
                 elseif($conta["ANTIGA"]=="APAGAR") {
                    $acsbd->exclui_conta_receber($conta["id_conta"]);
                 }
            }
            $acsbd->desconectar();
            include($tela_anterior);
         }
         break;

   }
?>
