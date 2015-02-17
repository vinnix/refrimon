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
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Fornecedores</h2>
<br>
<h3>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   if(!isset($modo_listagem))
      $modo_listagem = "todos";
   switch($modo_listagem)
   {
      case "todos":$lista_fornecedores = $acsbd->obtem_lista_fornecedor();
                     break;
      case "pesquisa_nome":$lista_fornecedores = $acsbd->obtem_lista_fornecedor_nome($valor_pesquisa);
                     break;
      case "pesquisa_telefone":$lista_fornecedores = $acsbd->obtem_lista_fornecedor_telefone($valor_pesquisa);
                     break;
   }   
   $acsbd->desconectar();
   echo($aviso);
?>
</h3><br>
<form name=form_lista action="ctl_lista_fornecedor.php" method="POST">
<input type=hidden name=acao>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<center>
<table>
<tr>
<td colspan=2 align=left>
Pesquisa:<br>
<input type=text name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>' size=30>
<input type=button value="Por Nome" onclick=muda_listagem('pesquisa_nome');>
<input type=button value="Por Telefone" onclick=muda_listagem('pesquisa_telefone');>
<?php
   if($modo_listagem!="todos")
      echo("<input type=button value=\"Todos\" onclick=muda_listagem('todos');>");
?>
</td>
</tr>
<tr>
<td align=center>
<?php
   if(!empty($lista_fornecedores))
   {
      echo("<select name=fornecedor_selecionado size=10>");
      $cont=0;
      while(list($i,$fornecedor)=each($lista_fornecedores))
      {
         if(!isset($fornecedor_selecionado))
            $fornecedor_selecionado=$fornecedor["id_fornecedor"];
         $sel=($fornecedor_selecionado==$fornecedor["id_fornecedor"]?"selected ":"");
         echo("<option value = ".$fornecedor["id_fornecedor"]." $sel>".$fornecedor["nm_fornecedor"]);
         if($modo_listagem=="pesquisa_telefone")
            echo(" (".$fornecedor["telefone"].")");
         echo("</option>");
         $cont++;
      }
      echo("</select><br>");
      echo("<b>Total: $cont</b>");
   }
   else
      echo("Nenhum fornecedor cadastrado");
?>

</td>

<td>
</td>

</tr>
</table>
<table>
<tr>
<td align=left width=300>
<input type=button value="Incluir" onclick=muda_acao("incluir");>
</td>
<td align=right>
<input type=button value="Exibir" onclick=muda_acao("exibir");>
<input type=button value="Editar" onclick=muda_acao("editar");>
<input type=button value="Excluir" onclick=muda_acao("excluir");>
</td>
</tr>
</table>
</center>
</form>
</body>
</html>
