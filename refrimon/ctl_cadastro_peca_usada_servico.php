<?php
   $acao = $_POST['acao'];
   $acao_cadastro = $_POST['acao_cadastro'];
   $acao_listagem_peca = $_POST['acao_listagem_peca'];
   $chamada_selecionada = $_POST['chamada_selecionada'];
   $cliente_selecionado = $_POST['cliente_selecionado'];
   $dados_servico = $_POST['dados_servico'];
   $inic = $_POST['inic'];
   $lista_pecas_usadas = $_POST['lista_pecas_usadas'];
   $modo_listagem = $_POST['modo_listagem'];
   $modo_listagem_peca = $_POST['modo_listagem_peca'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $qtd_usada = $_POST['qtd_usada'];
   $servico_selecionado = $_POST['servico_selecionado'];
   $tela_anterior = $_POST['tela_anterior'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $valor_pesquisa_peca = $_POST['valor_pesquisa_peca'];
   $veiculo_selecionado = $_POST['veiculo_selecionado'];

   switch($acao_listagem_peca)
   {
      case "voltar":
         include("cadastro_servico.php");
         break;
      case "listar":
         include("cadastro_peca_usada_servico.php");
         break;
      case "incluir":
         if(isset($peca_selecionada))
         {
            include("comum/comum.inc");
            if(!$qtd_usada=formata_decimal_mysql($qtd_usada))
               $aviso = "Quantidade usada inv&aacute;lida";
            if(!$aviso)
            {
               include("comum/acsbd.inc");
               $acsbd = new AcsBD();
               $acsbd->conectar(); 
               $peca = $acsbd->obtem_dados_peca($peca_selecionada);
               $acsbd->desconectar();
               if($qtd_usada<=$peca["quantidade"])
               {
                  $nova_peca_usada["id_peca"]=$peca_selecionada;
                  $nova_peca_usada["quantidade"]=$qtd_usada;
                  $nova_peca_usada["prefixo_nome"]=$peca["prefixo"]." - ".$peca["nm_peca"];
                  $nova_peca_usada["unidade"]=$peca["unidade"];
                  $lista_pecas_usadas[] = $nova_peca_usada;
               }
               else
                  $aviso="Quantidade em estoque ( ".$peca["quantidade"]." ".$peca["unidade"]." ) da peca '".$peca["prefixo"]."-".$peca["nm_peca"]."' &eacute; menor do que a requisitada";
            }
         }
         else
            $aviso = "Selecione uma pe&ccedil;a para adicionar à lista";
         include("cadastro_peca_usada_servico.php");
         break;
      case "excluir":
         if(isset($peca_usada_selecionada))
            unset($lista_pecas_usadas[$peca_usada_selecionada]);
         else
            $aviso = "Selecione uma pe&ccedil;a para excluir da lista";
         include("cadastro_peca_usada_servico.php");
         break;
      case "muda_qtd":
         if(isset($peca_usada_selecionada))
         {
            include("comum/comum.inc");
            if(!$qtd_usada=formata_decimal_mysql($qtd_usada))
               $aviso = "Quantidade usada inv&aacute;lida";
            if(!$aviso)
               $lista_pecas_usadas[$peca_usada_selecionada]["quantidade"]=$qtd_usada;
         }
         else
            $aviso = "Selecione uma pe&ccedil;a para mudar a quantidade usada";
         include("cadastro_peca_usada_servico.php");
         break;
   }
?>
