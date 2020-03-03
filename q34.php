<?php
   if( $_POST["name"] || $_POST["age"] ) {
      echo "Welcome ". $_POST['name']. "<br />";
      echo "You are ". $_POST['age']. " years old.";
	  echo "<br>";
   echo "{$_POST['name']}<br>";
	  echo "{$_POST[name]}<br>";
	  echo "{$_POST["name"]}<br>";
	  print_r($_REQUEST);
      exit();
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