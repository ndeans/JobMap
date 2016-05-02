<?php 

	// get data
	$link = mysql_connect('localhost','usr_wsjoblist','nUpfmysqNf2F3687') or die('cannot connect to CRM database...');
	@mysql_select_db('bitnami_sugarcrm',$link) or die('cannot select database...');
			
	$sql_select = "select o.`name`, c.`job_location_c`, c.`primary_skill_c`, c.`hourly_rate_c`, c.`annual_rate_c`, o.`probability` ";
	$sql_from = "from bitnami_sugarcrm.`opportunities` o, bitnami_sugarcrm.`opportunities_cstm` c ";
	$sql_where = "where c.`id_c` = o.`id` AND o.`probability` > 0 ";
	$sql_order = "order by o.`probability` DESC";
			
	$query = $sql_select.$sql_from.$sql_where.$sql_order;
	// echo $query."<hr>";
	
	$result = mysql_query($query, $link) or die('errant query...'.' ... '.$query);
	$jobs = array();
	
	if (mysql_num_rows($result)>0) {
		while ($job = mysql_fetch_assoc($result)) {
			$jobs[] = array('job'=>$job);
		}
	}

	// open link to geocode data
	@mysql_select_db('ndeans_support',$link) or die('cannot select support database...');

	// build xml

	$xml 			= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	$xml		   .= "<jobs>"; 
	
	foreach ($jobs as $index => $job) {
		if (is_array($job)) {
			foreach ($job as $key => $value) {
				$xml .= "<job>";
				if (is_array($value)) {
					foreach ($value as $tag => $val) {
						$xml .= '<'.$tag.'>';
						$xml .= $val;
						$xml .= '</'.$tag.'>';
						if ($tag == "job_location_c") {

							// add latitude element
							$query = "SELECT latitude FROM ndeans_support.`geocodes` WHERE location = '" . $val ."'";
							$result = mysql_query($query, $link);
							$row = mysql_fetch_array($result);
							$lat = $row[0];
							$xml .= '<lat>'.$lat.'</lat>';

							// add longitude element
							$query = "SELECT longitude FROM ndeans_support.`geocodes` WHERE location = '" . $val ."'";
							$result = mysql_query($query, $link);
							$row = mysql_fetch_array($result);
							$lng = $row[0];
							$xml .= '<lng>'.$lng.'</lng>';

						}
					}
				}
				$xml .= "</job>";
			}
		}
		
   	}
		
	$xml .= "</jobs>";
	@mysql_close($link);

	// return xml
	header('Content-type: text/xml');
	echo $xml;

?>



