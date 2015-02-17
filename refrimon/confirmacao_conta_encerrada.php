<html>

<head>
<script>

function muda_acao_cadastro_conta(acao)
{
   document.form_cadastro_conta.acao_cadastro_conta.value = acao;
   document.form_cadastro_conta.submit();
}


</script>
</head>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<center>
<br><br>
<h3>
Conta Encerrada
<h3>
<form name=form_cadastro_conta action="ctl_cadastro_conta_receber_recebimento.php" method="POST">
<input type=hidden name=acao_cadastro_conta>
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_conta value='<?php echo($acao_conta); ?>'>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=conta_receber_selecionada value='<?php echo($conta_receber_selecionada); ?>'>
<?php
   while(list($campo,$valor)=each($dados_conta_recebida))
      echo("<input type=hidden name='dados_conta_recebida[$campo]' value='$valor'>\n");
   if(isset($lista_contas_receber))
   {
      reset($lista_contas_receber);
      while(list($i,$conta)=each($lista_contas_receber))
      {
         reset($conta);
         while(list($campo,$valor)=each($conta))
            echo("<input type=hidden name='lista_contas_receber[$i][$campo]' value='".stripslashes($valor)."'>\n");
      }
   }
   if(isset($lista_contas_restantes))
   {
      reset($lista_contas_restantes);
      while(list($i,$conta)=each($lista_contas_restantes))
      {
         reset($conta);
         while(list($campo,$valor)=each($conta))
            echo("<input type=hidden name='lista_contas_restantes[$i][$campo]' value='$valor'>\n");
      }
   }
?>
<table>
<tr>
<td>Valor total</td>
<td><?php echo($lista_contas_receber[$conta_receber_selecionada]["valor"]); ?></td>
</tr>
<tr>
<td>Valor pago</td>
<td><?php echo(formata_decimal_padrao($lista_contas_receber[$conta_receber_selecionada]["valor_pago"]+$dados_conta_recebida["valor"])); ?></td>
</tr>
<tr>
<td align=right><input type=button value='  Ok  ' onclick=muda_acao_cadastro_conta('confirmar')></td>
<td align=left><input type=button value='Voltar' onclick=muda_acao_cadastro_conta('voltar')></td>
</form>
</center>
</body>
</html>
