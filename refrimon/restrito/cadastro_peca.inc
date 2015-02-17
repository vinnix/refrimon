<html>
<head>
<script>
function muda_acao_cadastro(acao_cadastro)
{
   document.form_cadastro.acao_cadastro.value = acao_cadastro;
   document.form_cadastro.submit();
}
</script>
</head>
<?php
   include("../comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Cadastro de Pe&ccedil;as</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<?php
   include("../comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_prefixos = $acsbd->obtem_lista_prefixo();
   $lista_unidades = $acsbd->obtem_lista_unidade();
   $acsbd->desconectar();
?>
<form name=form_cadastro action="ctl_cadastro_peca.php" method="POST">
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_cadastro>
<input type=hidden name=peca_selecionada value='<?php echo($peca_selecionada); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=prefixo_selecionado value='<?php echo(stripslashes($prefixo_selecionado)); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<center>
<table>
<tr>
<td>Prefixo:</td>
<td>
<select name=prefixo_cadastro>
<?php
   while(list($i,$prefixo)=each($lista_prefixos))
   {
      if(!isset($dados["prefixo"]))
         $dados["prefixo"] = $prefixo;
      $sel=(stripslashes($dados["prefixo"])==$prefixo)?"selected":"";
      echo("<option value='$prefixo' $sel>$prefixo</option>");
   }
?>
</select>
 Novo prefixo:
<input type=text name=novo_prefixo size=8 value='<?php echo(stripslashes($novo_prefixo)); ?>'></td>
</tr>
<tr>
<td>Nome:</td>
<td><input type=text name=dados[nm_peca] size=40 value='<?php echo(stripslashes($dados["nm_peca"])); ?>'></td>
</tr>
<tr>
<td>C&oacute;digo:</td>
<td><input type=text name=dados[codigo] size=10 value='<?php echo(stripslashes($dados["codigo"])); ?>'></td>
</tr>
<tr>
<td>Quantidade M&iacute;nima:</td>
<td><input type=text name=dados[quantidade_minima] size=5 value='<?php echo(stripslashes($dados["quantidade_minima"])); ?>'></td>
</tr>
<tr>
<td>Unidade:</td>
<td>
<select name=unidade_cadastro>
<?php
   while(list($i,$unidade)=each($lista_unidades))
   {
      if(!isset($dados["unidade"]))
         $dados["unidade"] = $unidade;
      $descr_unidade=$unidade==""?"Nenhuma":$unidade;
      if($dados["unidade"]=="")
         $dados["unidade"]="Nenhuma";
      $sel=(stripslashes($dados["unidade"])==$unidade)?"selected":"";
      echo("<option value='$unidade' $sel>$descr_unidade</option>");
   }
?>
</select>
 Nova unidade:
<input type=text name=nova_unidade size=8 value='<?php echo(stripslashes($nova_unidade)); ?>'></td>
</tr>

<tr>
<td>Valor de Compra (<?php echo($unidade_monetaria);?>):</td>
<td><input type=text name='dados[valor_compra]' size=10 value='<?php echo(stripslashes($dados["valor_compra"])); ?>'></td>
</tr>
<tr>
<td>Valor de Venda (<?php echo($unidade_monetaria); ?>):</td>
<td><input type=text name='dados[valor_venda]' size=10 value='<?php echo(stripslashes($dados["valor_venda"])); ?>'></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><input type=text name='dados[endereco]' size=10 value='<?php echo(stripslashes($dados["endereco"])); ?>'></td>
</tr>
<tr>
<td align=right>
<input type=button value='  OK  ' onclick='muda_acao_cadastro("confirmar");'>
</td>
<td align=left>
<input type=button value=Voltar onclick='muda_acao_cadastro("voltar");'>
</td>
</tr>
</table>
</center>
</form>
</body>
</html>
