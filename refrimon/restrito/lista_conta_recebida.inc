<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}


function sel_verifica_tudo()
{
   var linhas = document.form_lista.num_linhas.value;
   for(var i=0;i<linhas;i++)
      document.form_lista.elements[i].checked=document.form_lista.chk_verifica_tudo.checked;
}

</script>
</head>
<?php
   include("../comum/comum.php");
   include("../comum/acsbd.php");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_servicos=$acsbd->obtem_lista_conta_recebida_nao_verificada();
   $acsbd->desconectar();
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>
<?php
   echo("Verifica&ccedil;&atilde;o de Contas Recebidas");
?>
</h2><br>
<center>
<form name='form_lista' action='ctl_lista_conta_recebida.php' method=post>
<br><br>
<?php
   if($aviso)
      echo("<h3>$aviso</h3>");
   if(empty($lista_servicos))
      echo("N&atilde;o h&aacute; contas recebidas a serem verificadas");
   else
   {
      $j=0;
      echo("<table border=1>");
      echo("<tr><td><h3>Pagamentos Relizados</h3></td><td><h3>Cliente</h3></td><td><h3>Servi&ccedil;o</h3></td><td><h3>Valor</h3></td></tr>");
      while(list($id_servico,$servico)=each($lista_servicos))
      {
         echo("<tr>");
         echo("<td valign=top><table>");
         while(list($id_conta,$conta)=each($servico["lista_contas"]))
         {
            $j++;
            echo("<tr><td><input type=checkbox name='chk_verificar[$j]' value='$id_conta'></td>");
            echo("<td>".formata_data_padrao($conta["data"])."</td><td> - </td>");
            echo("<td>$unidade_monetaria ".$conta["valor"]."</td></tr>");
         }
         echo("</table></td>");
         echo("<td valign=top><table>");
         echo("<tr><td>".$servico["nm_cliente"]."</td></tr>");
         if($servico["telefone"]!="")
            echo("<tr><td>".$servico["telefone"]."</td></tr>");
         if($servico["endereco"]!="")
            echo("<tr><td>".$servico["endereco"]."</td></tr>");
         if($servico["observacao_cliente"]!="")
            echo("<tr><td>".$servico["observacao_cliente"]."</td></tr>");
         echo("</table></td>");
         echo("<td valign=top><table>");
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
         echo("</tr>");
      }
      echo("<tr><td><input type=checkbox name=chk_verifica_tudo onclick=sel_verifica_tudo()> Verificar Todas</td></tr>");
      echo("</table>");
   }
?>
<br><br>
<table>
<tr><td><input type=button value='Imprimir' onclick=javascritp:self.print()></td>
<td><input type=button value='Confirmar Verifica&ccedil;&atilde;o' onclick=muda_acao('confirmar')></td></tr>
</table>
<input type=hidden name=num_linhas value='<?php echo($j); ?>'>
<input type=hidden name=acao>
</form>
</center>
</body>
</html>
