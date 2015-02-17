<html>

<head>

<title> Cadastro de Chamadas </title>

<script>
function muda_acao_cadastro(acao_cadastro)
{
   document.form_cadastro.acao_cadastro.value = acao_cadastro;
   document.form_cadastro.submit();
}

</script>
</head>

<?php
   require "comum/comum.php";

?>

<?php
   if (!isset($chamada_selecionada))
   	$chamada_selecionada = $_GET['chamada_selecionada'];

   if (!isset($cliente_selecionado))
   	$cliente_selecionado = $_GET['cliente_selecionado'];
   #if (!isset($cliente_selecionado)) { $cliente_selecionado = $_POST['cliente_selecionado']; }
  
   if (!isset($acao)) 
   	$acao = $_GET['acao'];

   if (!isset($tela_anterior))
   	$tela_anterior = $_GET['tela_anterior'];


   #$acao_cadastro = $_POST['acao_cadastro'];
   #$modo_listagem = $_POST['modo_listagem'];
   #$inic = $_POST['inic'];
   #$valor_pesquisa = $_POST['valor_pesquisa'];
?>

<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Chamada</h2>
<?php
   include("comum/acsbd.php");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   if($acao=="editar_chamada")
      $dados_chamada = $acsbd->obtem_dados_chamada($chamada_selecionada);
   else
      $dados_chamada["id_cliente"] = $cliente_selecionado;
   $dados_cliente = $acsbd->obtem_dados_cliente($dados_chamada["id_cliente"]);
   $acsbd->desconectar();
?>
<form name=form_cadastro action="ctl_cadastro_chamada.php" method="POST">
<?php
   if(isset($exclusao_cliente))
      echo("<input type=hidden name=exclusao_cliente value=on>");
?>



<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=tela_anterior value='<?php echo($tela_anterior); ?>'>
<input type=hidden name=acao_cadastro>
<input type=hidden name=chamada_selecionada value='<?php echo($chamada_selecionada); ?>'>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name='dados_chamada[id_cliente]' value='<?php echo($dados_chamada["id_cliente"]); ?>'>
<input type=hidden name='modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name='inic' value='<?php echo($inic); ?>'>
<input type=hidden name='valor_pesquisa' value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<center>
<table>
<tr>
<td>Nome:</td>
<td><?php echo($dados_cliente["nm_cliente"]); ?></td>
</tr>
<tr>
<td>Telefone:</td>
<td><?php echo($dados_cliente["telefone"]); ?></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><?php echo($dados_cliente["endereco"]); ?></td>
</tr>
<tr>
<td>Observa&ccedil;&atilde;o:</td>
<td><?php echo($dados_cliente["observacao"]); ?></td>
</tr>
<tr>
<td>Produto:</td>
<td><input type=text size=40 name='dados_chamada[produto]' value='<?php echo($dados_chamada["produto"]); ?>'></td>
</tr>
<tr>
<td>Defeito:</td>
<td><input type=text size=60 name='dados_chamada[defeito]' value='<?php echo($dados_chamada["defeito"]); ?>'></td>
</tr>
<tr>
<td>Observa&ccedil;&atilde;o:</td>
<td><textarea name='dados_chamada[observacao]'>
<?php echo($dados_chamada["observacao"]); ?>
</textarea></td>
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
