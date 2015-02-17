<?php
   include("comum/acsbd.inc");

   $acao_cadastro = $_POST['acao_cadastro'];
   $tela_anterior = $_POST['tela_anterior'];
   $acao = $_POST['acao'];
   $dados_chamada = $_POST['dados_chamada'];
   $chamada_selecionada = $_POST['chamada_selecionada'];

   if($acao_cadastro=='voltar')
      include($tela_anterior);
   elseif($acao_cadastro=='confirmar')
   {
      switch($acao)
      {
         case "incluir_chamada":
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->inclui_chamada($dados_chamada);
            $acsbd->desconectar();
            include($tela_anterior);
            break;
         case "editar_chamada":
            $acsbd = new AcsBD();
            $acsbd->conectar();
            $acsbd->altera_chamada($chamada_selecionada,$dados_chamada);
            $acsbd->desconectar();
            include($tela_anterior);
            break;
      }
   }
?>
