<html>
<head>
<script>
function muda_acao(acao)
{
   document.form_troca.acao.value=acao;
   document.form_troca.submit();
}
</script>
</head>
<?php
   include("../comum/comum.inc");
   session_start();
   $nm_usuario = $_SESSION['nm_usuario'];
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Troca de Senha</h2>
<br>
<h3>
<?php
   echo($aviso);
?>
</h3>
<br>
<center>
<form name=form_troca action='ctl_troca_senha.php' method=post>
<input type=hidden name=acao>
<table>
<tr>
<td>Usu&aacute;rio:</td>
<td><?php echo($nm_usuario); ?></td>
</tr>
<tr>
<td>Senha antiga:</td>
<td><input type=password size=16 name=senha_antiga value='<?php echo(stripslashes($senha_antiga)); ?>'></td>
</tr>
<tr>
<td>Nova senha:</td>
<td><input type=password size=16 name=senha_nova></td>
</tr>
<tr>
<td>Confirme a nova senha:</td>
<td><input type=password size=16 name=senha_confirmacao></td>
</tr>
</table>
<br>
<input type=button value='  Ok  ' onclick=muda_acao('confirmar')>
</form>
</center>
</body>
</html>
