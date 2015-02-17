<?php
   ##echo "Debuging: ACSBD: Entering...";
   if(!defined("ACSBD_LIB"))
   {
      define("ACSBD_LIB","ON");

      class AcsBD
      {
         var $bdcon;
         var $nm_servidor="localhost";
         var $nm_banco="bd_refrimon";
         var $nm_usuario="refrimonusr";
         var $nm_pass="refrimonusr9990";


         function conectar()
         {
            $this->bdcon = mysql_connect($this->nm_servidor,$this->nm_usuario,$this->nm_pass);
            mysql_select_db($this->nm_banco,$this->bdcon);
         }

         function desconectar()
         {
            mysql_close($this->bdcon);
         }

         function obtem_codigo_gerado()
         {
            return mysql_insert_id($this->bdcon);
         }

        //==================
        //Metodos de Cliente
        //==================

         function obtem_lista_clientes_inicial($inic)
         {
            if($inic=="0")
              $inic = "[^A-Za-z]";
            $strquery = "select * from cliente where nm_cliente regexp '^$inic' order by nm_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_clientes_nome($nome)
         {
            $strquery = "select * from cliente where nm_cliente like '%".$nome."%' order by nm_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_clientes_endereco($endereco)
         {
            $strquery = "select * from cliente where endereco like '%".$endereco."%' order by nm_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_clientes_telefone($telefone)
         {
            $strquery = "select * from cliente where REPLACE(telefone, '-', '') like '%".str_replace("-","",$telefone)."%' order by nm_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_clientes_id_chamada($valor_pesquisa){
            $strquery = "select * from cliente where id_cliente in (select id_cliente from servico where id_chamada=$valor_pesquisa)";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function inclui_cliente($dados)
         {
            $strquery = "insert into cliente(nm_cliente,telefone,endereco,observacao,data_cadastro) ".
                        "values('".$dados["nm_cliente"]."','".$dados["telefone"].
                        "','".$dados["endereco"]."','".$dados["observacao"]."',now())";
            mysql_query($strquery,$this->bdcon);
         }

         function altera_cliente($id_cliente,$dados)
         {
            $strquery = "update cliente set nm_cliente='".$dados["nm_cliente"]."',".
                                           "telefone='".$dados["telefone"]."',".
                                           "endereco='".$dados["endereco"]."',".
                                           "observacao='".$dados["observacao"]."' ".
                        "where id_cliente=$id_cliente";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_dados_cliente($id_cliente)
         {
            $strquery = "select * from cliente where id_cliente = $id_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            $linha = mysql_fetch_array($query);
            mysql_free_result($query);
            return $linha;
         }

         function exclui_cliente($id_cliente)
         {
            $strquery = "select id_servico from servico where id_cliente=$id_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($servicos[]=mysql_fetch_array($query));
            mysql_free_result($query);
            while(list($i,$servico)=each($servicos))
            {
               $strquery = "delete from conta_recebida where id_servico=".$servico["id_servico"];
               mysql_query($strquery,$this->bdcon);
               $strquery = "delete from peca_usada_servico where id_servico=".$servico["id_servico"];
               mysql_query($strquery,$this->bdcon);
            }
            $strquery = "delete from servico where id_cliente=$id_cliente";
            mysql_query($strquery,$this->bdcon);
            $strquery = "delete from cliente where id_cliente=$id_cliente";
            mysql_query($strquery,$this->bdcon);
         }

         //===============
         //Metodos de Peca
         //===============
  

         function inclui_peca($dados)
         {
            if($dados["valor_compra"]=="")
               $dados["valor_compra"]="null";
            if($dados["valor_venda"]=="")
               $dados["valor_venda"]="null";
            if($dados["quantidade"]=="")
               $dados["quantidade"]=0;
            $strquery = "insert into peca(prefixo,nm_peca,codigo,quantidade,quantidade_minima,unidade,valor_compra,valor_venda,endereco) ".
                        "values('".$dados["prefixo"]."','".$dados["nm_peca"]."','".$dados["codigo"]."',".$dados["quantidade"].",".
                        $dados["quantidade_minima"].",'".$dados["unidade"]."',".$dados["valor_compra"].",".
                        $dados["valor_venda"].",'".$dados["endereco"]."')";
            mysql_query($strquery,$this->bdcon);
         }

         function altera_peca($id_peca,$dados)
         {
            if($dados["valor_compra"]=="")
               $dados["valor_compra"]="null";
            if($dados["valor_venda"]=="")
               $dados["valor_venda"]="null";
            $strquery = "update peca set prefixo='".$dados["prefixo"]."',".
                                           "nm_peca='".$dados["nm_peca"]."',".
                                           "codigo='".$dados["codigo"]."',".
                                           "quantidade_minima=".$dados["quantidade_minima"].",".
                                           "unidade='".$dados["unidade"]."',".
                                           "valor_compra=".$dados["valor_compra"].",".
                                           "valor_venda=".$dados["valor_venda"].",".
                                           "endereco='".$dados["endereco"]."' ".
                        "where id_peca=$id_peca";
            mysql_query($strquery,$this->bdcon);
         }

         function altera_quantidade_peca($id_peca,$quantidade)
         {
            $strquery = "update peca set quantidade=$quantidade where id_peca=$id_peca";
            mysql_query($strquery,$this->bdcon);
         }

         function diminui_quantidade_peca($id_peca,$quantidade)
         {
            $strquery = "update peca set quantidade=quantidade-$quantidade where id_peca=$id_peca";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_prefixo()
         {
            $strquery = "select distinct prefixo from peca order by prefixo";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin["prefixo"];
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_unidade()
         {
            $strquery = "select distinct unidade from peca order by unidade";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin=mysql_fetch_array($query))
               $result[] = $lin["unidade"];
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_pecas_prefixo($prefixo)
         {
            $strquery = "select * from peca where prefixo = '".$prefixo."' order by nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_pecas_nome($nome)
         {
            $strquery = "select * from peca where nm_peca like '%".$nome."%' order by nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_pecas()
         {
            $strquery = "select * from peca order by prefixo,nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_pecas_critico()
         {
            $strquery = "select * from peca where quantidade < quantidade_minima order by prefixo,nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_dados_peca($id_peca)
         {
            $strquery = "select * from peca where id_peca = $id_peca";
            $query = mysql_query($strquery,$this->bdcon);
            $linha = mysql_fetch_array($query);
            mysql_free_result($query);
            return $linha;
         }

         function exclui_peca($id_peca)
         {
            $strquery = "delete from peca where id_peca=$id_peca";
            mysql_query($strquery,$this->bdcon);
         }

         //==================
         //Metodos de Chamada
         //==================

         function inclui_chamada($dados)
         {
            $strquery = "insert into chamada(id_cliente,produto,defeito,observacao,data) ".
                        "values(".$dados["id_cliente"].",'".$dados["produto"].
                        "','".$dados["defeito"]."','".$dados["observacao"]."',now())";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_chamadas()
         {
            $strquery = "select a.id_chamada,a.id_cliente,a.produto,a.defeito,a.observacao,".
                        "a.data,b.nm_cliente,b.telefone,b.endereco,b.observacao observacao_cliente ".
                        "from chamada a,cliente b where a.id_cliente=b.id_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_chamadas_cliente($id_cliente)
         {
            $strquery = "select id_chamada,id_cliente,produto,defeito,observacao,data ".
                        "from chamada where id_cliente=$id_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function existe_chamada_cliente($id_cliente)
         {
            $strquery = "select count(*) ct from chamada where id_cliente = $id_cliente";
            $query = mysql_query($strquery,$this->bdcon);
            $lin = mysql_fetch_array($query);
            if($lin["ct"]!=0)
               $result = 1;
            mysql_free_result($query);
            return $result;
         }

         function obtem_dados_chamada($id_chamada)
         {
            $strquery = "select * from chamada where id_chamada = $id_chamada";
            $query = mysql_query($strquery,$this->bdcon);
            $linha = mysql_fetch_array($query);
            mysql_free_result($query);
            return $linha;
         }

         function altera_chamada($id_chamada,$dados)
         {
            $strquery = "update chamada set produto='".$dados["produto"]."',".
                                           "defeito='".$dados["defeito"]."',".
                                           "observacao='".$dados["observacao"]."' ".
                        "where id_chamada=$id_chamada";
            mysql_query($strquery,$this->bdcon);
         }

         function exclui_chamada($id_chamada)
         {
            $strquery = "delete from chamada where id_chamada=$id_chamada";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_novo_id_chamada() {
         // gambiarra!
            $strquery = "insert into chamada(id_cliente) values(0)";
            mysql_query($strquery,$this->bdcon);
            $id_chamada = $this->obtem_codigo_gerado();
            $this->exclui_chamada($id_chamada);
            return $id_chamada;
         }

         //==================
         //Metodos de Servico
         //==================

         function inclui_servico($dados)
         {
            $strquery = "insert into servico(id_chamada,id_cliente,produto,defeito,descricao,valor,garantia,observacao,data) ".
                        "values(".$dados["id_chamada"].",".$dados["id_cliente"].",'".$dados["produto"].
                        "','".$dados["defeito"]."','".$dados["descricao"]."',".
                        $dados["valor"].",'".$dados["garantia"]."','".$dados["observacao"]."','".$dados["data"]."')";

            mysql_query($strquery,$this->bdcon);
         }

         function altera_observacao_servico($id_servico,$observacao)
         {
            $strquery = "update servico set observacao='$observacao' where id_servico=$id_servico";
            mysql_query($strquery,$this->bdcon);
         }

         function altera_servico($dados)
         {
            $strquery = "update servico set produto='".$dados["produto"]."', ".
                                            "defeito='".$dados["defeito"]."', ".
                                            "descricao='".$dados["descricao"]."', ".
                                            "data='".$dados["data"]."', ".
                                            "valor='".$dados["valor"]."', ".
                                            "garantia='".$dados["garantia"]."', ".
                                            "observacao='".$dados["observacao"]."' ".
                                            " where id_servico=".$dados["id_servico"];
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_servicos_cliente($id_cliente)
         {
            $strquery = "select * from servico where id_cliente=$id_cliente order by data desc";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
            {
               $lin["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
               $result[] = $lin;
            }
            mysql_free_result($query);
            return $result;  
         }

         function obtem_dados_servico($id_servico)
         {
            $strquery = "select * from servico where id_servico=$id_servico";
            $query = mysql_query($strquery,$this->bdcon);
            if($linha= mysql_fetch_array($query))
               $linha["valor_pago"]=$this->obtem_valor_pago_servico($id_servico);
            mysql_free_result($query);
            return $linha;
         }

         function obtem_lista_servico($data_inicio,$data_fim)
         {
           $strquery="select a.id_cliente,a.nm_cliente,a.telefone,a.endereco,a.observacao observacao_cliente,".
                      "b.id_servico,b.id_chamada, b.produto,b.defeito,b.descricao,b.valor,b.data,b.observacao observacao_servico ".
                      "from cliente a,servico b ".
                      "where a.id_cliente=b.id_cliente and b.data between '$data_inicio' and '$data_fim' ".
                      "order by b.data desc,b.id_servico desc";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin=mysql_fetch_array($query))
            {
               $lin["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
               $result[] = $lin;
            }
            mysql_free_result($query);
            return $result;  
         }

         //================================
         //Metodos de Peca usada em Servico
         //================================

         function registra_peca_usada_servico($id_servico,$id_peca,$quantidade)
         {
            $strquery = "insert into peca_usada_servico (id_servico,id_peca,quantidade) ".
                        "values($id_servico,$id_peca,$quantidade)";
            mysql_query($strquery,$this->bdcon);
         }

         function existe_peca_usada_servico($id_peca)
         {
            $strquery = "select count(*) ct from peca_usada_servico where id_peca = $id_peca";
            $query = mysql_query($strquery,$this->bdcon);
            $lin = mysql_fetch_array($query);
            if($lin["ct"]!=0)
               $result = 1;
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_peca_usada_servico($data_inicio,$data_fim)
         {
            $strquery = "select a.id_peca,a.prefixo,a.nm_peca,a.unidade,sum(b.quantidade) quantidade ".
                        "from peca a,peca_usada_servico b,servico c ".
                        "where a.id_peca=b.id_peca and b.id_servico=c.id_servico and ".
                        "c.data between '$data_inicio' and '$data_fim' ".
                        "group by a.id_peca order by prefixo,nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin=mysql_fetch_array($query))
               $result[]=$lin;
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_peca_usada_unico_servico($id_servico)
         {
            $strquery = "select a.id_peca,a.prefixo,a.nm_peca,a.unidade,b.quantidade ".
                        "from peca a,peca_usada_servico b ".
                        "where a.id_peca=b.id_peca and b.id_servico=$id_servico ".
                        "order by prefixo,nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin=mysql_fetch_array($query))
               $result[]=$lin;
            mysql_free_result($query);
            return $result;
         }

         //================================
         //Metodos de Usuario de Peca
         //================================

         function obtem_lista_usuarios()
         {
            $strquery = "select * from usuario_peca where ativo='S' order by nm_usuario";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function inclui_usuario_peca($nm_usuario)
         {
            $strquery = "insert into usuario_peca (nm_usuario) values('$nm_usuario')";
            mysql_query($strquery,$this->bdcon);
         }

         function exclui_usuario_peca($id_usuario)
         {
            $strquery = "delete from usuario_peca where id_usuario=$id_usuario";
            mysql_query($strquery,$this->bdcon);
         }

         function desativa_usuario_peca($id_usuario)
         {
            $strquery = "update usuario_peca set ativo='N' where id_usuario=$id_usuario";
            mysql_query($strquery,$this->bdcon);
         }

         //=================================
         //Metodos de Peca usada por Usuario
         //=================================

         function registra_peca_usada_usuario($id_usuario,$id_peca,$quantidade)
         {
            $strquery = "insert into peca_usada_usuario (id_usuario,id_peca,quantidade,data) ".
                        "values($id_usuario,$id_peca,$quantidade,now())";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_peca_usada_usuario($id_usuario)
         {
            $strquery = "select a.id_peca,a.quantidade,a.data,b.prefixo,b.nm_peca,b.unidade ".
                        "from peca_usada_usuario a,peca b ".
                        "where a.id_peca=b.id_peca and a.id_usuario=$id_usuario ".
                        "order by b.prefixo,b.nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function existe_peca_usada_usuario($id_peca)
         {
            $strquery = "select count(*) ct from peca_usada_usuario where id_peca = $id_peca";
            $query = mysql_query($strquery,$this->bdcon);
            $lin = mysql_fetch_array($query);
            if($lin["ct"]!=0)
               $result = 1;
            mysql_free_result($query);
            return $result;
         }

         function exclui_peca_usada_usuario($id_usuario)
         {
            $strquery = "delete from peca_usada_usuario where id_usuario=$id_usuario";
            mysql_query($strquery,$this->bdcon);
         }

         //================================
         //Metodos de Peca usada na Oficina
         //================================

         function registra_peca_usada_oficina($id_peca,$quantidade)
         {
            $strquery = "insert into peca_usada_oficina (id_peca,quantidade,data) ".
                        "values($id_peca,$quantidade,now())";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_peca_usada_oficina($data_inicio,$data_fim)
         {
            $strquery = "select a.id_peca,a.prefixo,a.nm_peca,a.unidade,sum(b.quantidade) quantidade ".
                        "from peca a,peca_usada_oficina b ".
                        "where a.id_peca=b.id_peca and ".
                        "b.data between '$data_inicio' and '$data_fim' ".
                        "group by a.id_peca order by prefixo,nm_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin=mysql_fetch_array($query))
               $result[]=$lin;
            mysql_free_result($query);
            return $result;
         }

         //===========================
         //Metodos de Conta a Receber
         //===========================

         function inclui_conta_receber($id_servico,$data,$valor)
         {
            $strquery = "insert into conta_receber (id_servico,data,valor) ".
                        "values($id_servico,'$data',$valor)";
                        
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_proximas_contas_cliente($id_cliente)
         {
            $strquery = "select a.id_servico, a.produto, a.defeito, a.descricao, a.valor, ".
                        "b.id_conta, min(b.data) data_conta, b.valor valor_conta ".
                        "from servico a, conta_receber b ".
                        "where a.id_cliente = $id_cliente and ".
                        "a.id_servico = b.id_servico ".
                        "group by b.id_servico";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
            {
               $lin["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
               $result[] = $lin;
            }
            mysql_free_result($query);
            return $result;  
         }

         function existe_conta_receber_cliente($id_cliente)
         {
            $strquery = "select count(*) ct from servico a,conta_receber b ".
                        "where a.id_cliente = $id_cliente and a.id_servico=b.id_servico";
            $query = mysql_query($strquery,$this->bdcon);
            $lin = mysql_fetch_array($query);
            if($lin["ct"]!=0)
               $result = 1;
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_contas_receber_servico($id_servico)
         {
            $strquery = "select * from conta_receber where id_servico=$id_servico order by data";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function exclui_contas_receber_servico($id_servico)
         {
            $strquery = "delete from conta_receber where id_servico=$id_servico";
            mysql_query($strquery,$this->bdcon);
         }
         
         function exclui_conta_receber($id_conta)
         {
            $strquery = "delete from conta_receber where id_conta=$id_conta";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_cliente_conta_vencida()
         {
            $strquery="select a.id_cliente,a.nm_cliente,a.telefone,a.endereco,a.observacao obs_cliente,".
                      "b.id_servico,b.id_chamada,b.produto,b.defeito,b.descricao,b.valor valor_servico,b.data data_servico,b.observacao obs_servico,".
                      "c.id_conta,c.data data_conta,c.valor valor_conta ".
                      "from cliente a,servico b,conta_receber c ".
                      "where a.id_cliente=b.id_cliente and b.id_servico=c.id_servico and ".
                      "c.data<=now() order by a.id_cliente,b.id_servico,c.data";
            $query = mysql_query($strquery,$this->bdcon);
            $id_cli_aux=0;
            $id_serv_aux=0;
            while($lin=mysql_fetch_array($query))
            {
               if($lin["id_cliente"]!=$id_cli_aux)
               {
                  $id_cli_aux=$lin["id_cliente"];
                  $result[$lin["id_cliente"]]["nm_cliente"]=$lin["nm_cliente"];
                  $result[$lin["id_cliente"]]["telefone"]=$lin["telefone"];
                  $result[$lin["id_cliente"]]["endereco"]=$lin["endereco"];
                  $result[$lin["id_cliente"]]["observacao"]=$lin["obs_cliente"];
               }
               if($lin["id_servico"]!=$id_serv_aux)
               {
                  $id_serv_aux=$lin["id_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["id_chamada"]=$lin["id_chamada"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["produto"]=$lin["produto"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["defeito"]=$lin["defeito"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["descricao"]=$lin["descricao"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["valor"]=$lin["valor_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["data"]=$lin["data_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["observacao"]=$lin["obs_servico"];
               }
               $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["data"]=$lin["data_conta"];
               $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["valor"]=$lin["valor_conta"];
            }
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_cliente_conta_receber()
         {
            $strquery="select a.id_cliente,a.nm_cliente,a.telefone,a.endereco,a.observacao obs_cliente,".
                      "b.id_servico,b.id_chamada,b.produto,b.defeito,b.descricao,b.valor valor_servico,b.data data_servico,b.observacao obs_servico,".
                      "c.id_conta,c.data data_conta,c.valor valor_conta ".
                      "from cliente a,servico b,conta_receber c ".
                      "where a.id_cliente=b.id_cliente and b.id_servico=c.id_servico ".
                      "order by a.id_cliente,b.id_servico,c.data";
            $query = mysql_query($strquery,$this->bdcon);
            $id_cli_aux=0;
            $id_serv_aux=0;
            while($lin=mysql_fetch_array($query))
            {
               if($lin["id_cliente"]!=$id_cli_aux)
               {
                  $id_cli_aux=$lin["id_cliente"];
                  $result[$lin["id_cliente"]]["nm_cliente"]=$lin["nm_cliente"];
                  $result[$lin["id_cliente"]]["telefone"]=$lin["telefone"];
                  $result[$lin["id_cliente"]]["endereco"]=$lin["endereco"];
                  $result[$lin["id_cliente"]]["observacao"]=$lin["obs_cliente"];
               }
               if($lin["id_servico"]!=$id_serv_aux)
               {
                  $id_serv_aux=$lin["id_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["id_chamada"]=$lin["id_chamada"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["produto"]=$lin["produto"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["defeito"]=$lin["defeito"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["descricao"]=$lin["descricao"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["valor"]=$lin["valor_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["data"]=$lin["data_servico"];
                  $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["observacao"]=$lin["obs_servico"];
               }
               $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["data"]=$lin["data_conta"];
               $result[$lin["id_cliente"]]["lista_servicos"][$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["valor"]=$lin["valor_conta"];
            }
            mysql_free_result($query);
            return $result;
         }


         //=========================
         //Metodos de Conta Recebida
         //=========================

         function inclui_conta_recebida($id_servico,$data,$valor)
         {
            $strquery = "insert into conta_recebida (id_servico,data,valor) ".
                        "values($id_servico,'$data',$valor)";
            mysql_query($strquery,$this->bdcon);
         }

         function verifica_conta_recebida($id_conta)
         {
            $strquery = "update conta_recebida set verificada='v' where id_conta=$id_conta";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_valor_pago_servico($id_servico)
         {
            $strquery = "select sum(valor) soma from conta_recebida where id_servico = $id_servico";
            $query = mysql_query($strquery,$this->bdcon);
            $lin=mysql_fetch_array($query);
            $result = $lin["soma"]!=""?$lin["soma"]:0.00;
            mysql_free_result($query);
            return $result;
         }

         function obtem_lista_contas_recebidas_servico($id_servico)
         {
            $strquery = "select * from conta_recebida where id_servico=$id_servico order by data";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_servico_conta_recebida($data_inicio,$data_fim)
         {
            $strquery="select a.id_cliente,a.nm_cliente,a.telefone,a.endereco,a.observacao obs_cliente,".
                      "b.id_servico,b.id_chamada,b.produto,b.defeito,b.descricao,b.valor valor_servico,b.data data_servico,b.observacao obs_servico,".
                      "c.id_conta,c.data data_conta,c.valor valor_conta ".
                      "from cliente a,servico b,conta_recebida c ".
                      "where a.id_cliente=b.id_cliente and b.id_servico=c.id_servico and ".
                      "c.data between '$data_inicio' and '$data_fim' ".
                      "order by c.data desc,b.data desc,b.id_servico desc";
            $query = mysql_query($strquery,$this->bdcon);
            $id_serv_aux=0;
            while($lin=mysql_fetch_array($query))
            {
               if($lin["id_servico"]!=$id_serv_aux)
               {
                  $id_serv_aux=$lin["id_servico"];
                  $result[$lin["id_servico"]]["id_chamada"]=$lin["id_chamada"];
                  $result[$lin["id_servico"]]["nm_cliente"]=$lin["nm_cliente"];
                  $result[$lin["id_servico"]]["telefone"]=$lin["telefone"];
                  $result[$lin["id_servico"]]["endereco"]=$lin["endereco"];
                  $result[$lin["id_servico"]]["observacao_cliente"]=$lin["obs_cliente"];
                  $result[$lin["id_servico"]]["produto"]=$lin["produto"];
                  $result[$lin["id_servico"]]["defeito"]=$lin["defeito"];
                  $result[$lin["id_servico"]]["descricao"]=$lin["descricao"];
                  $result[$lin["id_servico"]]["valor"]=$lin["valor_servico"];
                  $result[$lin["id_servico"]]["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
                  $result[$lin["id_servico"]]["data"]=$lin["data_servico"];
                  $result[$lin["id_servico"]]["observacao_servico"]=$lin["obs_servico"];
               }
               $result[$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["data"]=$lin["data_conta"];
               $result[$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["valor"]=$lin["valor_conta"];
            }
            mysql_free_result($query);
            return $result;
         }

	function obtem_lista_conta_recebida_nao_verificada()
         {
            $strquery="select a.id_cliente,a.nm_cliente,a.telefone,a.endereco,a.observacao obs_cliente,".
                      "b.id_servico,b.produto,b.defeito,b.descricao,b.valor valor_servico,b.data data_servico,b.observacao obs_servico,".
                      "c.id_conta,c.data data_conta,c.valor valor_conta ".
                      "from cliente a,servico b,conta_recebida c ".
                      "where a.id_cliente=b.id_cliente and b.id_servico=c.id_servico and ".
                      "c.verificada='n' ".
                      "order by b.data desc,b.id_servico desc,c.data desc";
            $query = mysql_query($strquery,$this->bdcon);
            $id_serv_aux=0;
            while($lin=mysql_fetch_array($query))
            {
               if($lin["id_servico"]!=$id_serv_aux)
               {
                  $id_serv_aux=$lin["id_servico"];
                  $result[$lin["id_servico"]]["nm_cliente"]=$lin["nm_cliente"];
                  $result[$lin["id_servico"]]["telefone"]=$lin["telefone"];
                  $result[$lin["id_servico"]]["endereco"]=$lin["endereco"];
                  $result[$lin["id_servico"]]["observacao_cliente"]=$lin["obs_cliente"];
                  $result[$lin["id_servico"]]["produto"]=$lin["produto"];
                  $result[$lin["id_servico"]]["defeito"]=$lin["defeito"];
                  $result[$lin["id_servico"]]["descricao"]=$lin["descricao"];
                  $result[$lin["id_servico"]]["valor"]=$lin["valor_servico"];
                  $result[$lin["id_servico"]]["valor_pago"]=$this->obtem_valor_pago_servico($lin["id_servico"]);
                  $result[$lin["id_servico"]]["data"]=$lin["data_servico"];
                  $result[$lin["id_servico"]]["observacao_servico"]=$lin["obs_servico"];
               }
               $result[$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["data"]=$lin["data_conta"];
               $result[$lin["id_servico"]]["lista_contas"][$lin["id_conta"]]["valor"]=$lin["valor_conta"];
            }
            mysql_free_result($query);
            return $result;
         }



         //==================
         //Metodos de Veiculo
         //==================

         function obtem_lista_veiculo()
         {
            $strquery = "select * from veiculo";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function inclui_veiculo($descricao)
         {
            $strquery = "insert into veiculo (descricao) values ('$descricao')";
            mysql_query($strquery,$this->bdcon);
         }
         
         function exclui_veiculo($id_veiculo)
         {
            $strquery = "delete from veiculo where id_veiculo=$id_veiculo";
            mysql_query($strquery,$this->bdcon);
         }

         //================================
         //Metodos de Peca de Veiculo Usada
         //================================

         function registra_peca_usada_veiculo($id_veiculo,$id_peca,$quantidade,$data)
         {
            $strquery = "insert into peca_usada_veiculo (id_veiculo,id_peca,quantidade,data) ".
                        "values($id_veiculo,$id_peca,$quantidade,'$data')";
            mysql_query($strquery,$this->bdcon);
         }

         function exclui_peca_usada_veiculo($id_uso)
         {
            $strquery = "delete from peca_usada_veiculo where id_uso=$id_uso";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_lista_peca_usada_veiculo($id_veiculo)
         {
            $strquery = "select a.id_uso,a.id_peca,a.id_veiculo,a.quantidade,a.data,".
                        "b.prefixo,b.nm_peca,b.unidade,b.endereco ".
                        "from peca_usada_veiculo a, peca b where ".
                        "a.id_veiculo=$id_veiculo and a.id_peca=b.id_peca";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         //==================
         //Metodos de Usuario
         //==================
 
         function confirmar_login($nm_usuario,$senha)
         {
            $strquery = "select * from usuario where nm_usuario='$nm_usuario' and senha=password('$senha')";
            $query = mysql_query($strquery,$this->bdcon);
            if($lin=mysql_fetch_array($query))
               $result=1;
            mysql_free_result($query);
            return $result;
         }

         function altera_senha_usuario($nm_usuario,$senha)
         {
            $strquery = "update usuario set senha=password('$senha') where nm_usuario='$nm_usuario'";
            mysql_query($strquery,$this->bdcon);
         }

         //=====================
         //Metodos de Fornecedor
         //=====================
 
         function obtem_lista_fornecedor()
         {
            $strquery = "select * from fornecedor order by nm_fornecedor";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_fornecedor_nome($nome)
         {
            $strquery = "select * from fornecedor where nm_fornecedor like '%".$nome."%' order by nm_fornecedor";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }

         function obtem_lista_fornecedor_telefone($telefone)
         {
            $strquery = "select * from fornecedor where telefone like '%".$telefone."%' order by nm_fornecedor";
            $query = mysql_query($strquery,$this->bdcon);
            while($lin = mysql_fetch_array($query))
               $result[] = $lin;
            mysql_free_result($query);
            return $result;  
         }


         function inclui_fornecedor($dados)
         {
            $strquery = "insert into fornecedor (nm_fornecedor,endereco,nm_contato,telefone) ".
                        "values ('".$dados["nm_fornecedor"]."','".$dados["endereco"].
                        "','".$dados["nm_contato"]."','".$dados["telefone"]."')";
            mysql_query($strquery,$this->bdcon);
         }
         
         function altera_fornecedor($id_fornecedor,$dados)
         {
            $strquery = "update fornecedor set nm_fornecedor='".$dados["nm_fornecedor"]."',".
                                           "endereco='".$dados["endereco"]."',".
                                           "nm_contato='".$dados["nm_contato"]."',".
                                           "telefone='".$dados["telefone"]."' ".
                        "where id_fornecedor=$id_fornecedor";
            mysql_query($strquery,$this->bdcon);
         }

         function obtem_dados_fornecedor($id_fornecedor)
         {
            $strquery = "select * from fornecedor where id_fornecedor = $id_fornecedor";
            $query = mysql_query($strquery,$this->bdcon);
            $linha = mysql_fetch_array($query);
            mysql_free_result($query);
            return $linha;
         }

         function exclui_fornecedor($id_fornecedor)
         {
            $strquery = "delete from fornecedor where id_fornecedor=$id_fornecedor";
            mysql_query($strquery,$this->bdcon);
         }

         

      }
   }
   
   ##echo "Debuging: ACSBD: Getting out...";
?>
