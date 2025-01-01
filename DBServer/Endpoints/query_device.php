<?php

//this endpoint is used for search requests for records with a specific device type

try{

if ($did==NULL)//missing device id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: query_device';
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
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
//data validation using regex and checking length. ensures only numeric characters for the device id and also that the id is of a specific length
	
$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);
if($pCheckN==1 || (strlen($did) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device ID.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//device id is valid at this point
	
//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");



if($stat==0){//active records only (default)
	
	//this sql query essentially returns rows where the record's device id matches the given device id. however it only allows records that are active
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	LEFT JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did' AND inactive.sn_id IS NULL
	LIMIT 1000";

}else if($stat==1){//include all records (active and inactive)

	//this sql query essentially returns rows where the record's device id matches the given device id. however it allows all records
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	LEFT JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did'
	LIMIT 1000";

}else if($stat==2){//inactive records only

	//this sql query essentially returns rows where the record's device id matches the given device id. however it only allows records that are inactive
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	INNER JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did'
	LIMIT 1000";

}else{ //$stat only allows 0, 1, and 2. for active, ALL, and inactive. any other value should error out
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: INVALID STATUS REQUEST.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}


//tries the query selected by the if else
try{
    $rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//this code essentially goes through all returned rows and based on the row's 4th field (since 0 indexing) set that returned row's checked value to either "active" or "inactive"
//mainly for ui purposes so easier to understand
//$datarr will be for containing the info that is requested and will be sent back
$datarr=array();


if($rst->num_rows>0){//rows/records with the given device id are found 
			
	while($row = $rst->fetch_row()){
		if($row[3]==null){
			$row[3]="active";
		}else{
			$row[3]="inactive";
		}
		$datarr[]=$row;
	}

}else{//rows/records not found
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device Not Found.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//$datarr should not be empty at this point, will error out if found this way
if($datarr==null){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Data Failed to be retrieved.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
//action completed successfully
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$jsonManufacturer=json_encode($datarr);
$output[]='MSG: '.$jsonManufacturer;
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
	
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Request Failed.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>