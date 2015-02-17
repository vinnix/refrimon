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
<h2>Pagamentos</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<form name=form_cadastro_conta action="ctl_cadastro_conta_receber_servico.php" method="POST">
<input type=hidden name=acao_cadastro_conta>
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name="acao_cadastro" value='<?php echo($acao_cadastro); ?>'>
<input type=hidden name=tela_anterior value='<?php echo($tela_anterior); ?>'>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=servico_selecionado value='<?php echo($servico_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=chamada_selecionada value='<?php echo($chamada_selecionada); ?>'>
<input type=hidden name=veiculo_selecionado value='<?php echo($veiculo_selecionado); ?>'>
<?php
   if(isset($chk_nao_apagar_chamada))
      echo("<input type=hidden name=chk_nao_apagar_chamada value='on'>");
   while(list($campo,$valor)=each($dados_servico))
   {
      echo("<input type=hidden name='dados_servico[$campo]' value='".stripslashes($valor)."'>\n");
   }
   if(isset($lista_pecas_usadas))
   {
      reset($lista_pecas_usadas);
      while(list($k,$registro)=each($lista_pecas_usadas))
      {
         echo("<input type=hidden name='lista_pecas_usadas[$k][id_peca]' value='".$registro["id_peca"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade]' value='".$registro["quantidade"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][prefixo_nome]' value='".stripslashes($registro["prefixo_nome"])."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][unidade]' value='".stripslashes($registro["unidade"])."'>\n");
//         echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade_estoque]' value='".$registro["quantidade_estoque"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][ANTIGA]' value='".$registro["ANTIGA"]."'>\n");
      }
   }
   if(isset($lista_contas_receber))
   {
      reset($lista_contas_receber);
      while(list($i,$conta)=each($lista_contas_receber))
      {
         echo("<input type=hidden name='lista_contas_receber[$i][id_conta]' value='".$conta["id_conta"]."'>\n");
         echo("<input type=hidden name='lista_contas_receber[$i][data]' value='".$conta["data"]."'>\n");
         echo("<input type=hidden name='lista_contas_receber[$i][valor]' value='".$conta["valor"]."'>\n");
         echo("<input type=hidden name='lista_contas_receber[$i][ANTIGA]' value='".$conta["ANTIGA"]."'>\n");
      }
   }
?>
<center>
<table>
<tr>
<td>
<table>
<tr>
<td>Data de recebimento:</td>
<td><input type=text name='data_recebimento' size=10></td>
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
<select name=conta_selecionada size=5>
<?php
   if(isset($lista_contas_receber))
   {
      reset($lista_contas_receber);
      while(list($i,$conta)=each($lista_contas_receber))
      {
         if((!isset($conta["ANTIGA"]))||($conta["ANTIGA"]!="APAGAR")) {
           if(!isset($conta_selecionada))
             $conta_selecionada=$i;
           $sel=$conta_selecionada==$i?"selected":"";
           echo("<option value='$i' $sel>".$conta["data"]." - $unidade_monetaria ".$conta["valor"]."</option>");
         }
      }
   }
?>
</select>
</td>
</tr>
</table>
<input type=button value='Voltar' onclick=muda_acao_cadastro_conta('voltar')>
</center>
</form>
</body>
</html>
