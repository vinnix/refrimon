<html>
<head>
<title>Cadastro de Pe&ccedil;as</title>
<script>

function muda_acao_exibicao(acao_exibicao)
{
   document.form_exibicao.acao_exibicao.value = acao_exibicao;
   document.form_exibicao.submit();
}

</script>
</head>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Dados da Pe&ccedil;a</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $dados = $acsbd->obtem_dados_peca($peca_selecionada);
   $acsbd->desconectar();
?>
<form name=form_exibicao action="ctl_exibe_peca.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_exibicao>
<input type=hidden name=peca_selecionada value='<?php echo($peca_selecionada); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=prefixo_selecionado value='<?php echo(stripslashes($prefixo_selecionado)); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<center>
<table>
<tr>
<td>Prefixo:</td>
<td><?php echo($dados["prefixo"]); ?></td>
</tr>
<tr>
<td>Nome:</td>
<td><?php echo($dados["nm_peca"]); ?></td>
</tr>
<tr>
<td>C&oacute;digo:</td>
<td><?php echo($dados["codigo"]); ?></td>
</tr>
<tr>
<td>Quantidade em Estoque:</td>
<td><?php echo($dados["quantidade"]." ".$dados["unidade"]); ?></td>
</tr>
<tr>
<td>Quantidade M&iacute;nima:</td>
<td><?php echo($dados["quantidade_minima"]." ".$dados["unidade"]); ?></td>
</tr>
<tr>
<td>Valor de Venda:</td>
<td><?php echo($unidade_monetaria." ".$dados["valor_venda"]); ?></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><?php echo($dados["endereco"]); ?></td>
</tr>
<tr>
<td align=right>
<?php
   if($acao=="excluir")
      echo("<input type=button value='Confirmar Exclus&atilde;o' onclick='muda_acao_exibicao(\"confirmar\");'>");
?>
</td>
<td align=left>
<input type=button value=Voltar onclick='muda_acao_exibicao("voltar");'>
</td>
</tr>
</table>

</center>
</form>
</body>
</html>
