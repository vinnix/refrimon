<html>

<head>
<script>

function muda_listagem(modo)
{
   document.form_lista.modo_listagem.value = modo;
   document.form_lista.acao.value = "listar";
   document.form_lista.submit();
}

function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}


</script>
</head>
<?php
   if(!isset($modo_listagem))
      $modo_listagem = "prefixo";
   if($modo_listagem!="pesquisa_nome")
      $valor_pesquisa="";
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Pe&ccedil;as Usadas</h2><br>
<h3>
<?php
   echo($aviso);
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_usuarios = $acsbd->obtem_lista_usuarios();
   $lista_prefixos = $acsbd->obtem_lista_prefixo();
?>
</h3><br>
<form name=form_lista action="ctl_cadastro_peca_usada_usuario.php" method="POST">
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=acao>
<?php
   if(isset($lista_pecas_usadas))
   {
      while(list($id_peca,$registro)=each($lista_pecas_usadas))
      {
         echo("<input type=hidden name='lista_pecas_usadas[$id_peca][quantidade]' value='".$registro["quantidade"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$id_peca][prefixo_nome]' value='".stripslashes($registro["prefixo_nome"])."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$id_peca][unidade]' value='".stripslashes($registro["unidade"])."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$id_peca][quantidade_estoque]' value='".$registro["quantidade_estoque"]."'>\n");
      }
   }
?>
<center>
<table>
<tr><td>Usu&aacute;rio</td>
<td><select name=usuario_selecionado>
<?php
   if(!isset($usuario_selecionado))
      $usuario_selecionado=0;
   $sel=$usuario_selecionado==0?"selected":"";
   echo("<option value=0 $sel>Oficina</option>");
   while(list($i,$usuario)=each($lista_usuarios))
   {
      $sel=$usuario_selecionado==$usuario["id_usuario"]?"selected":"";
      echo("<option value='".$usuario["id_usuario"]."' $sel>".$usuario["nm_usuario"]."</option>");
   }
?>
</td></tr>
</table>
<table>
<tr><td>
<table>
<tr>
<td align=center>
Prefixo
<select name=prefixo_selecionado onchange=muda_listagem('prefixo')>
<?php
   while(list($i,$prefixo)=each($lista_prefixos))
   {
      if(!isset($prefixo_selecionado))
         $prefixo_selecionado = $prefixo;
      $sel=(stripslashes($prefixo_selecionado)==$prefixo)?"selected":"";
      echo("<option value='$prefixo' $sel>$prefixo</option>");
   }
?>
</select>
</td>
</tr>

<tr align=left>
<td>
Pesquisa:<br>
<input type=text name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>' size=30>
<input type=button value="Por Nome" onclick=muda_listagem('pesquisa_nome');>
</td>
</tr>

<tr>
<td align=center>
<?php
   switch($modo_listagem)
   {
      case "prefixo":$lista_pecas = $acsbd->obtem_lista_pecas_prefixo($prefixo_selecionado);
                     break;
      case "pesquisa_nome":$lista_pecas = $acsbd->obtem_lista_pecas_nome($valor_pesquisa);
                           break;
   }
   $acsbd->desconectar();
   if(!empty($lista_pecas))
   {
      echo("<select name=peca_selecionada size=10>");
      $cont=0;
      while(list($i,$peca)=each($lista_pecas))
      {
         if(!isset($peca_selecionada))
            $peca_selecionada=$peca["id_peca"];
         $sel=($peca_selecionada==$peca["id_peca"]?"selected":"");
         echo("<option value = ".$peca["id_peca"]." $sel>".$peca["prefixo"]." - ".$peca["nm_peca"]."</option>");
         $cont++;
      }
      echo("</select><br>");
      echo("<b>Total: $cont</b>");
   }
   else
      echo("Nenhuma pe&ccedil;a selecionada");
?>

</td>
</tr>
</table>
</td>
<td valign=center>
<table>
<tr><td align=center>
Qtd.: <input type=text size=6 name=qtd_usada>
</td></tr>
<tr><td align=center>
<input type=button value='   >>   ' onclick=muda_acao('incluir')>
</td></tr>
<tr><td align=center>
<input type=button value='   <<   ' onclick=muda_acao('excluir')><br>
</td></tr>
<tr><td align=center>
<input type=button value='Muda Qtd' onclick=muda_acao('muda_qtd')><br>
</td></tr>
</table>
</td>
<td valign=center>
Lista de pe&ccedil;as usadas<br>
<select size=10 name=peca_usada_selecionada>
<?php
   if(isset($lista_pecas_usadas))
   {
      reset($lista_pecas_usadas);
      while(list($id_peca,$registro)=each($lista_pecas_usadas))
      {
         if(!isset($peca_usada_selecionada))
            $peca_usada_selecionada=$id_peca;
         $sel = $peca_usada_selecionada==$id_peca?"selected":"";
         echo("<option value=$id_peca $sel>(".$registro["quantidade"]." ".stripslashes($registro["unidade"]).") ".stripslashes($registro["prefixo_nome"])."</option>");
      }
   }
?>
</select>
</td>
</tr>
</table>
<table>
<tr>
<td align=center><input type=button value='  Ok  ' onclick=muda_acao('confirmar')></td>
</tr>
</table>
</center>
</form>
</body>

</html>
