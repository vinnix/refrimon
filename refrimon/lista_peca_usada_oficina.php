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
      $lista_pecas=$acsbd->obtem_lista_peca_usada_oficina($data_inicio_mysql,$data_fim_mysql);
      $acsbd->desconectar();
   }
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">
<h2>
<?php
   echo("Pe&ccedil;as usadas na Oficina");
?>
</h2><br><br>
<center>
<form name='form_lista' action='ctl_lista_peca_usada_oficina.php' method=post>
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
      if(empty($lista_pecas))
         echo("N&atilde;o h&aacute; pe&ccedil;as usadas na Oficina");
      else
      {
         echo("<table border=1>");
         echo("<tr><td><b>Pe&ccedil;a</b></td><td><b>Quantidade Usada</b></td></tr>");
         while(list($i,$peca)=each($lista_pecas))
         {
            echo("<tr>");
            echo("<td>".$peca["prefixo"]." - ".$peca["nm_peca"]."</td>");
            echo("<td align=right>".$peca["quantidade"]." ".$peca["unidade"]."</td>");
            echo("</tr>");
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
