<?php
   $acao = $_POST['acao'];
   $chk_apagar = $_POST['chk_apagar'];
   $chk_imprimir = $_POST['chk_imprimir'];
   switch($acao)
   {
      case "apagar":
         if(empty($chk_apagar))
         {
            $aviso="Selecione as chamadas a apagar";
            include("lista_chamada.php");
         }
         else
         {
            $tela_anterior="lista_chamada.php";
            include("apaga_chamada.php");
         }
         break;
      case "imprimir":
         if(empty($chk_imprimir))
         {
            $aviso="Selecione as chamadas a imprimir";
            include("lista_chamada.php");
         }
         else
            include("imprime_chamada.php");
         break;
   }
?>
