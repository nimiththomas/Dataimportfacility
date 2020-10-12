<?php
function checkdelimitertab($str4,$delim,$name,$format){
		$a=substr_count($str4,$delim);
			
		//if(strpos($str4,"\t")){
		if($a>100){
			$file = fopen("upload/$name","r");
			
			$count=0;
			echo("</br>");
			echo("</br>");
			echo("<h4>Outline of csv file to be uploaded</h4>");
			echo("</br>");
			
			echo("<table  border = '1'>");
			
			while(! feof($file))
			{
			 $count=$count+1;
			if($delim=='\t'){
				echo("<tr>");
				$line=(fgetcsv($file,0,"\t"));
				$len=sizeof($line);
				for($i=0;$i<sizeof($line);$i++){
					echo("<td>");
					echo($line[$i]);
					echo("</td>");
					
				}
				echo("</tr>");
				
			}
			else{
				echo("<tr>");
				$line=(fgetcsv($file,0,$delim));
				$len=sizeof($line);
				for($i=0;$i<sizeof($line);$i++){
					echo("<td>");
					echo($line[$i]);
					echo("</td>");
					
				}
				echo("</tr>");
				
			}
			
			if($count==6){
				break;
			}
			}
			
			echo("</table>");
			echo('<form action="http://localhost/DIF/upload.php" method="POST">');
			$str2="<input type=" ."'hidden'" . " name=" ."'filename'" ." value=" ."'$name'" . "/>"  ;
			echo($str2);
			$str3="<input type=" ."'hidden'" . " name=" ."'delimitern'" ." value=" ."'$delim'" . "/>"  ;
			echo($str3);
			$str5="<input type=" ."'hidden'" . " name=" ."'format'" ." value=" ."'$format'" . "/>"  ;
			echo($str5);
			echo("</br>");
			echo("Do you wish to continue with the upload");
			echo("</br>");
			echo('<button type="submit"  name="decy" value="yes">Yes</button>');
			echo('</form>');
			echo('</table>');
			echo("</br>");
			echo("</table>");
			echo('<form action="http://localhost/DIF/upload.php" method="POST">');
			echo("or");
			echo("</br>");
			echo("</br>");
			echo("</br>");
			echo($str2);
			echo('<button type="submit"  name="decn" value="no">No</button>');
			echo('</form>');
			echo('</table>');
			
			//echo($_POST['dec']);
			
			//fclose($file);
			//unlink("upload/$name");

				}
		else{
			echo("</br>");
			echo"<h3>You chose the wrong delimiter Please Try again with correct delimiter</h3>";
			unlink("upload/$name");
				
		}
                
}
?>
