<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("remove_usuario_peca.inc");
?>
