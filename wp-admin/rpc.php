<?php
	
	// PHP5 Implementation - uses MySQLi.
	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
	//header("content-type: text/xml; charset=windows-874");
	include("../Connect2.php");
	//$db = new mysqli('localhost', 'root' ,'123456', 'pangsakcom_doe');
	//$db->query("SET NAMES 'utf8'");
	//mysql_db_query('pangsakcom_doe', "SET NAMES utf8");

	if(!$db) {
		// Show error if we cannot connect.
		echo 'ERROR: Could not connect to the database.';
	} else {
		// Is there a posted query string?
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			//echo $queryString = iconv('TIS-620', 'UTF-8',$queryString);
			//echo $queryString;
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) {
				// Run the query: We use LIKE '$queryString%'
				// The percentage sign is a wild-card, in my example of countries it works like this...
				// $queryString = 'Uni';
				// Returned data = 'United States, United Kindom';
				
				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
				
				$query = $db->query("SELECT job_id,job_name FROM tbl_job WHERE job_name LIKE '".$queryString."%' LIMIT 10");
				if($query) {
					// While there are results loop through them - fetching an Object (i like PHP5 btw!).
					while ($result = $query ->fetch_object()) {
						// Format the results, im using <li> for the list, you can change it.
						
						// The onClick function fills the textbox with the result.
						//$strUTF = iconv('UTF-8', 'TIS-620',$result->value);
						//echo ".$strUTF.";

						// YOU MUST CHANGE: $result->value to $result->your_colum
	         			echo '<li onClick="fill(\''.$result->job_name.','.$result->job_id.'\');">'.$result->job_name.'</li>';
	         			//echo '<li onClick="fill2(\''.$result->job_id.'\');">'.$result->job_id.'</li>';
	         		}
				} else {
					echo 'ERROR: There was a problem with the query.';
				}
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>
