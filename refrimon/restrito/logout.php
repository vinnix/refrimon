<?php
   session_start();
   session_destroy();
   include("../comum/comum.inc");
?>
<html>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<center>
<br>
<br>
<h3>
Logout Efetuado
</h3>
</center>
</body>
</html>
