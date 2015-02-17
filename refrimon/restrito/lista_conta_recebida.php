<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("lista_conta_recebida.inc");
?>
