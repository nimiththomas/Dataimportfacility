<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>DIF</title>
</head>

<body>
<center>
<table width="600">
<form action="" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select File</td>
<td width="80%"><input type="file" name="file" id="file" accept=".csv" /></td>
</tr>
<tr>
<td width="20%">Select Format of csv file being uploaded</td>
<td width="80%"> <select name="format">
            <option value="users">users</option>
            <option value="purchases">purchases</option>
            <option value="products">products</option>
           
        </select>
</td>
</tr>

<tr>
<td width="20%">Select Delimiter</td>
<td width="80%"> <select name="delimiter">
            <option value=",">comma (,)</option>
            <option value="\t">tab (\t)</option>
												<option value="|">pipe (|)</option>
												<option value=" ">space</option>
												<option value=":">colon</option>
												<option value=";">semicolon</option>
												
			
        </select>
</td>
</tr>


<tr>
<td>Submit</td>
<td><input type="submit" name="submit" /></td>
</tr>

</form>


</table>
<?php
if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {
	$name=$_FILES["file"]['name'];
	$delim=strval($_REQUEST['delimiter']);
	$format=strval($_REQUEST['format']);

	
   $ext=pathinfo($name, PATHINFO_EXTENSION);

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
			if($_FILES["file"]["error"]==4){
				echo"No file was uploaded";
				}
			
			elseif($ext!="csv"){
				echo"File is of different format";
			}
			else{
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
				}

        }
		elseif($_FILES['file']['size']>10000){
			echo"File is too large";
		}
		
        else {
                 //Print file details
             echo "Upload: " . $name . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             

            //Store file in directory "upload" with the name of "uploaded_file.txt"
            
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $name);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
			
			$str4=file_get_contents("upload/$name");
			
			
			echo("<br/>");
	
			if($delim=='\t'){
				require("api/checkdelimitertab.php");
				checkdelimitertab($str4,"\t",$name,$format);
				
			}
			else{
				require("api/checkdelimiter.php");
				checkdelimiter($str4,$delim,$name,$format);
				
			}
	
			}
     }
	 else {
             echo "No file selected <br />";
     }
	
			
}
 if(isset($_POST['decn'])){
			
			
			$name=$_REQUEST['filename'];
			unlink("upload/$name");
			}
if(isset($_POST['decy'])){
			$name=$_REQUEST['filename'];
			$delim=$_REQUEST['delimitern'];
			$format=strval($_REQUEST['format']);
			
			$file = fopen("upload/$name","r");
			$data=array();
			$i=0;
			if($delim=='\t'){
			while(!feof($file))
			{
				$data[$i++]=(fgetcsv($file,0,$delim));
			}
			}
			else{
		
			while(!feof($file))
			{
				
			$data[$i++]=(fgetcsv($file,0,$delim));
			
			}

			
			if($format=="users"){
		
				require 'api/usertab.php';
				usertab($data);
			}
			elseif($format=="purchases"){
				require 'api/purchasetab.php';
				purchasetab($data);
			}
			else{
				require 'api/productstab.php';
				productstab($data);
			}
			
			}
			unlink("upload/$name");
}
?>
</br>
<a href="http://nimith.vanillanetworks.com/DIF/dashboard.php">DASHBOARD</a>

</center>
  

</body>
</html>
