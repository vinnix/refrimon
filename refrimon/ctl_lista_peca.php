<?php
   $acao = $_POST['acao'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $modo_listagem = $_POST['modo_listagem'];
   $prefixo = $_POST['prefixo'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $inic = $_POST['inic'];

   include("comum/acsbd.php");
   switch($acao)
   {
      case "listar":
         unset($peca_selecionada);
         include("lista_peca.php");
         break;
      case "entrada_estoque":
         include("entrada_peca.php");
         break;
      case "incluir":
         include("cadastro_peca.php");
         break;
      case "editar":
         if(!$peca_selecionada)
         {
            $aviso = "Selecione uma peca para editar";
            include("lista_peca.php");
         }
         else
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $dados = $acsbd->obtem_dados_peca($peca_selecionada);
            $acsbd->desconectar();
            include("cadastro_peca.php");
         }
         break;
      case "exibir":
         if(!$peca_selecionada)
         {
            $aviso = "Selecione uma peca para exibir";
            include("lista_peca.php");
         }
         else
            include("exibe_peca.php");
         break;
      case "excluir":
         if(!$peca_selecionada)
         {
            $aviso = "Selecione uma peca para excluir";
            include("lista_peca.php");
         }
         else
            include("exibe_peca.php");
         break;
      case "listagem_geral":
      case "estoque_critico":
         include("relatorio_peca.php");
         break;
   }
?>
