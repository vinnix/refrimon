<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_zera.acao.value = acao;
   document.form_zera.submit();
}
</script>
</head>
<?php
   include("../comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>Pe&ccedil;as Retiradas</h2><br><br>
<center>
<h3>Deseja realmente zerar a lista de pe&ccedil;as retiradas pelo usu&aacute;rio <?php echo($usuarios[$usuario_selecionado]); ?> ?</h3>
<form name=form_zera action='ctl_zera_peca_usada_usuario.php' method=post>
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
