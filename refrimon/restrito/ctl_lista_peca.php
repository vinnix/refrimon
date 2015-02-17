<?php

   $acao = $_POST['acao'];
   $modo_listagem = $_POST['modo_listagem'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $valor_pesquisa = $_POST['valor_pesquisa'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      switch($acao)
      {
         case "listar":
            unset($peca_selecionada);
            include("lista_peca.php");
            break;
         case "editar":
            if(!$peca_selecionada)
            {
               $aviso = "Selecione uma peca para editar";
               include("lista_peca.php");
            }
            else
            {
               include("../comum/acsbd.inc");
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
      }
   }
?>
