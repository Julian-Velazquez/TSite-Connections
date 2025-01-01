<?php	

//this endpoint modifies an existing record's status (active or inactive)
		
try{

if ($sn==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing serial number.';
    $output[]='Action: modify_sn_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($stat==NULL)//missing status request
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing status request.';
    $output[]='Action: modify_sn_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//data validation using regex and checking length. ensures only valid characters for the serial number and also that the number is of a specific length

$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $sn);
	
	
if($pCheck1==1 || (strlen($sn) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid sn.';
    $output[]='Action: modify_sn_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}



//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");


//sql query searches for an existing record that has the given serial number
$sql="Select `auto_id` from `serials` where `serial_number`='$sn'";
		
	
try{
        $rst=$dblink->query($sql);
}catch(Exception $e){
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: ERROR';
	$output[]='MSG: QUERY FAILED.';
	$output[]='Action: modify_sn_status';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
	
if ($rst->num_rows>0)//found row to modify
{
	//stores the found record in $row and the first field in $aid
	//$aid is the connecting column for two tables and is used to assist in changing the status of a record and keeping track of the status
	$row = $rst->fetch_row();
	if($row == null){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: fetch row returned null.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	$aid = $row[0];
			
           
            
}else{
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: ERROR';
	$output[]='MSG: sn not found.';
	$output[]='Action: modify_sn_status';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}

//$aid should not be null, error out if so
if($aid == null){
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: ERROR';
	$output[]='MSG: Data failed to populate.';
	$output[]='Action: modify_sn_status';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}

//this if else determines if the request is for changing a record's status from active to inactive OR inactive to active
	
if($stat==0){//change to active
	//sql query is checking the record stored in serials against the table inactive which contains all the inactive records
	//basically if a record is in inactive, its an inactive record. if a record is in serials but is not in inactive then its an active record.
	//if query returns row then the record is already active and will error out
	$sql="Select serials.auto_id, serials.serial_number
	from `serials` 
	LEFT JOIN `inactive` on inactive.sn_id = serials.auto_id
	where serials.serial_number = '$sn' AND inactive.sn_id IS NULL";
	try{
		$rst = $dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: QUERY FAILED.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	if($rst->num_rows>0){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: sn active status already set.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	//found existing record and it is inactive. deletes from inactive table as it will be active now
	$sql="DELETE FROM `inactive` WHERE sn_id = '$aid'";
	try{
		$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: QUERY FAILED.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	
}else if($stat==1){//change to inactive
	
	//sql query is checking the record stored in serials against the table inactive which contains all the inactive records
	//basically if a record is in inactive, its an inactive record. if a record is in serials but is not in inactive then its an active record.
	//if query returns row then the record is already inactive and will error out
	$sql="Select serials.auto_id, serials.serial_number
	from `serials` 
	INNER JOIN `inactive` on inactive.sn_id = serials.auto_id
	where serials.serial_number = '$sn'";
	
	try{
		$rst = $dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: QUERY FAILED.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	if($rst->num_rows>0){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: sn inactive status already set.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	
	//found record and it is active. changes to inactive and adds it to the inactive table
	$sql="INSERT INTO `inactive`(`sn_id`) VALUES ('$aid')";
	try{
            $dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: QUERY FAILED.';
		$output[]='Action: modify_sn_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
}else{//invalid status request
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: ERROR';
	$output[]='MSG: invalid status request.';
	$output[]='Action: modify_sn_status';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
	//action completed successfully
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: SUCCESS';
	$output[]='MSG: status request successfull.';
	$output[]='Action: modify_sn_status';
	$responseData=json_encode($output);
	echo $responseData;
	die();
        
}catch(Exception $e){
				header('Content-Type: application/json');
				header('HTTP/1.1 200 OK');
				$output[]='Status: ERROR';
				$output[]='MSG: REQUEST FAILED.';
				$output[]='Action: modify_sn_status';
				$responseData=json_encode($output);
				echo $responseData;
				die();
}
		
?>