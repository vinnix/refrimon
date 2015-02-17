<html>
<head>
<script>
function muda_acao_cadastro(acao_cadastro)
{
   document.form_cadastro.acao_cadastro.value = acao_cadastro;
   document.form_cadastro.submit();
}
</script>
</head>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Cadastro de Fornecedores</h2>
<form name=form_cadastro action="ctl_cadastro_fornecedor.php" method="POST">
<input type=hidden name='acao' value='<?php echo($acao); ?>'>
<input type=hidden name='acao_cadastro'>
<input type=hidden name='fornecedor_selecionado' value='<?php echo($fornecedor_selecionado); ?>'>
<center>
<table>
<tr>
<td>Nome:</td>
<td><input type=text name='dados[nm_fornecedor]' size=40 value='<?php echo(stripslashes($dados["nm_fornecedor"])); ?>'></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><input type=text name='dados[endereco]' size=40 value='<?php echo(stripslashes($dados["endereco"])); ?>'></td>
</tr>
<tr>
<td>Contato:</td>
<td><input type=text name='dados[nm_contato]' size=40 value='<?php echo(stripslashes($dados["nm_contato"])); ?>'></td>
</tr>
<tr>
<td>Telefone:</td>
<td><input type=text name='dados[telefone]' size=15 value='<?php echo(stripslashes($dados["telefone"])); ?>'></td>
</tr>
<tr>
<td align=right>
<input type=button value='  OK  ' onclick='muda_acao_cadastro("confirmar");'>
</td>
<td align=left>
<input type=button value=Voltar onclick='muda_acao_cadastro("voltar");'>
</td>
</tr>
</table>
</center>
</form>
</body>
</html>
