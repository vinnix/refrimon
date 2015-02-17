<?php
   include("comum/acsbd.php");
   include("comum/comum.php");

   $acao = $_POST['acao'];
   $acao_cadastro = $_POST['acao_cadastro'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $modo_listagem = $_POST['modo_listagem'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $novo_prefixo = $_POST['novo_prefixo'];
   $dados = $_POST['dados'];
   $nova_unidade = $_POST['nova_unidade'];

   $prefixo_cadastro = $_POST['prefixo_cadastro'];
   $unidade_cadastro = $_POST['unidade_cadastro'];
   $aviso = $_POST['aviso'];
   $dados = $_POST['dados']; 
   $novo_prefixo = $_POST['novo_acao'];
   $nova_unidade = $_POST['nova_unidade'];
   $qtd_min_mysql = $_POST['qtd_min_mysql'];
   $valor_venda_mysql = $_POST['valor_venda_mysql'];

   if($acao_cadastro=='voltar')
      include("lista_peca.php");
   elseif($acao_cadastro=='confirmar')
   {
      $dados["prefixo"]=$prefixo_cadastro;
      $dados["unidade"]=$unidade_cadastro;
      if(!$qtd_min_mysql=formata_decimal_mysql($dados["quantidade_minima"]))
         $aviso = "Quantidade m&iacute;nima inv&aacute;lida";
      if(!$aviso)
         if(!$valor_venda_mysql=formata_decimal_mysql($dados["valor_venda"]))
            $aviso = "Valor de venda inv&aacute;lido   ";
      if($aviso)
         include("cadastro_peca.php");
      else
      {
         if($novo_prefixo!="")
            $dados["prefixo"]=$novo_prefixo;
         if($nova_unidade!="")
            $dados["unidade"]=$nova_unidade;
         $dados["quantidade_minima"]=$qtd_min_mysql;
         $dados["valor_compra"]="";
         if($dados["valor_venda"]!="")
            $dados["valor_venda"]=$valor_venda_mysql;
         $acsbd = new AcsBD();
         $acsbd->conectar();
         switch($acao)
         {
            case "incluir":
               $acsbd->inclui_peca($dados);
               break;
            case "editar":
               $acsbd->altera_peca($peca_selecionada,$dados);
               break;
         }
         $acsbd->desconectar(); 
         include("lista_peca.php");
      }
   }
?>
