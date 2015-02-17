<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("lista_usuario_peca.inc");
?>
