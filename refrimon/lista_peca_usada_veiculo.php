<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}
function sel_apaga_tudo()
{
   var linhas = document.form_lista.num_linhas.value;
   for(var i=0;i<linhas;i++)
      document.form_lista.elements[i+1].checked=document.form_lista.chk_apaga_tudo.checked;
}

</script>
</head>

<?php
   include("comum/comum.php");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>Pe&ccedil;as Retiradas de Ve&iacute;culo</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3>
<form name=form_lista action="ctl_lista_peca_usada_veiculo.php" method=post>
<center>
Ve&iacute;culo: <select name=veiculo_selecionado onchange=muda_acao('listar')>
<?php
   include("comum/acsbd.php");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_veiculos = $acsbd->obtem_lista_veiculo();
   while(list($i,$veiculo)=each($lista_veiculos))
   {
      if(!isset($veiculo_selecionado))
         $veiculo_selecionado=$veiculo["id_veiculo"];
      $sel = $veiculo_selecionado==$veiculo["id_veiculo"]?"selected":"";
      echo("<option value=".$veiculo["id_veiculo"]." $sel>".$veiculo["descricao"]."</option>");
   }
?>
</select><br><br>
<?php
   $lista_pecas = $acsbd->obtem_lista_peca_usada_veiculo($veiculo_selecionado);
   $acsbd->desconectar();
   if(empty($lista_pecas))
      echo("N&atilde;o foram retiradas pe&ccedil;as deste ve&iacute;culo");
   else
   {
      echo("<table border=1>");
      echo("<tr><td>Reposto</td><td>Pe&ccedil;a</td><td>Endere&ccedil;o</td><td>Qtd. Retirada</td><td>Data da Retirada</td></tr>");
      $j=0;
      while(list($i,$peca)=each($lista_pecas))
      {
         $j++;
         echo("<tr>");
         echo("<td><input type=checkbox name=chk_apaga[$j] value=".$peca["id_uso"]."></td>");
         echo("<td>".$peca["prefixo"]." - ".$peca["nm_peca"]."</td>");
         echo("<td>".$peca["endereco"]."</td>");
         echo("<td>".$peca["quantidade"]." ".$peca["unidade"]."</td>");
         echo("<td>".formata_data_padrao($peca["data"])."</td></tr>");
      }
      echo("<tr><td><input type=checkbox name=chk_apaga_tudo onclick=sel_apaga_tudo()></td><td>Selecionar tudo</td></tr>");
      echo("</table>");
      echo("<b>Total: $j</b>");
   }
?>
<br><br>
<table>
<tr>
<td><input type=button value='  Ok  ' onclick=muda_acao('confirmar')></td>
<td><input type=button value='Imprimir' onclick='javascritp:self.print()'></td>
<td><input type=button value='Voltar' onclick=muda_acao('voltar')></td>
</tr>
</table>
</center>
<input type=hidden name=acao>
<input type=hidden name=num_linhas value='<?php echo($j); ?>'>
</form>
</body>
</html>
