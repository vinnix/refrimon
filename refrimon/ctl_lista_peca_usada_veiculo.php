<?php
   $acao = $_POST['acao'];
   $num_linhas = $_POST['num_linhas'];
   $veiculo_selecionado = $_POST['veiculo_selecionado'];

   switch($acao)
   {
      case "listar":
         include("lista_peca_usada_veiculo.php");
         break;
      case "voltar":
         include("menu_relatorio.php");
         break;
      case "confirmar":
         if(isset($chk_apaga))
         {
            include("comum/acsbd.inc");
            $acsbd = new AcsBD();
            $acsbd->conectar();
            while(list($i,$id_uso)=each($chk_apaga))
               $acsbd->exclui_peca_usada_veiculo($id_uso);
            $acsbd->desconectar();
         }
         include("lista_peca_usada_veiculo.php"); 
         break;
   }
?>
