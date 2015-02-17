<html>
<head>
<title>Cadastro de Clientes</title>
<script>

function muda_acao_cadastro(acao_cadastro)
{
   document.form_cadastro.acao_cadastro.value = acao_cadastro;
   document.form_cadastro.submit();
}

</script>
</head>

<?
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Cadastro de Clientes</h2>
<form name=form_cadastro action="ctl_cadastro_cliente.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_cadastro>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>

<center>

<table>
<tr>
<td>Nome:</td>
<td><input type=text name='dados[nm_cliente]' size=40 value='<?php echo(stripslashes($dados["nm_cliente"])); ?>'></td>
</tr>
<tr>
<td>Telefone:</td>
<td><input type=text name='dados[telefone]' size=15 value='<?php echo(stripslashes($dados["telefone"])); ?>'></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><input type=text name='dados[endereco]' size=40 value='<?php echo(stripslashes($dados["endereco"])); ?>'></td>
</tr>
<tr>
<td>Observa&ccedil;&atilde;o:</td>
<td>
<textarea name='dados[observacao]'>
<?php echo(stripslashes($dados["observacao"])); ?>
</textarea>
</td>
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
