<html>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Relat&oacute;rios</h2><br><br>
<center>
<table>
<tr>
<td width=250><a href='lista_conta_receber.php?contas_vencidas=1'><h3><font face=Wingdings><li></font>Contas a Receber</h3></a></td>
<td><a href='lista_conta_recebida.php'><h3><font face=Wingdings><li></font>Contas Recebidas</h3></a></td>
</tr>
<tr>
<td><a href='lista_servico.php'><h3><font face=Wingdings><li></font>Servi&ccedil;os Realizados</h3></a></td>
<td><a href='lista_conta_receber.php'><h3><font face=Wingdings><li></font>Servi&ccedil;os com Conta n&atilde;o Encerrada</h3></a></td>
</tr>
<tr>
<td><a href='lista_peca_usada_usuario.php'><h3><font face=Wingdings><li></font>Pe&ccedil;as Retiradas</h3></a></td>
<td><a href='lista_peca_usada_veiculo.php'><h3><font face=Wingdings><li></font>Pe&ccedil;as Retiradas de Ve&iacute;culo</h3></a></td>
</tr>
<tr>
<td><a href='lista_peca_usada_servico.php'><h3><font face=Wingdings><li></font>Pe&ccedil;as Usadas em Servi&ccedil;o</h3></a></td>
<td><a href='lista_peca_usada_oficina.php'><h3><font face=Wingdings><li></font>Pe&ccedil;as Usadas na Oficina</h3></a></td>
</tr>
</table>
</center>
</h3>
</body>
</html>
