<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("cadastro_peca.inc");
?>
