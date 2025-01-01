<?php

//this endpoint is used to add new records/rows to the database. information for the record/row includes device id, manufacturer id, and serial number
//newly added records are assumed status active. if inactive status then must be set to that using another endpoint / another option on front end AFTER adding the record

try{
if ($did==NULL)//device id is missing
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
if ($mid==NULL)//missing manufacturer id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer id.';
    $output[]='Action: query_manufacturer';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($sn==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing serial number.';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	

//data validation using regex and checking length. ensures only valid characters for the device id, manufacturer id, and serial number and also that the id or serial number is of a specific length

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);
if($pCheckN==1 || (strlen($did) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device ID.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $mid);
if($pCheckN==1 || (strlen($mid) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid manufacturer ID.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $sn);
if($pCheck1==1 || (strlen($sn) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Serial Number.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
	
	
	
//data is valid at this point
	
//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");



//this query checks if device id exists in database

$sql="SELECT `name` FROM `devices` WHERE auto_id = '$did'";
try{
	$rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}
if($rst->num_rows<=0){ // dev id not found
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device does not exist.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
		
}


//this query checks if given device id has an inactive status (not allowed)

$sql="SELECT `name`, `auto_id`, `status` FROM `devices`
WHERE status = 'inactive' and auto_id = '$did'";
try{
	$rst=$dblink->query($sql);
}catch(Exception $e){
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: ERROR';
	$output[]='MSG: QUERY FAILED.';
	$output[]='Action: add_equipment';
	$responseData=json_encode($output);
	echo $responseData;
	die();	
}
if($rst->num_rows>0){ // found dev id with inactive status 
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device has inactive status.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
		
}


//this query checks if manufacturer id exists in database

$sql="SELECT `name` FROM `manufacturer` WHERE auto_id = '$mid'";
try{
	$rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}
if($rst->num_rows<=0){ // manufacturer id not found
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: manufacturer does not exist.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
		
}


//this query checks if given manufacturer id has an inactive status (not allowed)	

$sql="SELECT `name`, `auto_id`, `status` FROM `manufacturer`
WHERE status = 'inactive' and auto_id = '$mid'";
try{
	$rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}
if($rst->num_rows>0){ // found manufacturer id with inactive status 
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: manufacturer has inactive status.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
		
}


	
	
//this query checks if an existing record with the given serial number already exists	

$sql="Select `auto_id` from `serials` where `serial_number`='$sn'";
try{
        $rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}
if ($rst->num_rows>0)//sn previously found
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Serial Number already exists.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
	

//at this point data is valid and ready to be inserted into the database using this query
	
$sql="Insert into `serials` (`device_id`,`manufacturer_id`,`serial_number`) values ('$did','$mid','$sn')";
try{
	$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}
	
		//action completed successfully
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: SUCCESS';
    		$output[]='MSG: Equipment Added Successfully.';
    		$output[]='Action: add_equipment';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: add_equipment';
    $responseData=json_encode($output);
    echo $responseData;
    die();	
}

?>