<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_exibe.acao.value=acao;
   document.form_exibe.submit();
}
</script>
</head>
<?php
   $data_fim  = $_GET['data_fim'];
   $data_inicio = $_GET['data_inicio'];
   $servico_selecionado = $_GET['servico_selecionado'];
   $tela_anterior = $_GET['tela_anterior'];

   include("comum/comum.php");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<center>
<font face="Arial Black" size=4>Refrigera&ccedil;&atilde;o Montagner Com&eacute;rcio e Servi&ccedil;os de M&aacute;quinas Ltda. ME</font>
<br>
<font face="Arial Black" size=2>Av. Visconde de Indaiatuba 531, Vl. Vit&oacute;ria<br>Indaiatuba - SP<br>Fone: (19)3875-9013<br>E-mail: refrimon@terra.com.br</font>
</center><br>
<font face="Arial Black" size=3>Dados do Servi&ccedil;o</font>
<font face="Arial" size=2>
<form name=form_exibe action='ctl_exibe_servico.php' method=post>
<input type=hidden name=acao>
<?php
   if(isset($exclusao_cliente))
      echo("<input type=hidden name=exclusao_cliente value=on>");
?>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=servico_selecionado value='<?php echo($servico_selecionado); ?>'>
<input type=hidden name=tela_anterior value='<?php echo($tela_anterior); ?>'>
<input type=hidden name=data_inicio value='<?php echo($data_inicio); ?>'>
<input type=hidden name=data_fim value='<?php echo($data_fim); ?>'>
<?php
      include("comum/acsbd.inc");
      $acsbd = new AcsBD();
      $acsbd->conectar();
      $dados_servico = $acsbd->obtem_dados_servico($servico_selecionado);
      $dados_cliente = $acsbd->obtem_dados_cliente($dados_servico["id_cliente"]);
      $lista_pecas = $acsbd->obtem_lista_peca_usada_unico_servico($servico_selecionado);
      $lista_contas_receber = $acsbd->obtem_lista_contas_receber_servico($servico_selecionado);
      $lista_contas_recebidas = $acsbd->obtem_lista_contas_recebidas_servico($servico_selecionado);
      $acsbd->desconectar();
?>
<center>
<table>
<tr><td valign=top>
<font face="Arial" size=2><b>Cliente</b></font>
<table>
<tr>
<td><font face="Arial" size=2>Nome:</font></td>
<td><font face="Arial" size=2><?php echo($dados_cliente["nm_cliente"]); ?></font></td>
</tr>
<tr>
<td><font face="Arial" size=2>Telefone:</font></td>
<td><font face="Arial" size=2><?php echo($dados_cliente["telefone"]); ?></font></td>
</tr>
<tr>
<td><font face="Arial" size=2>Endere&ccedil;o:</font></td>
<td><font face="Arial" size=2><?php echo($dados_cliente["endereco"]); ?></font></td>
</tr>
<tr>
<td><font face="Arial" size=2>Observa&ccedil;&atilde;o:</font></td>
<td><font face="Arial" size=2><?php echo($dados_cliente["observacao"]); ?></font></td>
</tr>
</table>
</td><td>
<font face="Arial" size=2><b>Dados do Servi&ccedil;o</b></font><br>
<table>
<tr><td><font face="Arial" size=2>Data:</font></td><td><font face="Arial" size=2><?php echo(formata_data_padrao($dados_servico["data"])); ?></font></td></tr>
<tr><td><font face="Arial" size=2>N&uacute;mero:</font></td><td><font face="Arial" size=2><?php echo($dados_servico["id_chamada"]); ?></font></td></tr>
<tr><td><font face="Arial" size=2>Produto:</font></td><td><font face="Arial" size=2><?php echo($dados_servico["produto"]); ?></font></td></tr>
<tr><td><font face="Arial" size=2>Defeito:</font></td><td><font face="Arial" size=2><?php echo($dados_servico["defeito"]); ?></font></td></tr>
<tr><td><font face="Arial" size=2>Descri&ccedil;&atilde;o do Servi&ccedil;o:</font></td><td><font face="Arial" size=2><?php echo($dados_servico["descricao"]); ?></font></td></tr>
<?php if((isset($dados_servico["observacao"]))&&($dados_servico["observacao"]!=""))
  echo('<tr><td><font face="Arial" size=2>Observa&ccedil;&atilde;o:</font></td><td><font face="Arial" size=2>'.$dados_servico["observacao"].'</font></td></tr>');
?>
<tr><td><font face="Arial" size=2>Garantia:</font></td><td><font face="Arial" size=2><?php echo($dados_servico["garantia"]); ?></font></td></tr>
</table>
</td></tr>
</table>
<b>Pe&ccedil;as usadas</b><br>
<?php
   if(empty($lista_pecas))
      echo("N&atilde;o foi usada pe&ccedil;a alguma neste servi&ccedil;o");
   else
   {
      echo("<table>");
      while(list($i,$peca)=each($lista_pecas))
      {
         echo("<tr>");
         echo("<td><font face='Arial' size=2>(".$peca["quantidade"]." ".$peca["unidade"].")</font></td>");
         echo("<td><font face='Arial' size=2>".$peca["prefixo"]." - ".$peca["nm_peca"]."</font></td>");
         echo("</tr>");
      }
      echo("</table>");
   }
?>
<br>
<table>
<tr>
<td valign=top>
<font face="Arial" size=2><b>Valores</b></font><br>
<table>
<tr><td><font face="Arial" size=2>Valor Total:</font></td><td><font face="Arial" size=2><?php echo($unidade_monetaria." ".$dados_servico["valor"]); ?></font></td></tr>
<tr><td><font face="Arial" size=2>Valor Pago:</font></td><td><font face="Arial" size=2><?php echo($unidade_monetaria." ".formata_decimal_padrao($dados_servico["valor_pago"])); ?></font></td></tr>
</table>
</td>
<td width=40></td>
<td valign=top>
<font face="Arial" size=2><b>Contas Recebidas</b></font><br>
<?php
   if(empty($lista_contas_recebidas))
      echo("<font face='Arial' size=2>N&atilde;o foi recebida parcela alguma deste servi&ccedil;o</font>");
   else
   {
      echo("<table>");
      echo("<tr><td><font face='Arial' size=2>Data</font></td><td></td><td><font face='Arial' size=2>Valor</font></td></tr>");
      while(list($i,$conta)=each($lista_contas_recebidas))
      {
         echo("<tr>");
         echo("<td><font face='Arial' size=2>".formata_data_padrao($conta["data"])."</font></td><td><font face='Arial' size=2> - </font></td>");
         echo("<td><font face='Arial' size=2>$unidade_monetaria ".$conta["valor"]."</font></td>");
         echo("</tr>");
      }
      echo("</table>");
   }

?>
</td>
<td width=40></td>
<td valign=top>
<font face='Arial' size=2><b>Contas a Receber</b></font><br>
<?php
   if(empty($lista_contas_receber))
      echo("<font face='Arial' size=2>Conta Encerrada</font>");
   else
   {
      echo("<table>");
      echo("<tr><td><font face='Arial' size=2>Data</font></td><td></td><td><font face='Arial' size=2>Valor</font></td></tr>");
      while(list($i,$conta)=each($lista_contas_receber))
      {
         echo("<tr>");
         echo("<td><font face='Arial' size=2>".formata_data_padrao($conta["data"])."</font></td><td><font face='Arial' size=2> - </font></td>");
         echo("<td><font face='Arial' size=2>$unidade_monetaria ".$conta["valor"]."</font></td>");
         echo("</tr>");
      }
      echo("</table>");
   }

?>
</td>
</tr>
</table>
<table>
<tr>
<td><input type=button value='Imprimir' onclick=javascritp:self.print()></td>
<td><input type=button value='Voltar' onclick=muda_acao('voltar')></td>
</tr>
</table>
</center>
</form>
</font>
</body>
</html>
