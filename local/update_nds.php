<?php 
   $host = 'localhost'; 
   $db_name = 'gipermum_new_roz'; 
   $user = 'gipermum_new_roz'; 
   $password = 'WwF&Wj3M'; 
   
      $connection = mysqli_connect($host, $user, $password, $db_name);
      $query = 'UPDATE `b_catalog_product` SET `VAT_INCLUDED` = "Y" , `vat_id` = "5"';   
      $result = mysqli_query($connection, $query);  
      mysqli_close($connection);
?>