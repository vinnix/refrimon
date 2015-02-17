<?php
   $acao_apaga = $_POST['acao_apaga'];
   switch($acao_apaga)
   {
      case "voltar":
         include($tela_anterior);
         break;
      case "confirmar":
         include("comum/acsbd.inc");
         $acsbd = new AcsBD();
         $acsbd->conectar();
         while(list($i,$id_chamada)=each($lista_apagar_chamada))
            $acsbd->exclui_chamada($id_chamada);
         $acsbd->desconectar();
         include($tela_anterior); 
         break;
   }
?>
