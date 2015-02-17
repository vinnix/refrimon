<?php
   $acao = $_POST['acao']; 
   $fornecedor_selecionado = $_POST['fornecedor_selecionado'];
   $modo_listagem = $_POST['modo_listagem'];
   $valor_pesquisa = $_POST['valor_pesquisa'];

   include("comum/acsbd.php");
   switch($acao)
   {
      case "listar":
         unset($fornecedor_selecionado);
         include("lista_fornecedor.php");
         break;
      case "incluir":
         include("cadastro_fornecedor.php");
         break;
      case "editar":
         if(!$fornecedor_selecionado)
         {
            $aviso = "Selecione um fornecedor para editar";
            include("lista_fornecedor.php");
         }
         else
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $dados = $acsbd->obtem_dados_fornecedor($fornecedor_selecionado);
            $acsbd->desconectar();
            include("cadastro_fornecedor.php");
         }
         break;
      case "exibir":
         if(!$fornecedor_selecionado)
         {
            $aviso = "Selecione um fornecedor para exibir";
            include("lista_fornecedor.php");
         }
         else
            include("exibe_fornecedor.php");
         break;
      case "excluir":
         if(!$fornecedor_selecionado)
         {
            $aviso = "Selecione um fornecedor para excluir";
            include("lista_fornecedor.php");
         }
         else
            include("exibe_fornecedor.php");
         break;
   }
?>
