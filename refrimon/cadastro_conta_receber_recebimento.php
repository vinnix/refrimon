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
<h2>Pr&oacute;ximos Pagamentos</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
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
<center>
<table>
<tr>
<td>Valor total:</td>
<td><?php echo($unidade_monetaria." ".$lista_contas_receber[$conta_receber_selecionada]["valor"]); ?></td>
</tr>
<tr>
<td>Valor pago:</td>
<td><?php echo($unidade_monetaria." ".formata_decimal_padrao($lista_contas_receber[$conta_receber_selecionada]["valor_pago"]+$dados_conta_recebida["valor"])); ?></td>
</tr>
</table>
<table>
<tr>
<td>
<table>
<tr>
<td>Data de recebimento:</td>
<td><input type=text name=data_recebimento size=10></td>
</tr>
<td>Valor (<?php echo($unidade_monetaria); ?>):</td>
<td><input type=text name=valor_conta size=10></td>
</table>
</td>
<td valign=center>
<table>
<tr><td><input type=button value='  >>  ' onclick=muda_acao_cadastro_conta('incluir')></td></tr>
<tr><td><input type=button value='  <<  ' onclick=muda_acao_cadastro_conta('excluir')></td></tr>
</table>
</td>
<td>
Lista de pagamentos<br>
<select name=conta_cadastro_selecionada size=5>
<?php
   if(isset($lista_contas_restantes))
   {
      reset($lista_contas_restantes);
      while(list($i,$conta)=each($lista_contas_restantes))
      {
         if(!isset($conta_cadastro_selecionada))
            $conta_cadastro_selecionada=$i;
         $sel=$conta_cadastro_selecionada==$i?"selected":"";
         echo("<option value='$i' $sel>".$conta["data"]." - $unidade_monetaria ".$conta["valor"]."</option>");
      }
   }
?>
</select>
</td>
</tr>
</table>
<table>
<tr>
<td align=right><input type=button value='  Ok  ' onclick=muda_acao_cadastro_conta('confirmar')></td>
<td align=left><input type=button value='Voltar' onclick=muda_acao_cadastro_conta('voltar')></td>
</center>
</form>
</body>
</html>
