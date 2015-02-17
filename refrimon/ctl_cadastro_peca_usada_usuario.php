<?php
   $acao = $_POST['acao'];
   $lista_pecas_usadas = $_POST['lista_pecas_usadas'];
   $modo_listagem = $_POST['modo_listagem'];
   $peca_selecionada = $_POST['peca_selecionada'];
   $peca_usada_selecionada = $_POST['peca_usada_selecionada'];
   $prefixo_selecionado = $_POST['prefixo_selecionado'];
   $qtd_usada = $_POST['qtd_usada'];
   $usuario_selecionado = $_POST['usuario_selecionado'];
   $valor_pesquisa = $_POST['valor_pesquisa'];


   switch($acao)
   {
      case "listar":
         include("cadastro_peca_usada_usuario.php");
         break;
      case "incluir":
         if(isset($peca_selecionada))
         {
            include("comum/comum.inc");
            if(!$qtd_usada=formata_decimal_mysql($qtd_usada))
               $aviso = "Quantidade usada inv&aacute;lida";
            if(!$aviso)
            {
               include("comum/acsbd.inc");
               $acsbd = new AcsBD();
               $acsbd->conectar(); 
               $peca = $acsbd->obtem_dados_peca($peca_selecionada);
               $acsbd->desconectar();
               if($qtd_usada<=$peca["quantidade"])
               {
                  $lista_pecas_usadas[$peca_selecionada]["quantidade"]=$qtd_usada;
                  $lista_pecas_usadas[$peca_selecionada]["prefixo_nome"]=$peca["prefixo"]." - ".$peca["nm_peca"];
                  $lista_pecas_usadas[$peca_selecionada]["unidade"]=$peca["unidade"];
                  $lista_pecas_usadas[$peca_selecionada]["quantidade_estoque"]=$peca["quantidade"];
               }
               else
                  $aviso="Quantidade em estoque ( ".$peca["quantidade"]." ".$peca["unidade"]." ) da peca '".$peca["prefixo"]."-".$peca["nm_peca"]."' &eacute; menor do que a requisitada";
            }
         }
         else
            $aviso = "Selecione uma pe&ccedil;a para adicionar à lista";
         include("cadastro_peca_usada_usuario.php");
         break;
      case "excluir":
         if(isset($peca_usada_selecionada))
            unset($lista_pecas_usadas[$peca_usada_selecionada]);
         else
            $aviso = "Selecione uma pe&ccedil;a para excluir da lista";
         include("cadastro_peca_usada_usuario.php");
         break;
      case "muda_qtd":
         if(isset($peca_usada_selecionada))
         {
            include("comum/comum.inc");
            if(!$qtd_usada=formata_decimal_mysql($qtd_usada))
               $aviso = "Quantidade usada inv&aacute;lida";
            if(!$aviso)
               $lista_pecas_usadas[$peca_usada_selecionada]["quantidade"]=$qtd_usada;
         }
         else
            $aviso = "Selecione uma pe&ccedil;a para mudar a quantidade usada";
         include("cadastro_peca_usada_usuario.php");
         break;
      case "confirmar":
         if(!isset($usuario_selecionado))
            $aviso = "Selecione um usu&aacute;rio";
         if(!$aviso)
            if(empty($lista_pecas_usadas))
               $aviso = "Adicione alguma pe&ccedil;a à lista de pe&ccedil;as usadas";
        if(!$aviso)
        {
           include("comum/acsbd.inc");
           $acsbd = new AcsBD();
           $acsbd->conectar();
           while(list($id_peca,$registro)=each($lista_pecas_usadas))
           {
              if($usuario_selecionado==0)
                 $acsbd->registra_peca_usada_oficina($id_peca,$registro["quantidade"]);
              else
                 $acsbd->registra_peca_usada_usuario($usuario_selecionado,$id_peca,$registro["quantidade"]);
              $acsbd->altera_quantidade_peca($id_peca,$registro["quantidade_estoque"]-$registro["quantidade"]);
           }
           $acsbd->desconectar();
           unset($usuario_selecionado);
           unset($lista_pecas_usadas);
           $aviso="Opera&ccedil;&atilde;o efetuada";
        }
        include("cadastro_peca_usada_usuario.php");
   }
?>
