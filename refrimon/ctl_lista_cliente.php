<?php
   ##print " OK! here. out.1.";

   require("comum/acsbd.php");

   ##print " OK! here. after require. 2.";


   $acao = $_POST["acao"];
   $cliente_selecionado =  $_POST["cliente_selecionado"];
   $inic = $_POST['inic'];
   $modo_listagem = $_POST['modo_listagem'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $aviso = $_POST['aviso'];


   switch($acao)
   {
      case "listar":
         unset($cliente_selecionado);
         include("lista_cliente.php");
         break;
      case "incluir":
         include("cadastro_cliente.php");
         break;
      case "editar":
         if(!$cliente_selecionado)
         {
            $aviso = "Selecione um cliente para editar";
            include("lista_cliente.php");
         }
         else
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $dados = $acsbd->obtem_dados_cliente($cliente_selecionado);
            $acsbd->desconectar();
            include("cadastro_cliente.php");
         }
         break;
      case "exibir":
         if(!$cliente_selecionado)
         {
            $aviso = "Selecione um cliente para exibir";
            include("lista_cliente.php");
         }
         else
            include("lista_historico_cliente.php");
         break;

      case "exibicao_rapida":
	$cliente_exibicao_rapida = $_POST["cliente_selecionado"];
        require("lista_cliente.php");
        break;

      case "excluir":
         if(!$cliente_selecionado)
         {
            $aviso = "Selecione um cliente para excluir";
            include("lista_cliente.php");
         }
         else
         {
            $exclusao_cliente="on";
            include("lista_historico_cliente.php");
         }
         break;
      case "incluir_chamada":
         if(!$cliente_selecionado || !isset($cliente_selecionado) || empty($cliente_selecionado) || $cliente_selecionado == "")
         {
            $aviso = "Selecione um cliente para fazer a chamada";
            include("lista_cliente.php");
         }
         else
         {
            $tela_anterior = "lista_cliente.php";
            include("cadastro_chamada.php");
         }
         break;
      case "incluir_servico":
         if(!$cliente_selecionado)
         {
            $aviso = "Selecione um cliente para cadastrar o servi&ccedil;o";
            include("lista_cliente.php");
         }
         else {
            $tela_anterior = "lista_cliente.php";
            include("cadastro_servico.php");
         }
         break;
      case "recebimento":
         if(!$cliente_selecionado)
            $aviso = "Selecione um cliente para registrar o recebimento";
         else
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $lista_contas_receber = $acsbd->obtem_lista_proximas_contas_cliente($cliente_selecionado);
            if(empty($lista_contas_receber))
               $aviso = "Nenhuma conta a receber deste cliente";
            $acsbd->desconectar();
         }
         if(isset($aviso))
            include("lista_cliente.php");
         else
            include("cadastro_recebimento_conta.php");
         break;
   }
  ##print " OK! here.";
?>
