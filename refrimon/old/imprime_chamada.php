<html>
<head>
<title>Impress&atilde;o de Chamadas</title></head>
<?
   if(!isset($num_colunas))
      $num_colunas = 3;
   include("comum/comum.inc");
?>
<body bgcolor="<? echo($cor_fundo_impressao); ?>">
<!--<h2>Impress&atilde;o de Chamadas</h2>-->
<center>
<?

   include("comum/comum.inc");
   include("comum/acsbd.inc");
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
<td align=left><input type=button value='Voltar' onclick=window.location='lista_chamada.php'></td>
</tr>
</table>
</center>
</body>
</html>
