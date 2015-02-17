<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_login.acao.value=acao;
   document.form_login.submit();
}
</script>
</head>
<?php
   include("../comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Acesso Restrito</h2>
<br>
<h3>
<?php
   echo($aviso);
?>
</h3>
<br>
<center>
<form name=form_login action='ctl_login.php' method=post>
<input type=hidden name=acao>
<table>
<tr>
<td>Usu&aacute;rio:</td>
<td><input type=text size=16 name=nm_usuario></td>
</tr>
<tr>
<td>Senha:</td>
<td><input type=password size=16 name=senha></td>
</tr>
</table>
<br>
<input type=button value='  Ok  ' onclick=muda_acao('confirmar')>
</form>
</center>
</body>
</html>
