<html>
<head>
<title>Hist&oacute;rico do Cliente</title>
<script>

function muda_acao(acao)
{
   document.form_historico.acao.value=acao;
   document.form_historico.submit();
}

function sel_apaga_todas_chamadas()
{
   var linhas = document.form_historico.num_linhas_chamadas.value;
   for(var i=0;i<linhas;i++)
      document.form_historico.elements[i].checked=document.form_historico.chk_apaga_todas_chamadas.checked;
}

</script>
</head>
<?php
   function cmp_data_hora($a,$b)
   {
      if($a["data"]==$b["data"])
         return 0;
      elseif($a["data"]<$b["data"])
         return -1;
      else 
         return 1;
   }


   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_impressao); ?>">

<h2>Dados do Cliente</h2><br>
<h3>
<?php
   echo($aviso);
?>
</h3>

<?php
      include("comum/acsbd.inc");
      $acsbd = new AcsBD();
      $acsbd->conectar();
      $dados = $acsbd->obtem_dados_cliente($cliente_selecionado);
      $lista_chamadas = $acsbd->obtem_lista_chamadas_cliente($cliente_selecionado);
      $lista_servicos = $acsbd->obtem_lista_servicos_cliente($cliente_selecionado);
      if(!empty($lista_servicos))
         while(list($i,$servico)=each($lista_servicos))
            $lista_servicos[$i]["lista_contas_receber"] = $acsbd->obtem_lista_contas_receber_servico($servico["id_servico"]);
      $acsbd->desconectar();
?>

<form name=form_historico action="ctl_lista_historico_cliente.php" method="POST">
<center>
<table>
<tr>
<td>Nome:</td>
<td><?php echo($dados["nm_cliente"]); ?></td>
</tr>
<tr>
<td>Telefone:</td>
<td><?php echo($dados["telefone"]); ?></td>
</tr>
<tr>
<td>Endere&ccedil;o:</td>
<td><?php echo($dados["endereco"]); ?></td>
</tr>
<tr>
<td>Observa&ccedil;&atilde;o:</td>
<td>
<?php echo($dados["observacao"]); ?>
</td>
</tr>
<tr>
<td>Data de cadastro:</td>
<td>
<?php echo(formata_data_padrao($dados["data_cadastro"])); ?>
</td>
</tr>
</table>
<h3>Chamadas realizadas</h3><br>
<?php
   if(empty($lista_chamadas))
      echo("N&atilde;o h&aacute; chamadas cadastradas");
   else
   {
      usort($lista_chamadas,"cmp_data_hora");
      $j=0;
      echo("<table border=1>\n<th>\n<td>Apagar</td><td>Produto</td><td>Defeito</td><td>Data/Hora</td><td>Observacao</td>\n</th>\n");
      while(list($i,$chamada)=each($lista_chamadas))
      {
         $j++;
         echo("<tr>");
         echo("<td><a href='cadastro_chamada.php?acao=editar_chamada&chamada_selecionada=".$chamada["id_chamada"]."&tela_anterior=lista_historico_cliente.php&cliente_selecionado=$cliente_selecionado&modo_listagem=$modo_listagem&inic=$inic&valor_pesquisa=".stripslashes($valor_pesquisa).(isset($exclusao_cliente)?"&exclusao_cliente=$exclusao_cliente":"")."'>Editar</a></td>");
         echo("<td><input type=checkbox name=chk_apagar[$j] value=".$chamada["id_chamada"]."></td>");
         echo("<td>".$chamada["produto"]."</td>");
         echo("<td>".$chamada["defeito"]."</td>");
         echo("<td><b>Nr: </b>".zerosEsquerda($chamada["id_chamada"],5)."<br>".formata_data_hora($chamada["data"])."</td>");
         echo("<td>".$chamada["observacao"]."</td>");
         echo("</tr>");
      }
      echo("<tr><td>Selecionar tudo</td>");
      echo("<td><input type=checkbox name=chk_apaga_todas_chamadas onclick=sel_apaga_todas_chamadas()></td></tr>");
      echo("</table>");
      echo("<b>Total: $j</b>");
      echo("<table><tr>");
      echo("<td><input type=button value='Apagar Chamadas Selecionadas' onclick=muda_acao('apagar_chamadas')></td>");
      echo("</tr></table>");

   }
?>


<h3>Servi&ccedil;os Prestados</h3><br>
<?php
   if(empty($lista_servicos))
      echo("N&atilde;o h&aacute; servi&ccedil;os cadastrados");
   else
   {
      echo("<table border=1><th><td>Produto / Defeito</td><td>Descri&ccedil;&atilde;o</td><td>Data</td><td>Valor / Valor Pago</td><td>Contas a Receber<br>Data - Valor</td></th>");
      reset($lista_servicos);
      $k=0;
      while(list($i,$servico)=each($lista_servicos))
      {
         $k++;
         echo("<tr><td><a href='exibe_servico.php?servico_selecionado=".$servico["id_servico"]."&tela_anterior=lista_historico_cliente.php&cliente_selecionado=$cliente_selecionado&modo_listagem=$modo_listagem&inic=$inic&valor_pesquisa=".stripslashes($valor_pesquisa).(isset($exclusao_cliente)?"&exclusao_cliente=$exclusao_cliente":"")."'>Detalhes</a><br><br>");
         echo("<a href='cadastro_servico.php?acao=editar_servico&servico_selecionado=".$servico["id_servico"]."&tela_anterior=lista_historico_cliente.php&cliente_selecionado=$cliente_selecionado&modo_listagem=$modo_listagem&inic=$inic&valor_pesquisa=".stripslashes($valor_pesquisa).(isset($exclusao_cliente)?"&exclusao_cliente=$exclusao_cliente":"")."'>Editar</a></td>");
         echo("<td><table><tr><td>".$servico["produto"]."</td></tr><tr><td>".$servico["defeito"]."</td></tr></table></td>");
         echo("<td>".$servico["descricao"]);
         if($servico["observacao"]!="")
            echo("<br>Obs: ".$servico["observacao"]);
         echo("</td>");
         echo("<td><b>Nr: </b>".zerosEsquerda($servico["id_chamada"],5)."<br>".formata_data_padrao($servico["data"])."</td>");
         echo("<td><table><tr><td>$unidade_monetaria ".formata_decimal_padrao($servico["valor"])."</td></tr>");
         echo("<tr><td>$unidade_monetaria ".formata_decimal_padrao($servico["valor_pago"])."</td></tr></table></td>");
         echo("<td>");
         if(empty($servico["lista_contas_receber"]))
            echo("Conta Encerrada");
         else
         {
            echo("<table>");
            reset($servico["lista_contas_receber"]);
            while(list($l,$conta)=each($servico["lista_contas_receber"]))
               echo("<tr><td>".formata_data_padrao($conta["data"])." - $unidade_monetaria ".$conta["valor"]."</td></tr>");
            echo("</table>");
         }
         echo("</td>");
         echo("</tr>");
      }
      echo("</table>");
      echo("<b>Total: $k</b>");
   }
?>

<table>
<tr>
<?php
   if(isset($exclusao_cliente))
      echo("<td align=right><input type=button value='Confirmar Exclus&atilde;o' onclick='muda_acao(\"confirmar_exclusao\")'></td>");
   else
      echo("<td align=right><input type=button value='Imprimir' onclick='javascritp:self.print()'></td>");
?>
<td align=left><input type=button value='Voltar' onclick=muda_acao('voltar')></td>
</tr>
</table>
</center>
<input type=hidden name=acao>
<?php
   if(isset($exclusao_cliente))
      echo("<input type=hidden name=exclusao_cliente value=on>");
?>
<input type=hidden name=cliente_selecionado value='<?php echo($cliente_selecionado); ?>'>
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<input type=hidden name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>'>
<input type=hidden name=num_linhas_chamadas value=<?php echo($j); ?>>
</form>
</body>
</html>
