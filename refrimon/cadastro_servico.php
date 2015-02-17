<html>
<head>
<title>Servi&ccedil;o Prestado</title>
<script>

function muda_acao_cadastro(acao_cadastro)
{
document.form_cadastro.acao_cadastro.value=acao_cadastro;
document.form_cadastro.submit();
}


</script>
</head>
<?php
/*
	if ($acao == "" || !isset($acao) || empty($acao))
	{
		$aviso = $_POST['aviso'];
		$acao = $_POST['acao'];
		$acao_cadastro =  $_POST['acao_cadastro'];
		$tela_anterior =  $_POST['tela_anterior'];
		$cliente_selecionado =  $_POST['cliente_selecionado'];
		$servico_selecionado =  $_POST['servico_selecionado'];
		$modo_listagem =  $_POST['modo_listagem'];
		$inic =  $_POST['inic'];
		$valor_pesquisa =  $_POST['valor_pesquisa'];
		$veiculo_selecionado =  $_POST['veiculo_selecionado'];
		$lista_pecas_usadas =  $_POST['lista_pecas_usadas'];
		$lista_contas_receber =  $_POST['lista_contas_receber'];

		if (!isset($_POST) || empty($_POST) || is_null($_POST))
		{
			$acao = $_GET['acao'];
			$cliente_selecionado = $_GET['cliente_selecionado'];
			$inic = $_GET['inic'];
			$modo_listagem = $_GET['modo_listagem'];
			$servico_selecionado = $_GET['servico_selecionado'];
			$tela_anterior = $_GET['tela_anterior'];
			$valor_pesquisa = $_GET['valor_pesquisa'];
		}
	}
*/

	if ($_GET['acao'] == "editar_servico")
	{
		$acao = $_GET['acao'];
		$servico_selecionado = $_GET['servico_selecionado'];
		$tela_anterior = $_GET['tela_anterior'];
		$cliente_selecionado = $_GET['cliente_selecionado'];
		$modo_listagem = $_GET['modo_listagem'];
		$inic = $_GET['inic'];
		$valor_pesquisa = $_GET['valor_pesquisa'];
	}



?>
<?php
	include("comum/comum.php");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">

<h2>Servi&ccedil;o Prestado</h2><br>
<?php
	echo("<h3>$aviso</h3>");
?>
<br>
<?php
	include("comum/acsbd.inc");
	$acsbd = new AcsBD();
	$acsbd->conectar();
	if($acao=="incluir_servico")
	{
		if(($acao_cadastro=="seleciona_chamada")&&(isset($chamada_selecionada))&&($chamada_selecionada!='NENHUMA'))
		{
			$dados_chamada = $acsbd->obtem_dados_chamada($chamada_selecionada);
			$dados_servico["produto"]=$dados_chamada["produto"];
			$dados_servico["defeito"]=$dados_chamada["defeito"];
		}
		if(!isset($dados_servico["data"]))
			$dados_servico["data"]=obtem_data();
			$lista_chamadas = $acsbd->obtem_lista_chamadas_cliente($cliente_selecionado);
		}
		elseif($acao=="editar_servico") 
			if(!isset($dados_servico)) 
			{
				$dados_servico = $acsbd->obtem_dados_servico($servico_selecionado);
				$dados_servico["data"] = formata_data_padrao($dados_servico["data"]);
				$lista_pecas_usadas = $acsbd->obtem_lista_peca_usada_unico_servico($servico_selecionado);
				if(isset($lista_pecas_usadas))
				{
					reset($lista_pecas_usadas);
					while(list($k,$registro)=each($lista_pecas_usadas))  
					{
						$lista_pecas_usadas[$k]["prefixo_nome"] = $registro["prefixo"]." - ".$registro["nm_peca"];
						$lista_pecas_usadas[$k]["ANTIGA"] = "SIM";
					}
				}
				$lista_contas_receber = $acsbd->obtem_lista_contas_receber_servico($servico_selecionado);
				if(isset($lista_contas_receber))
				{
					reset($lista_contas_receber);
					while(list($k,$registro)=each($lista_contas_receber))  
					{
						$lista_contas_receber[$k]["data"] = formata_data_padrao($registro["data"]);
						$lista_contas_receber[$k]["ANTIGA"] = "SIM";
					}
				}
			}
			$acsbd->desconectar();
?>

<form name=form_cadastro action='ctl_cadastro_servico.php' method=POST>
<input type=hidden name='acao' value='<?php print $acao; ?>'>
<input type=hidden name='acao_cadastro' >
<input type=hidden name='tela_anterior' value='<?php print $tela_anterior; ?>'>
<input type=hidden name='cliente_selecionado' value='<?php print $cliente_selecionado; ?>'>
<input type=hidden name='servico_selecionado' value='<?php print $servico_selecionado; ?>'>
<input type=hidden name='modo_listagem' value='<?php print $modo_listagem; ?>'>
<input type=hidden name='inic' value='<?php print $inic; ?>'>
<input type=hidden name='valor_pesquisa' value='<?php print stripslashes($valor_pesquisa); ?>'>
<input type=hidden name='veiculo_selecionado' value='<?php print $veiculo_selecionado; ?>'>
<?php
	if(isset($lista_pecas_usadas))
	{
		reset($lista_pecas_usadas);
		while(list($k,$registro)=each($lista_pecas_usadas))
		{
			echo("<input type=hidden name='lista_pecas_usadas[$k][id_peca]' value='".$registro["id_peca"]."'>\n");
			echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade]' value='".$registro["quantidade"]."'>\n");
			echo("<input type=hidden name='lista_pecas_usadas[$k][prefixo_nome]' value='".stripslashes($registro["prefixo_nome"])."'>\n");
			echo("<input type=hidden name='lista_pecas_usadas[$k][unidade]' value='".stripslashes($registro["unidade"])."'>\n");
			#//   echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade_estoque]' value='".$registro["quantidade_estoque"]."'>\n");
			echo("<input type=hidden name='lista_pecas_usadas[$k][ANTIGA]' value='".$registro["ANTIGA"]."'>\n");
		}
	}
	if(isset($lista_contas_receber))
	{
		reset($lista_contas_receber);
		while(list($i,$conta)=each($lista_contas_receber))
		{
			echo("<input type=hidden name='lista_contas_receber[$i][id_conta]' value='".$conta["id_conta"]."'>\n");
			echo("<input type=hidden name='lista_contas_receber[$i][data]' value='".$conta["data"]."'>\n");
			echo("<input type=hidden name='lista_contas_receber[$i][valor]' value='".$conta["valor"]."'>\n");
			echo("<input type=hidden name='lista_contas_receber[$i][ANTIGA]' value='".$conta["ANTIGA"]."'>\n");
		}
	}
?>
<center>
<table>
<?php
	if($acao=="incluir_servico") 
	{
		if(!empty($lista_chamadas))
		{
			echo("<tr><td>Referente &agrave; chamada:</td><td><select name=chamada_selecionada onchange=muda_acao_cadastro('seleciona_chamada')>");
			$sel=($chamada_selecionada=='NENHUMA'?"selected":"");
			echo("<option value='NENHUMA' $sel>Escolha uma chamada</option>");
			while(list($i,$chamada)=each($lista_chamadas))
			{
				$sel=($chamada_selecionada==$chamada["id_chamada"]?"selected":"");
				echo("<option value=".$chamada["id_chamada"]." $sel>(".zerosEsquerda($chamada["id_chamada"],5).") ".  $chamada["produto"]." - ".$chamada["defeito"]."</option>");
			}
			echo("</select></td></tr>");
			echo("<tr>");
			echo("<td>N&atilde;o apagar chamada</td>");
			echo("<td><input type=checkbox name=chk_nao_apagar_chamada ".(isset($chk_nao_apagar_chamada)?"checked":"")."></td>");
			echo("</tr>");
		}
	}
?>
<tr>
<td>Produto:</td>
<td><input type="text" name='dados_servico[produto]' size=40 value='<?php echo(stripslashes($dados_servico["produto"])); ?>'></td>
</tr>
<tr>
<td>Defeito:</td>
<td><input type="text" name='dados_servico[defeito]' size=40 value='<?php echo(stripslashes($dados_servico["defeito"])); ?>'></td>
</tr>
<tr>
<td>Descri&ccedil;&atilde;o do Servi&ccedil;o:</td>
<td><input type="text" name='dados_servico[descricao]' size=40 value='<?php echo(stripslashes($dados_servico["descricao"])); ?>'></td>
</tr>
<tr>
<td>Data:</td>
<td><input type="text" name='dados_servico[data]' readonly size=10 value='<?php echo(stripslashes($dados_servico["data"])); ?>'></td>
</tr>
<tr>
<td>Valor (<?php echo($unidade_monetaria); ?>):</td>
<td><input type=text name='dados_servico[valor]' size=10 value='<?php echo(stripslashes($dados_servico["valor"])); ?>'></td>
</tr>

<?php if($acao=="incluir_servico"): ?>
<tr>
<td>Valor j&aacute; Pago (<?php echo($unidade_monetaria); ?>):</td>
<td><input type=text name='dados_servico[valor_pago]' size=10 value='<?php echo(stripslashes($dados_servico["valor_pago"])); ?>'></td>
</tr>
<?php endif; ?>

<tr>
<tr>
<td>Garantia:</td>
<td><input type=text name='dados_servico[garantia]' size=15 value='<?php echo(stripslashes($dados_servico["garantia"])); ?>'></td>
</tr>
<td>Observa&ccedil;&atilde;o:</td>
<td>
<textarea name='dados_servico[observacao]'>
<?php
   print stripslashes($dados_servico["observacao"]);
?>
</textarea>
</td>
</tr>
<tr>
<td><input type="button" value='Pe&ccedil;as usadas' onclick=muda_acao_cadastro('pecas_usadas')></td>
<td>
<?php
   if(empty($lista_pecas_usadas))
      echo("Nenhuma pe&ccedil;a usada");
   else
   {
      echo("Pe&ccedil;as usadas<br>");
      echo("<table>");
      reset($lista_pecas_usadas);
      while(list($id_peca,$registro)=each($lista_pecas_usadas))
         echo("<tr><td>(".$registro["quantidade"]." ".stripslashes($registro["unidade"]).")</td><td>".stripslashes($registro["prefixo_nome"])."</td></tr>");
      echo("</table>");
   }
?>
</td>
</tr>

<tr>
<td><input type=button value='Pagamentos' onclick=muda_acao_cadastro('pagamentos')></td>
<td>
<?php
  if(empty($lista_contas_receber))
     echo("Nenhuma pagamento agendado");
  else
  {
     echo("Pagamentos agendados<br>");
     echo("<table>");
     reset($lista_contas_receber);
     while(list($i,$conta)=each($lista_contas_receber))
       if((!isset($conta["ANTIGA"]))||($conta["ANTIGA"]!="APAGAR"))
         echo("<tr><td>".$conta["data"]."</td><td> - </td><td>$unidade_monetaria ".$conta["valor"]."</td></tr>");
     echo("</table>");
  }
?>
</td>
</tr>
</table>
<table>
<tr>
<td><input type=button value="  OK  " onclick=muda_acao_cadastro('confirmar')></td>
<td><input type=button value="Voltar" onclick=muda_acao_cadastro('voltar')></td>
</tr>
</table>
</center>
</form>
</body>
</html>
