<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_remove.acao.value = acao;
   document.form_remove.submit();
}
</script>
</head>
<?php
   include("../comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>Pe&ccedil;as Retiradas</h2><br><br>
<center>
<h3>Deseja realmente remover o usu&aacute;rio <?php echo($usuarios[$usuario_selecionado]); ?> ?</h3>
<form name=form_remove action='ctl_remove_usuario_peca.php' method=post>
<input type=hidden name=usuario_selecionado value=<?php echo($usuario_selecionado); ?>>
<input type=hidden name=acao>
<table>
<tr>
<td><input type=button value='  Ok  ' onclick=muda_acao('confirmar')></td>
<td><input type=button value='Voltar' onclick=muda_acao('voltar')></td>
</tr>
</table>
</form>
</center>
</body>
</html>
