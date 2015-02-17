<html>
<head>
<title>Listagem Geral</title>
</head>
<body>
<center>
<?
   $nm_arquivo_cli = "pecamont.txt";

   $linhas = file($nm_arquivo_cli);
   echo("<table border=1>");
   echo("<th><td><font face='Arial' size=2>Prefixo</font></td><td><font face='Arial' size=2>Nome</font></td><td><font face='Arial' size=2>Endere&ccedil;o</font></td><td><font face='Arial' size=2>Qtd. Estoque</font></td><td><font face='Arial' size=2>Qtd. m&iacute;nima</font></td></th>");
   while(list($i,$linha)=each($linhas))
   {
      ereg("([^\t]*)\t([^\-]*)\-[ ]?([^\t]*)\t([^\t]*)\t([^\t]*)\t[R\$ ]*([^\t]*)\t[R\$ ]*([^\t]*)\t([^\n]*)\n",$linha,$campos);
      $dados["prefixo"] = $campos[2];
      $dados["nm_peca"] = $campos[3];
      $dados["quantidade"] = $campos[4];
      $dados["quantidade_minima"] = $campos[5];
      $dados["valor_compra"] = ereg_replace(",",".",$campos[6]);
      $dados["valor_venda"] = ereg_replace(",",".",$campos[7]);
      $dados["endereco"] = $campos[8];
      echo("<tr><td>");
      if($dados["quantidade"]<$dados["quantidade_minima"])
         echo("<font face=Wingdings size=2>ð</font>");
      echo("</td>");
      echo("<td><font face='Arial' size=2>".$dados["prefixo"]."</font></td><td><font face='Arial' size=2>".$dados["nm_peca"]."</font></td><td><font face='Arial' size=2>".$dados["endereco"]."</font></td><td align=right><font face='Arial' size=2>".$dados["quantidade"]." ".$dados["unidade"]."</font></td><td align=right><font face='Arial' size=2>".$dados["quantidade_minima"]." ".$dados["unidade"]."</font></td>");
      echo("</tr>");
      $j++;
   }
   echo("</table>");
   echo("<font face='Arial' size=2><b>Total: $j</b></font>");
?>
<table>
<tr>
<td align=right><input type=button value='Imprimir' onclick='javascritp:self.print();'></td>
</tr>
</table>
</center>
</body>
</html>