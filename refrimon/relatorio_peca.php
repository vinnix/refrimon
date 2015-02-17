<html>
<head>
<title>Listagem das Pe&ccedil;as</title>
<script>
function voltar()
{
   document.form_relatorio.submit();
}
</script>
</head>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>
<?php
   if($acao=="listagem_geral")
      echo("Listagem Geral");
   elseif($acao=="estoque_critico")
      echo("Estoque Cr&iacute;tico");
?>
</h2>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   if($acao=="listagem_geral")
      $lista_pecas = $acsbd->obtem_lista_pecas();
   elseif($acao=="estoque_critico")
      $lista_pecas = $acsbd->obtem_lista_pecas_critico();
   $acsbd->desconectar();
?>
<form name=form_relatorio action="lista_peca.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=peca_selecionada value='<?php echo($peca_selecionada); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=prefixo_selecionado value='<?php echo(stripslashes($prefixo_selecionado)); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<center>
<?php
   if(empty($lista_pecas))
   {
      if($acao=="listagem_geral")
         echo("N&atilde;o h&aacute; pe&ccedil;as cadastradas");
      elseif($acao=="estoque_critico")
         echo("N&atilde;o h&aacute; pe&ccedil;as em estoque cr&iacute;tico");         
   }
   else
   {
      echo("<table border=1>");
      echo("<th><td><font face='Arial' size=2>Prefixo</font></td><td><font face='Arial' size=2>Nome</font></td><td><font face='Arial' size=2>C&oacute;digo</font></td><td><font face='Arial' size=2>Qtd. Estoque</font></td><td><font face='Arial' size=2>Qtd. m&iacute;nima</font></td></th>");
      $j=0;
      while(list($i,$peca)=each($lista_pecas))
      {
         echo("<tr><td>");
         if(($acao=="listagem_geral")&&($peca["quantidade"]<$peca["quantidade_minima"]))
            echo("<font face=Wingdings size=2>ð</font>");
         echo("</td>");
         echo("<td><font face='Arial' size=2>".$peca["prefixo"]."</font></td><td><font face='Arial' size=2>".$peca["nm_peca"]."</font></td><td><font face='Arial' size=2>".$peca["codigo"]."</font></td><td align=right><font face='Arial' size=2>".$peca["quantidade"]." ".$peca["unidade"]."</font></td><td align=right><font face='Arial' size=2>".$peca["quantidade_minima"]." ".$peca["unidade"]."</font></td>");
         echo("</tr>");
         $j++;
      }
      echo("</table>");
      echo("<font face='Arial' size=2><b>Total: $j</b></font>");
   }
?>
<table>
<tr>
<td align=right><input type=button value='Imprimir' onclick='javascritp:self.print();'></td>
<td align=left><input type=button value='Voltar' onclick=voltar()></td>
</tr>
</table>
</center>
</form>
</body>
</html>
