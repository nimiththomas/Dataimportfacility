<?php
    function usertab($data){
        require 'api/myerrorhandler.php';
        require 'api/db_connect.php';
        $old_error_handler = set_error_handler("myErrorHandler");
       $usersarr=array("username","password","email","name");
       $count=0;
       $position=array();
       for($i=0;$i<4;$i++){
        if(in_array($usersarr[$i],$data[0])){
            $count=$count+1;
            $s=array_search($usersarr[$i],$data[0],true);
            array_push($position,$s);
        }
       }
       //type change
       if($count==4){
         $colname=1;
         
       }
       else{
        $colname=0;
      
       }
       //checking data type and storing result
        if($colname==1){
        for($j=1;$j<sizeof($data);$j++){
				
                                   $tusername[$j]=is_numeric($data[$j][$position[0]]);
                                   $tpassword[$j]=is_numeric($data[$j][$position[1]]);
                                   $temail[$j]=is_numeric($data[$j][$position[2]]);
                                   $tname[$j]=is_numeric($data[$j][$position[3]]);
                                                                     
              }
       }
       else{
              for($j=0;$j<sizeof($data);$j++){
                                   $tusername[$j]=is_numeric($data[$j][0]);
                                   $tpassword[$j]=is_numeric($data[$j][1]);
                                   $temail[$j]=is_numeric($data[$j][2]);
                                   $tname[$j]=is_numeric($data[$j][3]);
				                                                                   
              }
              
       }
       //checking validity of email address
       if($colname==1){
        for($j=1;$j<sizeof($data);$j++){
          if (filter_var($data[$j][$position[2]], FILTER_VALIDATE_EMAIL)) {
                 $vemail[$j]=1;
            } else {
               $vemail[$j]=0;
            }
        }
       }
        else{
            for($j=0;$j<sizeof($data);$j++){
            if (filter_var($data[$j][2], FILTER_VALIDATE_EMAIL)) {
                 $vemail[$j]=1;
            } else {
               $vemail[$j]=0;
            }
        }
        }
         //entering data into database
          
          if($colname==1){
            for($j=1;$j<sizeof($data);$j++){
            if($tusername[$j]!=1 and $data[$j][$position[0]]!=""){
                   $username[$j]=strtolower($data[$j][$position[0]]);
            }
            else{
              trigger_error("username is of wrong format",E_USER_WARNING);
              continue;
              }
                  
              if( $tpassword[$j]!=1 and $data[$j][$position[1]]!="" ){
                     $tpassword[$j]=$data[$j][$position[1]];
                     
              }
              else{
                     trigger_error("password is wrong format",E_USER_WARNING);
                     continue;
              }
              if($tname[$j]!=1 and $data[$j][$position[3]]!=""){
                     $name[$j]=$data[$j][$position[3]];
                    
              }
              else{
                 trigger_error("name is not in string format",E_USER_WARNING);
                 continue;
              }
               if($vemail[$j]==1 and $data[$j][$position[2]]!=""){
                     $email[$j]=$data[$j][$position[2]];
                          
              }
              else{
                 trigger_error("email is of wrong format",E_USER_WARNING);
                 continue;
              }
              
              
              
          
              $sql5= "INSERT INTO csv_users (username, password, email, name) VALUES (:username, :password, :email, :name)";
              $stmt2 = $dbh->prepare($sql5);
              $stmt2->bindParam(':username', $username[$j]);
              $stmt2->bindParam(':password', $tpassword[$j]);
              $stmt2->bindParam(':email', $email[$j]);
              $stmt2->bindParam(':name', $name[$j]);
              $stmt2->execute();
         
       }
       
       }
       else{
              for($j=0;$j<sizeof($data);$j++){
            if($tusername[$j]!=1 and $data[$j][0]!=""){
                   $username[$j]=strtolower($data[$j][0]);
            }
            else{
              trigger_error("username is of wrong format",E_USER_WARNING);
              continue;
              }
                  
              if( $tpassword[$j]!=1 and $data[$j][1]!="" ){
                     $tpassword[$j]=$data[$j][1];
                     
              }
              else{
                     trigger_error("password is wrong format",E_USER_WARNING);
                     continue;
              }
              if($tname[$j]!=1 and $data[$j][3]!=""){
                     $name[$j]=$data[$j][3];
                    
              }
              else{
                 trigger_error("name is not in string format",E_USER_WARNING);
                 continue;
              }
               if($vemail[$j]==1 and $data[$j][2]!=""){
                     $email[$j]=$data[$j][2];
                          
              }
              else{
                 trigger_error("email is of wrong format",E_USER_WARNING);
                 continue;
              }
              
              
              
          
             $sql5= "INSERT INTO csv_users (username, password, email, name) VALUES (:username, :password, :email, :name)";
              $stmt2 = $dbh->prepare($sql5);
              $stmt2->bindParam(':username', $username[$j]);
              $stmt2->bindParam(':password', $tpassword[$j]);
              $stmt2->bindParam(':email', $email[$j]);
              $stmt2->bindParam(':name', $name[$j]);
              $stmt2->execute();
 
             
           
       }
              
        
       }
       echo("</br>");
      
       try{
       $errors=file_get_contents("upload/error_log.txt");
       
        $datecount=substr_count($errors,"Warning : Date is of wrong format");
        if($datecount!=0){
            echo "<h3>"."Warning : Date is of wrong format"." occured ".$datecount." times"."<h3>";
            
        }
        
         $emailcount=substr_count($errors,"Warning : email is of wrong format");
        if($emailcount!=0){
            echo "<h3>"."Warning : Email is of wrong format"." occured ".$emailcount." times"."<h3>";
        }
        
        $passwordcount=substr_count($errors,"Warning : password is wrong format");
        if($passwordcount!=0){
            echo "<h3>"."Warning : Status is wrong format"." occured ".$passwordcount." times"."<h3>";
        }
        
        $usernamecount=substr_count($errors,"Warning : username is of wrong format");
        if($usernamecount!=0){
            echo "<h3>"."Warning : Username is of wrong format"." occured ".$usernamecount." times"."<h3>";
        }
        
        $namescount=substr_count($errors,"Warning : name is not in string format");
        if($namescount!=0){
            echo "<h3>"."Warning : Name is not in string format"." occured ".$namescount." times"."<h3>";
        }
       
       }
      catch(Exception $e) {

        }
       unlink("api/error_log.txt");
       echo("</br>");
       $res="Succesfully Added to Database";
       echo($res);
        
            
        }
     
    
     
       
      
 
    
	

?>
