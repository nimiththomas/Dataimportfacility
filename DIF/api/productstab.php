<?php
function productstab($data){
       require 'api/myerrorhandler.php';
       require 'api/db_connect.php';
       $old_error_handler = set_error_handler("myErrorHandler");
       $productsarr=array("productid","name","cost","status","date_added");
       $count=0;
       $position=array();
       for($i=0;$i<5;$i++){
        if(in_array($productsarr[$i],$data[0])){
            $count=$count+1;
            $s=array_search($productsarr[$i],$data[0],true);
              array_push($position,$s);
        }
       }
         
         echo("</br>");
       if($count==5){
        $colname=1;
      
       }
       else{
        $colname=0;
        
       }
      
     
       //checking data type and storing result
       if($colname==1){
        for($j=1;$j<sizeof($data);$j++){
				
                                   $tproductid[$j]=is_numeric($data[$j][$position[0]]);
                                   $tstatus[$j]=is_numeric($data[$j][$position[3]]);
                                   $tcost[$j]=is_numeric($data[$j][$position[2]]);
                                   
                                   $tname[$j]=is_numeric($data[$j][$position[1]]);
                          
                                  
                                  
                                  
                                   
                                   
              }
       }
       else{
              for($j=0;$j<sizeof($data);$j++){
				
                                   $tproductid[$j]=is_numeric($data[$j][0]);
                                   $tstatus[$j]=is_numeric($data[$j][3]);
                                   $tcost[$j]=is_numeric($data[$j][2]);
                                  
                                   $tname[$j]=is_numeric($data[$j][1]);
                                  
                                   
              }
            
              
       }

         
         //checking status for other values than 0 and 1
       if($colname==1){
        for($j=1;$j<sizeof($data);$j++){
              if($data[$j][$position[3]]!=""){
              if($data[$j][$position[3]]==0 or $data[$j][$position[3]]==1){
                       $valstatus[$j]=1;
                     
              }
              }
              else{
                    $valstatus[$j]=0;
                    
              }
              }
       }
       else{
               for($j=0;$j<sizeof($data);$j++){
              if($data[$j][3]!=""){
              if($data[$j][3]==0 or $data[$j][3]==1){
                       $valstatus[$j]=1;
                     
              }
              }
              else{
                    $valstatus[$j]=0;
                    
              }
              
       }
            
       }

       //entering data into database
      
       
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
              if($tname[$j]!=1 and $data[$j][$position[1]]!=""){
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
                   $productid[$j]=$data[$j][0];
              
              if( $valstatus[$j]==1){
                     $status[$j]=$data[$j][3];
              }
              else{
                     trigger_error("status is wrong format",E_USER_WARNING);
                     continue;
              }
              if($tname[$j]!=1 and $data[$j][1]!=""){
                     $name[$j]=$data[$j][1];
                           
              }
              else{
                 trigger_error("name is not in string format",E_USER_WARNING);
                 continue;
              }
               if($tcost[$j]==1){
                     $cost[$j]=$data[$j][2];
                     
              }
              else{
                 trigger_error("cost is of wrong format",E_USER_WARNING);
                 continue;
              }
              
               if($data[$j][4]==""){
                     trigger_error("Date is of wrong format",E_USER_WARNING);
                     continue;        
              }
              else{
                 $time_added[$j]=date("Y-m-d h:m:s",$data[$j][4]);
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
       echo("<br/>");
       try{
       $errors=file_get_contents("upload/error_log.txt");
      
        $productidcount=substr_count($errors,"Warning : product id is null");
        if($productidcount!=0){
            echo "<h3>"."Warning : Product id is null"." occured ".$productidcount." times"."<h3/>";
            echo("</br>");
        }
        
         $datecount=substr_count($errors,"Warning : Date is of wrong format");
        if($datecount!=0){
            echo "<h3>"."Warning : Date is of wrong format"." occured ".$datecount." times"."<h3/>";
             echo("</br>");
        }
        
        $statuscount=substr_count($errors,"Warning : status is wrong format");
        if($statuscount!=0){
            echo "<h3>"."Warning : Status is wrong format"." occured ".$statuscount." times"."<h3/>";
             echo("</br>");
        }
        
        
        
        $namescount=substr_count($errors,"Warning : name is not in string format");
        if($namescount!=0){
            echo "<h3>"."Warning : Name is not in string format"." occured ".$namescount." times"."<h3/>";
             echo("</br>");
        }
        
       $costcount=substr_count($errors,"Warning : cost is of wrong format");
        if($costcount!=0){
            echo "<h3>"."Warning : Cost is of wrong format"." occured ".$costcount." times"."<h3>";
        }
       
       }
      catch(Exception $e) {
       
        }
         unlink("upload/error_log.txt");
       echo("</br>");
       $res="Succesfully Added to Database";
       echo($res);
           
      
       
}

       
 

?>