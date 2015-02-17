<html>
<head>
<title>Listagem de Chamadas</title>
<script>

function muda_acao(acao)
{
   document.form_lista.acao.value = acao;
   document.form_lista.submit();
}


function sel_apaga_tudo()
{
   var linhas = document.form_lista.num_linhas.value;
   for(var i=0;i<linhas;i++)
      document.form_lista.elements[i*2].checked=document.form_lista.chk_apaga_tudo.checked;
}

function sel_imprime_tudo()
{
   var linhas = document.form_lista.num_linhas.value;
   for(var i=0;i<linhas;i++)
      document.form_lista.elements[i*2+1].checked=document.form_lista.chk_imprime_tudo.checked;
}


</script>
</head>
<?
   include("comum/comum.inc");
?>
<body bgcolor="<? echo($cor_fundo_principal); ?>">
<h2>Listagem de Chamadas</h2><br>
<h3>
<?
   echo($aviso);
?>
</h3>
<center>
<form name=form_lista action="ctl_lista_chamada.php" method=POST>
<?
   function cmp_cliente($a,$b)
   {
      if($a["nm_cliente"]==$b["nm_ cliente"])
         return 0;
      elseif($a["nm_cliente"]<$b["nm_cliente"])
         return -1;
      else 
         return 1;
   }

   function cmp_data_hora($a,$b)
   {
      if($a["data"]==$b["data"])
         return 0;
      elseif($a["data"]<$b["data"])
         return -1;
      else 
         return 1;
   }

   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_chamadas = $acsbd->obtem_lista_chamadas();
   $acsbd->desconectar();

   if(empty($lista_chamadas))
      echo("N&atilde;o h&aacute; chamadas cadastradas");
   else
   {
      if(!isset($campo_ordenacao))
         $campo_ordenacao="data_hora";
      $seta_cliente="";
      $seta_data_hora="";
      switch($campo_ordenacao)
      {
         case "cliente":
            $seta_cliente="<font face=Wingdings>ò</font>";
            usort($lista_chamadas,"cmp_cliente");
            break;
         case "data_hora":
            $seta_data_hora="<font face=Wingdings>ò</font>";
            usort($lista_chamadas,"cmp_data_hora");
            break;
      }
      $j=0;
      echo("<table border=1>\n<th>\n<td>Apagar</td><td>Imprimir</td><td><a href='lista_chamada.php?campo_ordenacao=cliente'>Cliente</a> $seta_cliente</td><td>Produto/Defeito</td><td><a href='lista_chamada.php?campo_ordenacao=data_hora'>Data/Hora</a> $seta_data_hora</td><td>Observacao</td>\n</th>\n");
      while(list($i,$chamada)=each($lista_chamadas))
      {
         $j++;
         echo("<tr>");
         echo("<td><a href='cadastro_chamada.php?acao=editar_chamada&chamada_selecionada=".$chamada["id_chamada"]."&tela_anterior=lista_chamada.php'>Editar</a></td>");
         echo("<td><input type=checkbox name=chk_apagar[$j] value=".$chamada["id_chamada"]."></td>");
         echo("<td><input type=checkbox name=chk_imprimir[$j] value=".$chamada["id_chamada"]."></td>");
         echo("<td><table>");
         if(!empty($chamada["nm_cliente"]))
            echo("<tr><td>".$chamada["nm_cliente"]."</td></tr>");
         if(!empty($chamada["endereco"]))
            echo("<tr><td>".$chamada["endereco"]."</td></tr>");
         if(!empty($chamada["telefone"]))
            echo("<tr><td>".$chamada["telefone"]."</td></tr>");
         if(!empty($chamada["observacao_cliente"]))
            echo("<tr><td>".$chamada["observacao_cliente"]."</td></tr>");
         echo("</table></td>");
         echo("<td><table><tr><td>".$chamada["produto"]."</td></tr>");
         echo("<tr><td>".$chamada["defeito"]."</td></tr></table></td>");
         echo("<td>".zerosEsquerda($chamada["id_chamada"],5)."<br>".formata_data_hora($chamada["data"])."</td>");
         echo("<td>".$chamada["observacao"]."</td>");
         echo("</tr>");
      }
      echo("<tr><td>Selecionar tudo</td>");
      echo("<td><input type=checkbox name=chk_apaga_tudo onclick=sel_apaga_tudo()></td>");
      echo("<td><input type=checkbox name=chk_imprime_tudo onclick=sel_imprime_tudo()></td></tr>");
      echo("</table>");
      echo("<b>Total: $j</b>");
   }
?>
<table>
<tr>
<td align=right><input type=button value='Apagar' onclick=muda_acao('apagar')></td>
<td align=right><input type=button value='Imprimir' onclick=muda_acao('imprimir')></td>
<!--<td align=right><input type=button value='Imprimir' onclick=window.open('imprime_chamada.php?num_colunas='+retorna_str())></td>-->
<td> Colunas:<input type=radio name=num_colunas value=2>2<input type=radio name=num_colunas value=3 checked>3</td>
</tr>
</table>
</center>
<input type=hidden name=acao>
<input type=hidden name=num_linhas value=<? echo($j); ?>>
</form>
</form>
</body>
</html>
