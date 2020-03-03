<?php
    $first=array("Tom", "Dick", "Harry");
    $second=array("a" => "Conor", 4 => "Aidan", "Sheraz" => "Anjum");
    
	echo $first[1]." ".$second[2]."<br>";// only print Dick
	echo $first[1]." ".$second[a]."<br>";// Prints Dick Conor
	echo $first[1]." ".$second["a"]."<br>";// only print Dick Conor
	echo $first[1]." ".$second['a']."<br>";// only print Dick Conor
?>