<html>
<head>
<title>Impress&atilde;o de Chamadas</title></head>

<?php
   $num_colunas = $_GET['num_colunas'];
   $chk_imprimir = $_GET['chk_imprimir'];
?>

<?php
   if(!isset($num_colunas))
      $num_colunas = 3;
   include("comum/comum.php");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<!--<h2>Impress&atilde;o de Chamadas</h2>-->
<center>
<?php

   include("comum/comum.php");
   include("comum/acsbd.php");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $j=0;
   echo("<table border=1  cellspacing=0>");  
   while(list($i,$id_chamada)=each($chk_imprimir))
   {
      $j++;
      $dados_chamada = $acsbd->obtem_dados_chamada($id_chamada);
      $dados_cliente = $acsbd->obtem_dados_cliente($dados_chamada["id_cliente"]);
      if(($j%$num_colunas)==1) 
         echo("<tr>");
      echo("<td valign=top width=320>");
      include("modelo_chamada.inc");
      echo("</td>");
      if(($j%$num_colunas)==0) 
         echo("</tr>");
   }
   $acsbd->desconectar();
   echo("</table>");

?>
<table>
<tr>
<td align=right><input type=button value='Imprimir' onclick='javascritp:self.print();'></td>
<td align=left><input type=button value='Fechar' onclick=window.close();></td>
</tr>
</table>
</center>
</body>
</html>
