<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
      include("lista_peca_usada_usuario.inc");
?>
