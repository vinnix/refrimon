<center>
<font face='Arial Black' size=5>Refrigera&ccedil;&atilde;o Montagner</font><br>
<font face='Arial' size=3><b>Montagner Com. e Servi&ccedil;os<br>de M&aacute;quinas Ltda. ME<br>
Fone/Fax (19) 3875-9013</b></font><br>
<font face='Arial' size=3>Av. Visconde de Indaiatuba, 531 - Vila Vit&oacute;ria - Indaiatuba - SP</font>
<img src="imagens/linha.bmp">
</center>
<table>
<tr>
<td><font face='Arial' size=3><b>N&uacute;mero:</b></font></td><td><font face='Arial' size=3><b><?php echo(zerosEsquerda($dados_chamada["id_chamada"],5)); ?></b></font/></td>
</tr>
<tr>
<td><font face='Arial' size=3><b>Data:</b></font></td><td><font face='Arial' size=3><?php echo(formata_data_h($dados_chamada["data"])); ?></font/></td>
</tr>
<tr>
<td><font face='Arial' size=3><b>Nome:</b></font></td><td><font face='Arial' size=3><?php echo($dados_cliente["nm_cliente"]); ?></font></td>
</tr>
<?php
   if($dados_cliente["endereco"]!="")
      echo("<tr><td><font face='Arial' size=3><b>Endere&ccedil;o:</b></font></td><td><font face='Arial' size=3>".$dados_cliente["endereco"]."</font></td></tr>");
   if($dados_cliente["telefone"]!="")
      echo("<tr><td><font face='Arial' size=3><b>Telefone:</b></font></td><td><font face='Arial' size=3>".$dados_cliente["telefone"]."</font></td></tr>");
   if($dados_cliente["observacao"]!="")
      echo("<tr><td><font face='Arial' size=3><b>Obs.:</b></font></td><td><font face='Arial' size=3>".$dados_cliente["observacao"]."</font></td></tr>");
   if($dados_chamada["produto"]!="")
      echo("<tr><td><font face='Arial' size=3><b>Produto:</b></font></td><td><font face='Arial' size=3>".$dados_chamada["produto"]."</font></td></tr>");
   if($dados_chamada["defeito"]!="")
      echo("<tr><td><font face='Arial' size=3><b>Defeito:</b></font></td><td><font face='Arial' size=3>".$dados_chamada["defeito"]."</font></td></tr>");
   if($dados_chamada["observacao"]!="")
      echo("<tr><td><font face='Arial' size=3>".$dados_chamada["observacao"]."</font></td></tr>");
?>
</table>
<font face='Arial' size=3>
<center>
_________________________________<br>
<!--<img src="imagens/linha.bmp">-->
Descri&ccedil;&atilde;o do servi&ccedil;o no verso.</center>
 OBS.: Ap&oacute;s dado o or&ccedil;amento, o prazo ser&aacute; de 45 dias para
 sua aprova&ccedil;&atilde;o ou n&atilde;o, findo o qual o equipamento ser&aacute; vendido
 para custear as despesas.<br>
 Or&ccedil;amento aprovado por:_______________________________<br>
 Prazo de garantia:________meses.<br>
 OBS.:A garantia se restringe &agrave; pe&ccedil;a trocada e/ou componente consertado.
 Condi&ccedil;&otilde;es de pagamento:_____________________________<br><br>
<center>_________________________________<br>
Assinatura do Cliente</center></font>
