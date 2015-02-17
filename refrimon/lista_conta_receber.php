<html>
<head>
<script>

</script>
</head>
<?php
   include("comum/comum.inc");
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   if(isset($contas_vencidas))
      $lista_clientes=$acsbd->obtem_lista_cliente_conta_vencida();
   else
      $lista_clientes=$acsbd->obtem_lista_cliente_conta_receber();
   $acsbd->desconectar();
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>
<?php
   if(isset($contas_vencidas))
      echo("Contas a Receber");
   else 
      echo("Servi&ccedil;os com Conta n&atilde;o Encerrada");
?>
</h2><br><br>
<center>
<?php
   if(empty($lista_clientes))
   {
      if(isset($contas_vencidas))
         echo("N&atilde;o h&aacute; contas a receber vencidas");
      else
         echo("N&atilde;o h&aacute; contas a receber");
   }
   else
   {
      echo("<table border=1>");
      echo("<tr><td><h3>Cliente</h3></td><td><h3>Servi&ccedil;o</h3></td></tr>");
      while(list($id_cliente,$cliente)=each($lista_clientes))
      {
         echo("<tr><td valign=top><table>");
         echo("<tr><td>".$cliente["nm_cliente"]."</td></tr>");
         if($cliente["telefone"]!="")
            echo("<tr><td>".$cliente["telefone"]."</td></tr>");
         if($cliente["endereco"]!="")
            echo("<tr><td>".$cliente["endereco"]."</td></tr>");
         if($cliente["observacao"]!="")
            echo("<tr><td>".$cliente["observacao"]."</td></tr>");
         echo("</table></td>");
         echo("<td><table border=1>");
         while(list($id_servico,$servico)=each($cliente["lista_servicos"]))
         {
            echo("<tr><td valign=top><table>");
            echo("<tr><td><b>Nr: </b>".zerosEsquerda($servico["id_chamada"],5)."</td></tr>");
            echo("<tr><td><b>Produto: </b>".$servico["produto"]."</td></tr>");
            echo("<tr><td><b>Defeito: </b>".$servico["defeito"]."</td></tr>");
            echo("<tr><td><b>Descri&ccedil;&atilde;o: </b>".$servico["descricao"]."</td></tr>");
            if($servico["observacao"]!="")
               echo("<tr><td><b>Observa&ccedil;&atilde;o: </b>".$servico["observacao"]."</td></tr>");
            echo("<tr><td><b>Data: </b>".formata_data_padrao($servico["data"])."</td></tr>");
            echo("</table></td>");
            echo("<td valign=top><table><tr><td><b>Valor do Servi&ccedil;o:</b></td></tr>");
            echo("<tr><td>$unidade_monetaria ".$servico["valor"]."</td></tr>");
            echo("<tr><td><b>Valor Pago:</b></td></tr>");
            echo("<tr><td>$unidade_monetaria ".formata_decimal_padrao($servico["valor_pago"])."</td></tr></table></td>");
            echo("<td valign=top><table><tr><td><b>Vencimentos</b></td></tr>");
            while(list($id_conta,$conta)=each($servico["lista_contas"]))
            {
               echo("<tr><td>".formata_data_padrao($conta["data"])."</td><td> - </td>");
               echo("<td>$unidade_monetaria ".$conta["valor"]."</td></tr>");
            }
            echo("</table></td></tr>");
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
