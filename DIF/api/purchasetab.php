<?php
function purchasetab($data){
       require 'api/myerrorhandler.php';
       require 'api/db_connect.php';
       $old_error_handler = set_error_handler("myErrorHandler");
       $purchasesarr=array("username","productid","quantity","time_placed");
       $count=0;
       $position=array();
       for($i=0;$i<4;$i++){
        if(in_array($purchasesarr[$i],$data[0])){
            $count=$count+1;
            $s=array_search($purchasesarr[$i],$data[0],true);
            array_push($position,$s);
        }
       }
       if($count==4){
        $colname=1;
         
       }
       else{
        $colname=0;
        
       }
       
        //checking data type and storing result
        if($colname==1){
        for($j=1;$j<sizeof($data);$j++){
				
                                   $tusername[$j]=is_string($data[$j][$position[0]]);
                                   $tproductid[$j]=is_numeric($data[$j][$position[1]]);
                                   $tquantity[$j]=is_numeric($data[$j][$position[2]]);
                                   
                                                                     
              }
       }
       else{
              for($j=0;$j<sizeof($data);$j++){
                                   $tusername[$j]=is_string($data[$j][0]);
                                   $tproductid[$j]=is_numeric($data[$j][1]);
                                   $tquantity[$j]=is_numeric($data[$j][2]);         
              }
              
       }
       
       //adding to database
       
        
        if($colname==1){
       for($j=1;$j<sizeof($data);$j++){
           if($tusername[$j]==1 and $tusername[$j]!="") {
                   $username[$j]=strtolower($data[$j][$position[0]]);
                 
              
              if( $tproductid[$j]==1 ){
                     $productid[$j]=$data[$j][$position[1]];
                     
              }
              else{
                     trigger_error("Productid is of wrong format",E_USER_WARNING);
                     continue;
              }
             
              
               if($tquantity[$j]==1){
                     $quantity[$j]=$data[$j][$position[2]];
                        
                     
              }
              else{
                 trigger_error("quantity is of wrong format",E_USER_WARNING);
                 continue;
              }
              
               if($data[$j][$position[3]]==""){
                     trigger_error("Time placed is of wrong format",E_USER_WARNING);
                     continue;        
              }
              else{
                 $time_placed[$j]=date("Y-m-d h:m:s",$data[$j][$position[3]]);

              }
       }
              
           else{
              trigger_error("Username is of wrong format",E_USER_WARNING);
              continue;
         
              
           }
           
              $sql="SELECT * FROM csv_users WHERE username=:username";
  
              $stmt = $dbh->prepare($sql);
              $stmt->bindParam(':username', $username[$j]);
              $stmt->execute();
 
              $result = $stmt->fetch();
              if (isset($result['username'])) {
                   $userid[$j]=$result['userid'];
              //
               }
               else{
                      $sql5= "INSERT INTO csv_users (username) VALUES (:username)";
                     $stmt2 = $dbh->prepare($sql5);
                     $stmt2->bindParam(':username', $username[$j]);
                     $stmt2->execute();
                     
                     $sql7="SELECT * FROM csv_users WHERE username=:username";
  
                      $stmt2 = $dbh->prepare($sql7);
                     $stmt2->bindParam(':username', $username[$j]);
                     $stmt2->execute();
 
                     $result2 = $stmt2->fetch();
                      $userid[$j]=$result2['userid'];
                     
               }
              $status="completed";
              $sql5= "INSERT INTO csv_sales (userid, productid, quantity, status, time_placed) VALUES (:userid, :productid, :quantity, :status, :time_placed)";
              $stmt2 = $dbh->prepare($sql5);
               $stmt2->bindParam(':userid', $userid[$j]);
              $stmt2->bindParam(':productid', $productid[$j]);
              $stmt2->bindParam(':quantity', $quantity[$j]);
              $stmt2->bindParam(':time_placed', $time_placed[$j]);
              $stmt2->bindParam(':status', $status);
              $stmt2->execute();
 
             
           
       }
    
       }
       else{
            for($j=0;$j<sizeof($data);$j++){
           if($tusername[$j]==1 and $tusername[$j]!="") {
                   $username[$j]=strtolower($data[$j][0]);
                 
              
              if( $tproductid[$j]==1 ){
                     $productid[$j]=$data[$j][1];
                     
              }
              else{
                     trigger_error("Productid is of wrong format",E_USER_WARNING);
                     continue;
              }
             
              
               if($tquantity[$j]==1){
                     $quantity[$j]=$data[$j][2];
                        
                     
              }
              else{
                 trigger_error("quantity is of wrong format",E_USER_WARNING);
                 continue;
              }
              
               if($data[$j][3]==""){
                     trigger_error("Time placed is of wrong format",E_USER_WARNING);
                     continue;        
              }
              else{
                 $time_placed[$j]=date("Y-m-d h:m:s",$data[$j][3]);

              }
             
            }
              
           else{
              trigger_error("Username is of wrong format",E_USER_WARNING);
              continue;
         
              
           }
           
              $sql="SELECT * FROM csv_users WHERE username=:username";
  
              $stmt = $dbh->prepare($sql);
              $stmt->bindParam(':username', $username[$j]);
              $stmt->execute();
 
              $result = $stmt->fetch();
              if (isset($result['username'])) {
                     $userid[$j]=$result['userid'];
              
               }
               else{
                      $sql5= "INSERT INTO csv_users (username) VALUES (:username)";
                     $stmt2 = $dbh->prepare($sql5);
                     $stmt2->bindParam(':username', $username[$j]);
                     $stmt2->execute();
                     
                     $sql7="SELECT * FROM csv_users WHERE username=:username";
  
                      $stmt2 = $dbh->prepare($sql7);
                     $stmt2->bindParam(':username', $username[$j]);
                     $stmt2->execute();
 
                     $result2 = $stmt2->fetch();
                      $userid[$j]=$result2['userid'];
                     
               }
              $status="completed";
              $sql5= "INSERT INTO csv_sales (userid, productid, quantity, status, time_placed) VALUES (:userid, :productid, :quantity, :status, :time_placed)";
              $stmt2 = $dbh->prepare($sql5);
               $stmt2->bindParam(':userid', $userid[$j]);
              $stmt2->bindParam(':productid', $productid[$j]);
              $stmt2->bindParam(':quantity', $quantity[$j]);
              $stmt2->bindParam(':time_placed', $time_placed[$j]);
              $stmt2->bindParam(':status', $status);
              $stmt2->execute();
 
 
             
           
       }
    
       }
       echo("<br/>");
       try{
       $errors=file_get_contents("upload/error_log.txt");
       
        $productidcount=substr_count($errors,"Warning : Productid is of wrong format");
        if($productidcount!=0){
            echo "<h3>"."Warning : Productid is of wrong format"." occured ".$productidcount." times"."<h3/>";
            echo("</br>");
        }
        
         $datecount=substr_count($errors,"Warning : Time placed is of wrong format");
        if($datecount!=0){
            echo "<h3>"."Warning : Time placed is of wrong format"." occured ".$datecount." times"."<h3/>";
             echo("</br>");
        }
        
        $usernamecount=substr_count($errors,"Warning : Username is of wrong format");
        
        if($usernamecount!=0){
            echo "<h3>"."Warning : Username is of wrong format"." occured ".$usernamecount." times"."<h3>";
        }
        
        
        
        $quantitycount=substr_count($errors,"Warning : quantity is of wrong format");
        if($quantitycount!=0){
            echo "<h3>"."Warning : Quantity is of wrong format"." occured ".$namescount." times"."<h3/>";
             echo("</br>");
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