<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>DASHBOARD</title>
</head>

<body>
<center>
<table width="600">
<form action="" method="post">

<tr>
<td width="20%">Enter Username</td>
<td width="80%"> <input type="text" name="susername" required/></td>
</tr>
<tr>
<td>Submit</td>
<td><button type="submit"  name="search" value="search">Search</button></td>
</tr>

</form>



</table>
<?php
require 'api/myerrorhandler.php';
require 'api/db_connect.php';
if(isset($_POST['search'])){
	$susername=strtolower($_REQUEST['susername']);
	$sql="SELECT userid FROM csv_users WHERE username=:username";
  
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $susername);
	$stmt->execute();
 
    $result = $stmt->fetch();
    if (isset($result['userid'])) {
        $suserid=$result['userid'];
		$sqlu="SELECT productid, quantity FROM csv_sales WHERE userid=:userid";
		$stmtu = $dbh->prepare($sqlu);
		$stmtu->bindParam(':userid', $suserid);
		$stmtu->execute();
		$resultu = $stmtu->fetchAll();
		$j=-1;
		$i=-1;
		$sproductid=array();
		$squantity=array();
		foreach($resultu as $urow){
			if(in_array($urow['productid'],$sproductid)){
				$squantity[$j]=$squantity[$j]+$urow['quantity'];
				continue;
			}
			else{
				$i=$i+1;
				$j=$j+1;
			}
			$sproductid[$i]=$urow['productid'];
			$squantity[$j]=$urow['quantity'];
		}
		/*
		for($k=0;$k<sizeof($sproductid);$k++){
			echo($sproductid[$k]);
			echo("<br/>");
			echo($squantity[$k]);
			echo("<br/>");
		}
		*/
		
		if(empty($sproductid)){
           echo("<h3>The entered username does not have any purchase history <h3/>"); 
        }
		else{
			
			$sname=array();
			$scost=array();
			for($k=0;$k<sizeof($sproductid);$k++){
			$sqlp="SELECT name, cost FROM csv_products WHERE productid=:productid";
			$stmtp = $dbh->prepare($sqlp);
			$stmtp->bindParam(':productid', $sproductid[$k]);
			$stmtp->execute();
			$resultp = $stmtp->fetch();
			
			$sname[$k]=$resultp['name'];
			$scost[$k]=$resultp['cost'];
			/*
			echo("<br/>");
			echo($sname[$k]);
			echo("<br/>");
			echo($scost[$k]);
			echo("<br/>");
			*/
		
		}
		echo("<br/>");
		echo("<br/>");
		$tot_cost=array();
		echo("<table border = '1'>");
		echo("<tr>");
		echo("<td>");
		echo("productname");
		echo("<td/>");
		echo("<td>");
		echo("cost for one item");
		echo("<td/>");
		echo("<td>");
		echo("total quantity purchased");
		echo("<td/>");
		echo("<td>");
		echo("total cost of sale");
		echo("<td/>");
		echo("<tr/>");
		for($m=0;$m<sizeof($sproductid);$m++){
			echo("<tr>");
			echo("<td>");
			echo($sname[$m]);
			echo("<td/>");
			echo("<td>");
			echo($scost[$m]);
			echo("<td/>");
			echo("<td>");
			echo($squantity[$m]);
			echo("<td/>");
			echo("<td>");
			$tot_cost[$m]=$squantity[$m]*$scost[$m];
			echo($tot_cost[$m]);
			echo("<td/>");
			echo("<tr/>");
	
		}
		echo("<table>");
		echo("<br/>");
		$sumtotalcost=0;
		for($l=0;$l<sizeof($tot_cost);$l++){
			$sumtotalcost=$sumtotalcost+$tot_cost[$l];
		}
		echo"<h3>The total amount spent is ".$sumtotalcost."<h3/>";	
		}
	}
		
	else{
		echo("<br/>");
		echo("<h3>The entered username does not exist in database<h3/>");
		}
	

}
?>
<br/>
<a href="http://nimith.vanillanetworks.com/DIF/upload.php">Home</a>


</center>
</body>
</html>
