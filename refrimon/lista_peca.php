<html>

<head>
<title>Pe&ccedil;as - Refrigera&ccedil;&atilde;o Montagner</title>
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
   $modo_listagem = $_POST['modo_listagem'];
   $valor_pesquisa = $_POST['valor_pesquisa'];
   $lista_prefixos = $_POST['lista_prefixos'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $aviso = $_POST['aviso'];

   if(!isset($modo_listagem))
      $modo_listagem = "prefixo";
   if($modo_listagem!="pesquisa_nome")
      $valor_pesquisa="";
?>
<?php
   include("comum/comum.php");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Pe&ccedil;as</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<form name=form_lista action="ctl_lista_peca.php" method="POST">
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=acao>
<center>
<table>
<tr>
<td align=center>
Prefixo
<select name=prefixo_selecionado onchange=muda_listagem('prefixo')>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_prefixos = $acsbd->obtem_lista_prefixo();
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
<table>
<tr>
<td align=left width=150>
<input type=button value="Incluir" onclick=muda_acao("incluir");>
</td>
<td align=center width=200>
<input type=button value="Listagem Geral" onclick=muda_acao("listagem_geral");>
</td>
<td align=right>
<input type=button value="Exibir" onclick=muda_acao("exibir");>
<input type=button value="Editar" onclick=muda_acao("editar");>
<input type=button value="Excluir" onclick=muda_acao("excluir");>
</td>
</tr>
<tr>
<td align=left><input type=button value="Entrada em Estoque" onclick=muda_acao("entrada_estoque")></td>
<td align=center><input type=button value="Estoque Cr&iacute;tico" onclick=muda_acao("estoque_critico");></td>
</tr>
</table>
</center>
</form>
</body>

</html>
