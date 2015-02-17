<?php
   include("comum.inc");
   if(!login_correto())
      include("login.php");
   else
   {
      echo("<html>");
      echo("<head>");
      echo("<title>Refrigera&ccedil;&atilde;o Montagner - Acesso Restrito</title>");
      echo("</head>");
      echo("<frameset cols='126,*' rows='*' border='0' frameborder='0'>");
      echo("<frame src='navegacao.php' name='fr_navegacao'>");
      echo("<frame src='lista_peca.php' name='fr_principal'>");
      echo("</frameset>");
      echo("</html>");
   }
?>
