<html>

<head>
<title>Clientes - Refrigeração Montagner</title>
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
   $inic = $_GET["inic"];
   if(!isset($inic))
      $inic = $_POST["inic"];
   if(!isset($inic))
      $inic = "A";

   $valor_pesquisa = $_GET["valor_pesquisa"];
   if(!isset($valor_pesquisa))
     $valor_pesquisa = $_POST["valor_pesquisa"];
   if (!isset($valor_pesquisa))
     $valor_pesquisa = "";
  
   $modo_listagem =  $_GET["modo_listagem"]; 
   if(!isset($modo_listagem)) 
        $modo_listagem =  $_POST["modo_listagem"];
   if(!isset($modo_listagem))
      $modo_listagem = "inicial";
   
?>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Clientes</h2>
<br>
<h3>
<?php
  if(isset($aviso))
    echo($aviso);
?>
</h3><br>
<form name=form_lista action="ctl_lista_cliente.php" method="POST">
<input type=hidden name=modo_listagem value='<?php echo($modo_listagem); ?>'>
<input type=hidden name=acao>
<input type=hidden name=inic value='<?php echo($inic); ?>'>
<center>
<?php
   for($i="A";$i!="AA";$i++)
      echo("<a href=\"lista_cliente.php?inic=$i\">$i</a>  ");
   echo("<a href=\"lista_cliente.php?inic=0\">%</a>  ");
?>
</center>
<table>
<tr align=left>
<td>
Pesquisa:<br>
<input type=text name=valor_pesquisa value='<?php echo(stripslashes($valor_pesquisa)); ?>' size=30>
<input type=button value="Por Nome" onclick=muda_listagem('pesquisa_nome');>
<input type=button value="Por Endere&ccedil;o" onclick=muda_listagem('pesquisa_endereco');>
<input type=button value="Por Telefone" onclick=muda_listagem('pesquisa_telefone');>
<input type=button value="Por O.S." onclick=muda_listagem('pesquisa_id_chamada');>
</td>
</tr>

<tr>
<td>
<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   switch($modo_listagem)
   {
      case "inicial":$lista_clientes = $acsbd->obtem_lista_clientes_inicial($inic);
                     break;
      case "pesquisa_nome":$lista_clientes = $acsbd->obtem_lista_clientes_nome($valor_pesquisa);
                           break;
      case "pesquisa_endereco":$lista_clientes = $acsbd->obtem_lista_clientes_endereco($valor_pesquisa);
                               break;
      case "pesquisa_telefone":$lista_clientes = $acsbd->obtem_lista_clientes_telefone($valor_pesquisa);
                               break;
      case "pesquisa_id_chamada":$lista_clientes = $acsbd->obtem_lista_clientes_id_chamada($valor_pesquisa);
                               break;
   }
   if(!empty($lista_clientes))
   {
      echo("<table><tr><td>");
      echo("<select name=cliente_selecionado size=10 onclick=muda_acao('exibicao_rapida')>");
      $cont=0;
      $dados_cliente_selecionado = "";
      while(list($i,$cliente)=each($lista_clientes))
      {
         if(!isset($cliente_selecionado))
            $cliente_selecionado=$cliente["id_cliente"];
         $sel=($cliente_selecionado==$cliente["id_cliente"]?"selected ":"");
         if($cliente_selecionado==$cliente["id_cliente"])
            $dados_cliente_selecionado = $cliente;
         echo("<option value='".$cliente["id_cliente"]."' $sel>".$cliente["nm_cliente"]);
         if($modo_listagem=="pesquisa_endereco")
            echo(" (".$cliente["endereco"].")");
         if($modo_listagem=="pesquisa_telefone")
            echo(" (".$cliente["telefone"].")");
         echo("</option>");
         $cont++;
      }
      echo("</select><br>");
      echo("<b>Total: $cont</b>");
      echo("</td><td align=left valign=top>");

      echo("<table>");
      echo("<tr>");
      echo("<td><b>Nome:</b></td>");
      echo("<td valign=top>".$dados_cliente_selecionado["nm_cliente"]."</td>");
      echo("</tr>");
      echo("<tr>");
      echo("<td valign=top><b>Telefone:</b></td>");
      echo("<td>".$dados_cliente_selecionado["telefone"]."</td>");
      echo("</tr>");
      echo("<tr>");
      echo("<td valign=top><b>Endere&ccedil;o:</b></td>");
      echo("<td>".$dados_cliente_selecionado["endereco"]."</td>");
      echo("</tr>");
      echo("<tr>");
      echo("<td valign=top><b>Observa&ccedil;&atilde;o:</b></td>");
      echo("<td>");
      echo($dados_cliente_selecionado["observacao"]);
      echo("</td>");
      echo("</tr>");
      echo("<tr>");
      echo("<td valign=top><b>Data de cadastro:</b></td>");
      echo("<td>".formata_data_padrao($dados_cliente_selecionado["data_cadastro"])."</td>");
      echo("</tr>");
      echo("</table>");

      echo("</td></tr></table>");
   }
   else
      echo("<center>Nenhum cliente selecionado</center>");
   $acsbd->desconectar();
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
<input type=button value="Chamada" onclick=muda_acao("incluir_chamada");>
<input type=button value="Servi&ccedil;o" onclick=muda_acao("incluir_servico");>
</td>
<td align=right width=200>
<input type=button value="Exibir" onclick=muda_acao("exibir");>
<input type=button value="Editar" onclick=muda_acao("editar");>
<input type=button value="Excluir" onclick=muda_acao("excluir");>
</td>
</tr>
<tr>
<td></td>
<td align=center>
<!-- <input type=button value="Hist&oacute;rico" onclick=muda_acao("historico");> -->
<input type=button value="Recebimento de Conta" onclick=muda_acao("recebimento")>
</td>
</tr>
</table>
</form>
</body>

</html>
