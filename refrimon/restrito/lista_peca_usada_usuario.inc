<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}

</script>
</head>
<?php
      include("../comum/comum.inc");
      include("../comum/acsbd.inc");
      $acsbd = new AcsBD();
      $acsbd->conectar();
      $lista_usuarios=$acsbd->obtem_lista_usuarios();
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>Pe&ccedil;as Retiradas</h2><br><br>
<center>
<form name='form_lista' action='ctl_lista_peca_usada_usuario.php' method=post>
<input type=hidden name=acao>
<?php
   while(list($i,$usuario)=each($lista_usuarios))
      echo("<input type=hidden name='usuarios[".$usuario["id_usuario"]."]' value='".$usuario["nm_usuario"]."'>");
?>
<table>
<tr><td>Usu&aacute;rio</td>
<td><select name=usuario_selecionado onchange=muda_acao('listar')>
<?php
   reset($lista_usuarios);
   while(list($i,$usuario)=each($lista_usuarios))
   {
      if(!isset($usuario_selecionado))
         $usuario_selecionado=$usuario["id_usuario"];
      $sel=$usuario_selecionado==$usuario["id_usuario"]?"selected":"";
      echo("<option value='".$usuario["id_usuario"]."' $sel>".$usuario["nm_usuario"]."</option>");
   }
?>
</td></tr>
</table>
<br>
<?php
   $lista_pecas=$acsbd->obtem_lista_peca_usada_usuario($usuario_selecionado);
   $acsbd->desconectar();
   if(empty($lista_pecas))
      echo("N&atilde;o h&aacute; pe&ccedil;as retiradas por este usu&aacute;rio");
   else
   {
      echo("<table border=1>");
      echo("<tr><td>Pe&ccedil;a</td><td>Quantidade</td><td>Data de Retirada</td></tr>");
      while(list($i,$peca)=each($lista_pecas))
      {
         echo("<tr>");
         echo("<td>".$peca["prefixo"]." - ".$peca["nm_peca"]."</td>");
         echo("<td align=right>".$peca["quantidade"]." ".$peca["unidade"]."</td>");
         echo("<td align=center>".formata_data_padrao($peca["data"])."</td>");
         echo("</tr>");
      }
      echo("</table>");
   }
?>
<br><br>
<table>
<tr><td><input type=button value='Imprimir' onclick=javascritp:self.print()></td>
<td><input type=button value='Zerar' onclick=muda_acao('zerar')></td>
</table>
</form>
</center>
</body>
</html>
