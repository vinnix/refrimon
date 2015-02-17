<html>
<head>
<script>

function muda_acao_entrada(acao)
{
   document.form_entrada.acao_entrada.value = acao;
   document.form_entrada.submit();
}


</script>
</head>

<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Entrada de Pe&ccedil;as</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $dados_peca = $acsbd->obtem_dados_peca($peca_selecionada);
   $acsbd->desconectar();
?>
<form name=form_entrada action="ctl_entrada_peca.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_entrada>
<input type=hidden name=peca_selecionada value='<?php echo($peca_selecionada); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=prefixo_selecionado value='<?php echo(stripslashes($prefixo_selecionado)); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=quantidade_estoque value='<?php echo($dados_peca["quantidade"]); ?>'>
<center>
<table>
<tr>
<td>Pe&ccedil;a:</td>
<td><?php echo($dados_peca["prefixo"]." - ".$dados_peca["nm_peca"]); ?></td>
</tr>
<tr>
<td>Quantidade em estoque:</td>
<td><?php echo($dados_peca["quantidade"]." ".$dados_peca["unidade"]); ?></td>
</tr>
<tr>
<td>Quantidade adicionada:</td>
<td><input type=text size=8 name=quantidade_adicionada value='<?php echo(stripslashes($quantidade_adicionada)); ?>'> <?php echo($dados_peca["unidade"]); ?></td>
</tr>
<tr>
<td align=right><input type=button value='  Ok  ' onclick=muda_acao_entrada('confirmar')></td>
<td align=left><input type=button value='Voltar' onclick=muda_acao_entrada('voltar')></td>
</tr>
</table>
</center>
</form>
</body>
</html>
