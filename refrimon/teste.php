<?php
   print "Hi <br>"; 
   print "Post: " . $_POST . "<br>";
   print "value: ". $_POST['bx_name'] . "<br>";

?>
<?php
 print_r($_GET);
 if($_GET["bx_name"] === "") echo "a is an empty string\n";
 if($_GET["bx_name"] === false) echo "a is false\n";
 if($_GET["bx_name"] === null) echo "a is null\n";
 if(isset($_GET["bx_name"])) echo "a is set\n";
 if(!empty($_GET["bx_name"])) echo "a is not empty";
?>
<?php
 print_r($_POST);
 if($_POST["bx_name"] === "") echo "a is an empty string\n";
 if($_POST["bx_name"] === false) echo "a is false\n";
 if($_POST["bx_name"] === null) echo "a is null\n";
 if(isset($_POST["bx_name"])) echo "a is set\n";
 if(!empty($_POST["bx_name"])) echo "a is not empty";


 phpinfo();
?>
