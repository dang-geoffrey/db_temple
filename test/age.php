<?php
         $birthdate= $_POST['birthdate'];
		 
		 $age = date_diff(date_create($birthdate), date_create('now'))->y;  
echo $age;
    ?>