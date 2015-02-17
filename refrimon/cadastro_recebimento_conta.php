<html>
<head>
<script>

function muda_acao_conta(acao)
{
document.form_conta.acao_conta.value = acao;
document.form_conta.submit();
}

</script>
</head>

<?php
include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Recebimento de Conta</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<form name=form_conta action="ctl_cadastro_recebimento_conta.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_conta>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<?php
   include("comum/comum.inc");
   if(isset($lista_contas_receber))
   {
      reset($lista_contas_receber);
      while(list($i,$linha)=each($lista_contas_receber))
      {
         $chave=$i;
         reset($linha);
         while(list($campo,$valor)=each($linha))
            echo("<input type=hidden name='lista_contas_receber[$i][$campo]' value='".stripslashes($valor)."'>\n");
      }
      if(count($lista_contas_receber)==1)
      {
         $conta_receber_selecionada=$chave;
         echo("<input type=hidden name=conta_receber_selecionada value=$conta_receber_selecionada>");
      }
   }
?>
<center>
<table>
<?php
   if(count($lista_contas_receber)>1)
   {
      echo("<tr><td>Refer&ecirc;nte ao Servi&ccedil;o</td><td><select name=conta_receber_selecionada onchange=muda_acao_conta('muda_conta')>");
      reset($lista_contas_receber);
      while(list($i,$conta)=each($lista_contas_receber))
      {
         if(!isset($conta_receber_selecionada))
            $conta_receber_selecionada=$i;
         $sel=$i==$conta_receber_selecionada?"selected":"";
         echo("<option value=$i $sel>".$conta["produto"]." / ".$conta["descricao"]."</option>");
      }
      echo("</select></td></tr>");
   }
   if((!isset($dados_conta_recebida["valor"]))||($acao_conta=="muda_conta"))
      $dados_conta_recebida["valor"]=$lista_contas_receber[$conta_receber_selecionada]["valor_conta"];
   if(!isset($dados_conta_recebida["data"]))
      $dados_conta_recebida["data"]=obtem_data();
?>   
<tr>
<td>Produto:</td>
<td><?php echo(stripslashes($lista_contas_receber[$conta_receber_selecionada]["produto"])); ?></td>
</tr>
<tr>
<td>Descri&ccedil;&atilde;o do Servi&ccedil;o:</td>
<td><?php echo(stripslashes($lista_contas_receber[$conta_receber_selecionada]["descricao"])); ?></td>
</tr>
<tr>
<td>Valor Total do Servi&ccedil;o:</td>
<td><?php echo($unidade_monetaria." ".$lista_contas_receber[$conta_receber_selecionada]["valor"]); ?></td>
</tr>
<tr>
<td>Valor j&aacute; pago:</td>
<td><?php echo($unidade_monetaria." ".formata_decimal_padrao($lista_contas_receber[$conta_receber_selecionada]["valor_pago"])); ?></td>
</tr>
<tr>
<td>Valor do pr&oacute;ximo pagamento:</td>
<td><?php echo($unidade_monetaria." ".$lista_contas_receber[$conta_receber_selecionada]["valor_conta"]); ?></td>
</tr>
<tr>
<td>Data prevista para o pr&oacute;ximo pagamento:</td>
<td><?php echo(formata_data_padrao($lista_contas_receber[$conta_receber_selecionada]["data_conta"])); ?></td>
</tr>
<tr>
<td>Valor pago (<?php echo($unidade_monetaria); ?>):</td>
<td><input type=text name='dados_conta_recebida[valor]' size=10 value='<?php echo(stripslashes($dados_conta_recebida["valor"])); ?>'></td>
</tr>
<tr>
<td>Data do pagamento:</td>
<td><input type=text name='dados_conta_recebida[data]' readonly size=10 value='<?php echo(stripslashes($dados_conta_recebida["data"])); ?>'></td>
</tr>
<tr>
<td align=right>
<input type=button value='  Ok  ' onclick=muda_acao_conta('confirmar')>
</td>
<td align=left>
<input type=button value='Voltar' onclick=muda_acao_conta('voltar')>
</td>
</tr>

</table>
</center>
</form>
</body>
</html>
