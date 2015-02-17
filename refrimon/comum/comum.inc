<?php
   if(!defined("COMUM_LIB"))
   {
      define("COMUM_LIB","ON");

      $cor_fundo_navegacao="#6774AD";//"#000080";//"#A0C0D0";
      $cor_fundo_principal="#F9F9F0";//"#FFFFF0";//"#F0F0FF";
      $cor_funco_inpressao="#FFFFFF";
      $unidade_monetaria = "R$";

      function formata_data_hora($str_data_hora)
      {
         ereg("([0-9]*)\-([0-9]*)\-([0-9]*) ([0-9]*):([0-9]*):([0-9]*)",$str_data_hora,$campos);
         $result = $campos[3]."/".$campos[2]."/".$campos[1]." ".$campos[4].":".$campos[5].":".$campos[6];
         return $result;
      }

      function formata_data_h($str_data_hora)
      {
         ereg("([0-9]*)\-([0-9]*)\-([0-9]*) ([0-9]*):([0-9]*):([0-9]*)",$str_data_hora,$campos);
         $result = $campos[3]."/".$campos[2]."/".$campos[1];
         return $result;
      }


      function obtem_data()
      {
         $data = getdate();
         $str_data = $data["mday"]."/".$data["mon"]."/".$data["year"];
         return $str_data;
      }

      function formata_data_mysql($data_padrao)
      {
         if(ereg("^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$",$data_padrao,$campos)&&(checkdate($campos[2],$campos[1],$campos[3])))
            return $campos[3]."-".$campos[2]."-".$campos[1];
      }

      function formata_data_padrao($data_mysql)
      {
         if(ereg("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$",$data_mysql,$campos))
            return $campos[3]."/".$campos[2]."/".$campos[1];
      }

      function formata_decimal_mysql($decimal_padrao)
      {
         if(ereg("^([0-9]+)([,.]{1}([0-9]{1,}))?$",$decimal_padrao,$campos))
         {
            $dec = $campos[1]; 
            if($campos[3]=="")
               $campos[3]="00";
            $dec=$dec.".".$campos[3];
            return $dec;
         }
         elseif($decimal_padrao=="")
            return "0.00";
      }

      function formata_decimal_padrao($decimal_mysql)
      {
         if(ereg("^([0-9]+)(.([0-9]+))?$",$decimal_mysql,$campos))
         {
            $campos[3]=$campos[3]."";
            while(strlen($campos[3])<2)
               $campos[3]=$campos[3]."0";
            return $campos[1].".".$campos[3];
         }
         elseif($decimal_padrao=="")
            return "0.00";
      }

      function zerosEsquerda($num, $tam)
      {
        while(strlen($num)<$tam)
          $num="0".$num;
        return $num;
      }

      function gerar_parametro_GET($nome,$valor) {
//        if(!isarray($valor))
          return "$nome=$valor";
//        else {
//          $resultado = "";
//          while(list($indice,$subvalor)=each($valor)) {
//            if($resultado!="") $resultado .= "&";
//            $resultado .= gerar_parametro_GET($nome."[$indice]",$subvalor);
//          }
//          return $resultado;
//        }
      } 



## ######################################################################################################



function http_request_input($var)
{
        print "vinnix was here.. ";
        $debug = false;
        print "vinnix was here.. ";

        if ($debug)
        {

                if (isset($_POST[$var])) echo "a is set\n";
                if (!empty($_POST[$var])) echo "a is not empty";
                if ($_POST[$var] === "") echo "a is an empty string\n";
                if ($_POST[$var] === false) echo "a is false\n";
                if ($_POST[$var] === null) echo "a is null\n";
        }

        #if (!isset($_POST[$var]) || empty($_POST[$var]) || ($_POST[$var] === "" || $_POST[$var] === false || $_POST[$var] === null )
	#$return_aux =  false;
        #else if (!isset($_GET[$var]) || empty($_GET[$var]) || ($_GET[$var] === "" || $_GET[$var] === false || $_GET[$var] === null )
        #        $return_aux = false;

        print "vinnix was here.. ";
        if (isset($_POST[$var]))
                $return_aux =  $_POST[$var];
        else if (isset($GET[$var]))
                $return_aux = $_GET[$var];


	return $return_aux;
}

## ######################################################################################################


    }
?>
