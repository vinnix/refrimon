<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}

</script>
</head>
<?php
   include("comum/comum.php");
   if((!isset($data_inicio))&&(!isset($data_fim)))
   {
      $data_inicio=obtem_data();
      $data_fim=obtem_data();
   }
   if(!$data_inicio_mysql=formata_data_mysql($data_inicio))
      $aviso="Data de in&iacute;cio inv&aacute;lida";
   else
      if($data_fim=="")
         $data_fim=$data_inicio;
   if(!$aviso)
      if(!$data_fim_mysql=formata_data_mysql($data_fim))
         $aviso="Data de fim inv&aacute;lida";
   if(!$aviso)
   {
      include("comum/acsbd.php");
      $acsbd = new AcsBD();
      $acsbd->conectar();
      $lista_servicos=$acsbd->obtem_lista_servico_conta_recebida($data_inicio_mysql,$data_fim_mysql);
      $acsbd->desconectar();
   }
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>
<?php
   echo("Contas Recebidas");
?>
</h2><br><br>
<center>
<form name='form_lista' action='ctl_lista_conta_recebida.php' method=post>
<input type=hidden name=acao>
<table>
<tr>
<td>
<b>Per&iacute;odo</b>
</td>
<td align=center>
<input type=button value="Hoje" onclick=muda_acao('muda_periodo_hoje')>
</td>
</tr>
<tr>
<td>
De <input type=text name=data_inicio size=10 value=<?php echo(stripslashes($data_inicio)); ?>>
 a <input type=text name=data_fim size=10 value=<?php echo(stripslashes($data_fim)); ?>>
</td>
<td align=center>
<input type=button value="&Uacute;ltima Semana" onclick=muda_acao('muda_periodo_semana')>
</td>
</tr>
<tr>
<td align=center>
<input type=button value="  Ok  " onclick=muda_acao('muda_periodo')>
</td>
<td align=center>
<input type=button value="&Uacute;ltimo M&ecirc;s" onclick=muda_acao('muda_periodo_mes')>
</td>
</tr>
</table>
</form>
<br><br>
<?php
   if($aviso)
      echo("<h3>$aviso</h3>");
   else
      if(empty($lista_servicos))
         echo("N&atilde;o h&aacute; contas recebidas");
      else
      {
         echo("<table border=1>");
         echo("<tr><td><h3>Cliente</h3></td><td><h3>Servi&ccedil;o</h3></td><td><h3>Valor</h3></td><td><h3>Pagamentos Relizados</h3></td></tr>");
         while(list($id_servico,$servico)=each($lista_servicos))
         {
            echo("<tr><td valign=top><table>");
            echo("<tr><td>".$servico["nm_cliente"]."</td></tr>");
            if($servico["telefone"]!="")
               echo("<tr><td>".$servico["telefone"]."</td></tr>");
            if($servico["endereco"]!="")
               echo("<tr><td>".$servico["endereco"]."</td></tr>");
            if($servico["observacao_cliente"]!="")
               echo("<tr><td>".$servico["observacao_cliente"]."</td></tr>");
            echo("</table></td>");
            echo("<td valign=top><table>");
            echo("<tr><td><b>Nr: </b>".zerosEsquerda($servico["id_chamada"],5)."</td></tr>");
            echo("<tr><td><b>Produto: </b>".$servico["produto"]."</td></tr>");
            echo("<tr><td><b>Defeito: </b>".$servico["defeito"]."</td></tr>");
            echo("<tr><td><b>Descri&ccedil;&atilde;o: </b>".$servico["descricao"]."</td></tr>");
            if($servico["observacao_servico"]!="")
               echo("<tr><td><b>Observa&ccedil;&atilde;o: </b>".$servico["observacao_servico"]."</td></tr>");
            echo("<tr><td><b>Data: </b>".formata_data_padrao($servico["data"])."</td></tr>");
            echo("</table></td>");
            echo("<td valign=top><table><tr><td><b>Valor do Servi&ccedil;o:</b></td></tr>");
            echo("<tr><td>$unidade_monetaria ".$servico["valor"]."</td></tr>");
            echo("<tr><td><b>Valor Pago:</b></td></tr>");
            echo("<tr><td>$unidade_monetaria ".formata_decimal_padrao($servico["valor_pago"])."</td></tr></table></td>");
            echo("<td valign=top><table>");
            while(list($id_conta,$conta)=each($servico["lista_contas"]))
            {
               echo("<tr><td>".formata_data_padrao($conta["data"])."</td><td> - </td>");
               echo("<td>$unidade_monetaria ".$conta["valor"]."</td></tr>");
            }
            echo("</table></td></tr>");
         }
         echo("</table>");
      }
?>
<table>
<tr><td><input type=button value='Imprimir' onclick=javascritp:self.print()></td>
<td><input type=button value='Voltar' onclick=javascritp:window.location="menu_relatorio.php"></td></tr>
</table>
</center>
</body>
</html>
