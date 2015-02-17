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
      include("../comum/comum.inc");
      include("../comum/acsbd.inc");
      $acsbd = new AcsBD();
      $acsbd->conectar();
      $lista_usuarios=$acsbd->obtem_lista_usuarios();
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Usuários de pe&ccedil;as</h2><br><br>
<center>
<form name='form_lista' action='ctl_lista_usuario_peca.php' method=post>
<input type=hidden name=acao>
<?php
   while(list($i,$usuario)=each($lista_usuarios))
      echo("<input type=hidden name=usuarios[".$usuario["id_usuario"]."] value='".$usuario["nm_usuario"]."'>");
?>
<table>
<tr><td valign=top>Usu&aacute;rio</td>
<td><select name=usuario_selecionado size=10>
<?php
   reset($lista_usuarios);
   while(list($i,$usuario)=each($lista_usuarios))
   {
      if(!isset($usuario_selecionado))
         $usuario_selecionado=$usuario["id_usuario"];
      $sel=$usuario_selecionado==$usuario["id_usuario"]?"selected":"";
      echo("<option value='".$usuario["id_usuario"]."' $sel>".$usuario["nm_usuario"]."</option>");
   }
?>
</td>
<td valign=top><input type=button value='Remover usu&aacute;rio' onClick=muda_acao('remover')></td>
</tr>
<tr><td></td><td><input type=text size=15 name='nm_usuario_peca'></td>
<td><input type=button value='Incluir usu&aacute;rio' onClick=muda_acao('incluir')></td></tr>
</table>
</form>
</center>
</body>
</html>
