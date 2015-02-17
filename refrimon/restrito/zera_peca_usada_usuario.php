<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("zera_peca_usada_usuario.inc");
?>
