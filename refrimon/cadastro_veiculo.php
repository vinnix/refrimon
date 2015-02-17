<?php
   include("comum/acsbd.inc");
   $acsbd = new AcsBD();
   $acsbd->conectar();
   $lista_veiculos = $acsbd->obtem_lista_veiculo();
   $acsbd->desconectar();
?>
<html>

<head>
<title>Cadastro de Ve&iacute;culos</title>
<script>

function muda_acao(acao)
{
   document.form_cadastro.acao.value = acao;
   document.form_cadastro.submit();
}


</script>
</head>
<?php
   include("comum/comum.inc");
?>
<body bgcolor="<?php echo($cor_fundo_principal); ?>">
<h2>Ve&iacute;culos</h2><br>
<h3>
<?php
   echo($aviso);
?>
<form name=form_cadastro action='ctl_cadastro_veiculo.php' method='POST'>
<input type=hidden name=acao>
<center>
<table>
<tr>
<td>Novo ve&iacute;culo:<input type=text name=nm_novo_veiculo size=20></td>
<td><input type=button value='Incluir' onclick=muda_acao('incluir')></td>
</tr>
<tr>
<td align=center>
<?php
   if(empty($lista_veiculos))
      echo("Nenhum ve&iacute;culo cadastrado");
   else
   {
      echo("<select name=veiculo_selecionado size=10>\n");
      while(list($i,$veiculo)=each($lista_veiculos))
      {
         if(!isset($veiculo_selecionado))
            $veiculo_selecionado=$veiculo["id_veiculo"];
         $sel=($veiculo_selecionado==$veiculo["id_veiculo"]?"selected":"");
         echo("<option value = ".$veiculo["id_veiculo"]." $sel>".$veiculo["descricao"]."</option>");
      }
      echo("</select>");
   }
?>
</td>
<?php
   if(!empty($lista_veiculos))
      echo("<td valign=center><input type=button value='Excluir' onclick=muda_acao('excluir')></td>");
?>
</tr>
</table>
</center>
</form>
</body>
</html>
