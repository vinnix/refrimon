<?php
   
   $acao = $_POST['acao'];
   $acao_cadastro = $_POST['acao_cadastro'];
   $dados = $_POST['dados'];
   $modo_listagem = $_POST['modo_listagem'];
   $nova_unidade = $_POST['nova_unidade'];
   $novo_prefixo = $_POST['novo_prefixo'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $prefixo_cadastro = $_POST['prefixo_cadastro'];
   $unidade_cadastro =  $_POST['unidade_cadastro'];
   $valor_pesquisa = $_POST['valor_pesquisa'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      include("../comum/comum.inc");
      if($acao_cadastro=='voltar')
         include("lista_peca.php");
      elseif($acao_cadastro=='confirmar')
      {
         $dados["prefixo"]=$prefixo_cadastro;
         $dados["unidade"]=$unidade_cadastro;
         if(!$qtd_min_mysql=formata_decimal_mysql($dados["quantidade_minima"]))
            $aviso = "Quantidade m&iacute;nima inv&aacute;lida";
         if(!$aviso)
            if(!$valor_compra_mysql=formata_decimal_mysql($dados["valor_compra"]))
               $aviso = "Valor de compra inv&aacute;lido";
         if(!$aviso)
            if(!$valor_venda_mysql=formata_decimal_mysql($dados["valor_venda"]))
               $aviso = "Valor de venda inv&aacute;lido";
         if($aviso)
            include("cadastro_peca.php");
         else
         {
            include("../comum/acsbd.inc");
            if($novo_prefixo!="")
               $dados["prefixo"]=$novo_prefixo;
            if($nova_unidade!="")
               $dados["unidade"]=$nova_unidade;
            $dados["quantidade_minima"]=$qtd_min_mysql;
            if($dados["valor_compra"]!="")
               $dados["valor_compra"]=$valor_compra_mysql;
            if($dados["valor_venda"]!="")
               $dados["valor_venda"]=$valor_venda_mysql;
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->altera_peca($peca_selecionada,$dados);
            $acsbd->desconectar(); 
            include("lista_peca.php");
         }
      }
   }
?>
