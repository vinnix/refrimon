<?php
   $acao = $_POST['acao'];
   $data_fim = $_POST['data_fim'];
   $data_inicio = $_POST['data_inicio'];

   switch($acao)
   {
      case "muda_periodo":
         include("lista_peca_usada_oficina.php");
         break;
      case "muda_periodo_hoje":
         include("comum/comum.php");
         $data_inicio=obtem_data();
         $data_fim=obtem_data();
         include("lista_peca_usada_oficina.php");
         break;
      case "muda_periodo_semana":
         include("comum/comum.php");
         $data_fim=obtem_data();
         $data_aux = getdate();
         $data_inicio=date("d/m/Y",mktime(0,0,0,$data_aux["mon"],$data_aux["mday"]-7,$data_aux["year"]));
         include("lista_peca_usada_oficina.php");
         break;
      case "muda_periodo_mes":
         include("comum/comum.php");
         $data_fim=obtem_data();
         $data_aux = getdate();
         $data_inicio=date("d/m/Y",mktime(0,0,0,$data_aux["mon"]-1,$data_aux["mday"],$data_aux["year"]));
         include("lista_peca_usada_oficina.php");
         break;
   }
?>
