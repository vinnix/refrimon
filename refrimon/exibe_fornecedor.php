<html>
<head>
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
<h2>Dados do Fornecedor</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $dados = $acsbd->obtem_dados_fornecedor($fornecedor_selecionado);
   $acsbd->desconectar();
?>
<form name=form_exibicao action="ctl_exibe_fornecedor.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_exibicao>
<input type=hidden name=fornecedor_selecionado value='<?php echo($fornecedor_selecionado); ?>'>
<center>
<table>
<tr>
<td>Nome:</td>
<td><?php echo($dados["nm_fornecedor"]); ?></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><?php echo($dados["endereco"]); ?></td>
</tr>
<tr>
<td>Contato:</td>
<td><?php echo($dados["nm_contato"]); ?></td>
</tr>
<tr>
<td>Telefone:</td>
<td><?php echo($dados["telefone"]); ?></td>
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
