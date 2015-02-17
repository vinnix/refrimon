<?php
  $acao_entrada = $_POST['acao_entrada'];
  $acao = $_POST['acao'];
  $modo_listagem = $_POST['modo_listagem'];
  $peca_selecionada = $_POST['peca_selecionada'];
  $prefixo_selecionado = $_POST['prefixo_selecionado'];
  $quantidade_adicionada = $_POST['quantidade_adicionada'];
  $quantidade_estoque = $_POST['quantidade_estoque'];
  $valor_pesquisa = $_POST['valor_pesquisa'];

   switch($acao_entrada)
   {
      case "confirmar":
         include("comum/comum.inc");
         if(!$qtd_mysql=formata_decimal_mysql($quantidade_adicionada))
            $aviso="Quantidade adicionada inv&aacute;lida";
         if(!$aviso)
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->altera_quantidade_peca($peca_selecionada,$quantidade_estoque+$qtd_mysql);
            $acsbd->desconectar();
            include("lista_peca.php");
         }
         else
            include("entrada_peca.php");
         break;
      case "voltar":
         include("lista_peca.php");
         break;
   }
?>
