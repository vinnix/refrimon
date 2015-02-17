<html>
<head>
<title>Apagar Chamadas</title>
<script>

function muda_acao_apaga(acao)
{
   document.form_apaga.acao_apaga.value=acao;
   document.form_apaga.submit();
}

</script>
</head>

<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Apagar Chamadas</h2>
<center>
<form name=form_apaga action="ctl_apaga_chamada.php" method=POST>
<?php
   if(isset($exclusao_cliente))
      echo("<input type=hidden name=exclusao_cliente value=on>");
?>
<input type=hidden name=tela_anterior value='<?php echo($tela_anterior); ?>'>
<input type=hidden name=acao_apaga>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<?php
   while(list($i,$id_chamada)=each($chk_apagar))
      echo("<input type=hidden name='lista_apagar_chamada[$i]' value=$id_chamada>\n");
   $num=count($chk_apagar);
   echo("<br><br><b>Confirma a exclus&atilde;o de $num chamada(s)?</b><br><br>\n")
?>
<table>
<tr>
<td align=right><input type=button value='Apagar' onclick=muda_acao_apaga('confirmar')></td>
<td align=left><input type=button value='Voltar' onclick=muda_acao_apaga('voltar')></td>
</tr>
</table>
</center>
</form>
</form>
</body>
</html>
