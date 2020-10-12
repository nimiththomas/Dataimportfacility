<?php
function addproductsdb($data,$position,$tproductid,$valstatus,$tname,$tcost){
 
require 'api/db_connect.php';
if($colname==1){
       for($j=1;$j<sizeof($data);$j++){
           if($tproductid[$j]==1){
                   $productid[$j]=$data[$j][$position[0]];
                 
              
              if( $valstatus[$j]==1){
                     $status[$j]=$data[$j][$position[3]];
                     
              }
              else{
                     trigger_error("status is wrong format",E_USER_WARNING);
                     continue;
              }
              if($tname[$j]==1 and $data[$j][$position[1]]!=""){
                     $name[$j]=$data[$j][$position[1]];
                    
                     
              }
              else{
                 trigger_error("name is not in string format",E_USER_WARNING);
                 continue;
              }
               if($tcost[$j]==1){
                     $cost[$j]=$data[$j][$position[2]];
                    
                     
                     
              }
              else{
                 trigger_error("cost is of wrong format",E_USER_WARNING);
                 continue;
              }
              
               if($data[$j][$position[4]]==""){
                     trigger_error("Date is of wrong format",E_USER_WARNING);
                     continue;        
              }
              else{
                 $time_added[$j]=date("Y-m-d h:m:s",$data[$j][$position[4]]);

              }
             
              
              }
           else{
              trigger_error("product id is null",E_USER_WARNING);
              continue;
         
              
           }
              $sql5= "INSERT INTO csv_products (productid, name, cost, status, date_added) VALUES (:productid, :name, :cost, :status, :date_added)";
              $stmt2 = $dbh->prepare($sql5);
              $stmt2->bindParam(':productid', $productid[$j]);
              $stmt2->bindParam(':name', $name[$j]);
              $stmt2->bindParam(':cost', $cost[$j]);
              $stmt2->bindParam(':status', $status[$j]);
              $stmt2->bindParam(':date_added', $time_added[$j]); 
              $stmt2->execute();
 
             
           
       }
       
       }
       else{
              for($j=0;$j<sizeof($data);$j++){
           if($tproductid[$j]==1){
                   $productid=$data[$j][$position[0]];
              
              if( $valstatus[$j]==1){
                     $status=$data[$j][$position[3]];
              }
              else{
                     trigger_error("status is wrong format",E_USER_WARNING);
                     continue;
              }
              if($tname[$j]==1){
                     $name=$data[$j][$position[1]];
                     
              }
              else{
                 trigger_error("name is not in string format",E_USER_WARNING);
                 continue;
              }
               if($tcost[$j]==1){
                     $cost=$data[$j][$position[2]];
                     
              }
              else{
                 trigger_error("cost is of wrong format",E_USER_WARNING);
                 continue;
              }
              
               if($data[$j][$position[4]]==""){
                     trigger_error("Date is of wrong format",E_USER_WARNING);
                     continue;        
              }
              else{
                 $time_added[$j]=$data[$j][$position[4]];
              }
             
              
              }
           else{
              trigger_error("product id is null",E_USER_WARNING);
              continue;
         
              
           }
       }
         $sql5= "INSERT INTO csv_products (productid, name, cost, status, date_added) VALUES (:productid, :name, :cost, :status, :date_added)";
              $stmt2 = $dbh->prepare($sql5);
              $stmt2->bindParam(':productid', $productid[$j]);
              $stmt2->bindParam(':name', $name[$j]);
              $stmt2->bindParam(':cost', $cost[$j]);
              $stmt2->bindParam(':status', $status[$j]);
              $stmt2->bindParam(':date_added', $time_added[$j]); 
              $stmt2->execute();
 
            
              
              
       }
       echo("</br>");
       $res="Succesfully Added to Database";
       echo($res);
}

?>