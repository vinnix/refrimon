<html>

<head>
<title>Pe&ccedil;as - Refrigera&ccedil;&atilde;o Montagner</title>
<script>

function muda_listagem_peca(modo)
{
   document.form_lista.modo_listagem_peca.value = modo;
   document.form_lista.acao_listagem_peca.value = "listar";
   document.form_lista.submit();
}

function muda_acao_listagem_peca(acao)
{
   document.form_lista.acao_listagem_peca.value = acao;
   document.form_lista.submit();
}


</script>
</head>
<?php
   if(!isset($modo_listagem_peca))
      $modo_listagem_peca = "prefixo";
   if($modo_listagem_peca!="pesquisa_nome")
      $valor_pesquisa_peca="";
?>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Pe&ccedil;as Usadas</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3><br>
<form name=form_lista action="ctl_cadastro_peca_usada_servico.php" method="POST">
<input type=hidden name=modo_listagem_peca value='<?php echo($modo_listagem_peca); ?>'>
<input type=hidden name=acao_listagem_peca>
<input type=hidden name=tela_anterior value='<?php echo($tela_anterior); ?>'>
<input type=hidden name=acao value='<?php echo($acao); ?>'>
<input type=hidden name=acao_cadastro value='<?php echo($acao_cadastro); ?>'>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=servico_selecionado value='<?php echo($servico_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=chamada_selecionada value='<?php echo($chamada_selecionada); ?>'>
<?php
   if(isset($chk_nao_apagar_chamada))
      echo("<input type=hidden name=chk_nao_apagar_chamada value='on'>");
   while(list($campo,$valor)=each($dados_servico))
   {
      echo("<input type=hidden name='dados_servico[$campo]' value='".stripslashes($valor)."'>\n");
   }
   if(isset($lista_pecas_usadas))
   {
      reset($lista_pecas_usadas);
      while(list($k,$registro)=each($lista_pecas_usadas))
      {
         echo("<input type=hidden name='lista_pecas_usadas[$k][id_peca]' value='".$registro["id_peca"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade]' value='".$registro["quantidade"]."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][prefixo_nome]' value='".stripslashes($registro["prefixo_nome"])."'>\n");
         echo("<input type=hidden name='lista_pecas_usadas[$k][unidade]' value='".stripslashes($registro["unidade"])."'>\n");
//         echo("<input type=hidden name='lista_pecas_usadas[$k][quantidade_estoque]' value='".$registro["quantidade_estoque"]."'>\n");
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
<tr><td>
<table>
<tr>
<td align=center>
Prefixo
<select name=prefixo_selecionado onchange=muda_listagem_peca('prefixo')>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_prefixos = $acsbd->obtem_lista_prefixo();
   $lista_veiculos = $acsbd->obtem_lista_veiculo();
   while(list($i,$prefixo)=each($lista_prefixos))
   {
      if(!isset($prefixo_selecionado))
         $prefixo_selecionado = $prefixo;
      $sel=($prefixo_selecionado==$prefixo)?"selected":"";
      echo("<option value='$prefixo' $sel>$prefixo</option>");
   }
?>
</select>
</td>
</tr>

<tr align=left>
<td>
Pesquisa:<br>
<input type=text name=valor_pesquisa_peca value='<?php echo(stripslashes($valor_pesquisa_peca)); ?>' size=30>
<input type=button value="Por Nome" onclick=muda_listagem_peca('pesquisa_nome');>
</td>
</tr>

<tr>
<td align=center>
<?php
   switch($modo_listagem_peca)
   {
      case "prefixo":$lista_pecas = $acsbd->obtem_lista_pecas_prefixo($prefixo_selecionado);
                     break;
      case "pesquisa_nome":$lista_pecas = $acsbd->obtem_lista_pecas_nome($valor_pesquisa_peca);
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
<input type=button value='   >>   ' onclick=muda_acao_listagem_peca('incluir')>
</td></tr>
<tr><td align=center>
<input type=button value='   <<   ' onclick=muda_acao_listagem_peca('excluir')><br>
</td></tr>
<tr><td align=center>
<input type=button value='Muda Qtd' onclick=muda_acao_listagem_peca('muda_qtd')><br>
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
      while(list($k,$registro)=each($lista_pecas_usadas))
      {
         if((!isset($registro["ANTIGA"]))||($registro["ANTIGA"])=="") {
           if(!isset($peca_usada_selecionada))
              $peca_usada_selecionada=$k;
           $sel = $peca_usada_selecionada==$k?"selected":"";
           echo("<option value=$k $sel>(".$registro["quantidade"]." ".stripslashes($registro["unidade"]).") ".stripslashes($registro["prefixo_nome"])."</option>");
         }
      }
   }
?>
</select>
</td>
</tr>
</table>
<table>
<tr>
<td>Origem: <select name=veiculo_selecionado>
<?php
   if(!isset($veiculo_selecionado))
      $veiculo_selecionado=0;
   $sel=$veiculo_selecionado==0?"selected":"";
   echo("<option value=0 $sel>Estoque</option>");
   while(list($i,$veiculo)=each($lista_veiculos))
   {
      $sel=$veiculo_selecionado==$veiculo["id_veiculo"]?"selected":"";
      echo("<option value=".$veiculo["id_veiculo"]." $sel>".$veiculo["descricao"]."</option>");
   }
   

?>
</select>
</td>
</tr>
<tr>
<td align=center><input type=button value='Voltar' onclick=muda_acao_listagem_peca('voltar')></td>
</tr>
</table>
</center>
</form>
</body>

</html>
