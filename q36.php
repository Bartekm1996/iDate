<?php

  if( $_POST["name"] || $_POST["age"] ) {
 if($_COOKIE["name"] != ""){
	 print "<b>Welcome back!</b> {$_COOKIE["name"]}";
 } else { 
	 print "Hello " . $_POST["name"];
	 setcookie("name", $_POST["name"], time() -1);
 }
  }
?>

<html>
   <body>
   
      <form action = "<?php $_PHP_SELF ?>" method = "POST">
         Name: <input type = "text" name = "name" />
         Age: <input type = "text" name = "age" />
         <input type = "submit" />
      </form>
      
   </body>
</html>