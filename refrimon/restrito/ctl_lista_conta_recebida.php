<?php
   $acao = $_POST['acao'];
   $chk_verificar = $_POST['chk_verificar'];
   $dados_servico = $_POST['dados_servico'];
   $num_linhas = $_POST['num_linhas'];

   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      switch($acao)
      {
         case 'confirmar':
            if(isset($chk_verificar))
            {
               include("../comum/acsbd.inc");
               $acsbd = new AcsBD();
               $acsbd->conectar();
               while(list($i,$id_conta)=each($chk_verificar))
                  $acsbd->verifica_conta_recebida($id_conta);
               $acsbd->desconectar();
            }
            else
               $aviso="Selecione as contas recebidas a verificar";
            include("lista_conta_recebida.php"); 
            break;
      }
   }
?>
