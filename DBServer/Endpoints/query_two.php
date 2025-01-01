<?php

//this endpoint is for requesting records that have both the requested device id and requested manufacturer id
//also contains options to display only active records, only inactive records, or all records. (all options must still match the given device id and manufacturer id)

try{
if ($did==NULL)//missing device id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: query_two';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($mid==NULL)//missing manufacturer id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer id.';
    $output[]='Action: query_two';
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
	
//data validation using regex and checking length. ensures only valid characters for the device id and manufacturer id and also that the ids are of a specific length
	
$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);
if($pCheckN==1 || (strlen($did) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device ID.';
    $output[]='Action: query_two';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//device id is valid at this point
	
$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $mid);
if($pCheckN==1 || (strlen($mid) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Manufacturer ID.';
    $output[]='Action: query_two';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//manufacturer id is valid at this point
	
	
	
	
//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");


//these sql queries essentially return rows where the record's device id and manufacturer id matches the given device id and manufacturer id
//$stat contains the status request is used to determine what kind of records matching the criteria will be returned, either only active records, only inactive records, or all records. (all options will still only return records that match the initial criteria)


if($stat==0){//active records only (default)
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	LEFT JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did' AND manufacturer_id = '$mid' AND inactive.sn_id IS NULL
	LIMIT 1000";
}else if($stat==1){//include all records (active and inactive)
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	LEFT JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did' AND manufacturer_id = '$mid'
	LIMIT 1000";
}else if($stat==2){//inactive records only
	$sql="SELECT devices.name, manufacturer.name, serials.serial_number, inactive.sn_id 
	FROM serials 
	INNER JOIN devices on devices.auto_id = serials.device_id
	INNER JOIN manufacturer on manufacturer.auto_id = serials.manufacturer_id
	INNER JOIN inactive on inactive.sn_id = serials.auto_id
	WHERE device_id = '$did' AND manufacturer_id = '$mid'
	LIMIT 1000";
}else{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: INVALID STATUS REQUEST.';
    $output[]='Action: query_two';
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
    $output[]='Action: query_two';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}


//this code essentially goes through all returned rows and based on the row's 4th field (since 0 indexing) set that returned row's checked value to either "active" or "inactive"
//mainly for ui purposes so easier to understand
//$datarr will be for containing the info that is requested and will be sent back
$datarr=array();

if ($rst->num_rows>0){//device and manufacturer pair is found 
			
	while($row = $rst->fetch_row()){
		if($row[3]==null){
			$row[3]="active";
		}else{
			$row[3]="inactive";
		}
		$datarr[]=$row;
				
	}
}else{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device and manufacturer pair Not Found.';
    $output[]='Action: query_two';
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
    $output[]='Action: query_two';
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
    $output[]='Action: query_two';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>