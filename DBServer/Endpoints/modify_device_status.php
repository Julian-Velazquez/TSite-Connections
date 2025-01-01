<?php

//this endpoint is for changing a device type's status (active to inactive or inactive to active)

try{
if ($did==NULL)//device id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: modify_device_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if ($stat==NULL)//status request is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing status.';
    $output[]='Action: modify_device_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");


//data validation using regex and checking length
//ensures only valid characters for the device id and also that the id is of a specific length

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);

if($pCheckN==1 || (strlen($did) > 8)){
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update Device Invalid ID.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}



//sql query searches for an existing device type that has the given device id

$checkidsql="Select `auto_id` from `devices` where `auto_id` ='$did'";
try{
	$CISrst=$dblink->query($checkidsql);
}catch(Exception $e){
		
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: QUERY FAILED.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
}
if($CISrst->num_rows<=0){//device id not in database
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Device ID NOT FOUND.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}


//device id is valid at this point
//this if else determines if the request is for changing a device type's status from active to inactive OR inactive to active

if($stat==0){ // change from inactive to active. errors out if already active
	$statN = "active"; // this is used later to actually set the status
	$sql="SELECT `name`, `auto_id`, `status` FROM `devices`
	WHERE status = 'active' and auto_id = '$did'";
	try{
		$rst=$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: QUERY FAILED.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
	if($rst->num_rows>0){ // found dev id with active status 
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Device active status already set.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();	
		
	}
	
	
	
	
	
}else if($stat==1){ //change from active to inactive. errors out if already inactive
	$statN = "inactive"; //used later to actually set status
	$sql="SELECT `name`, `auto_id`, `status` FROM `devices`
	WHERE status = 'inactive' and auto_id = '$did'";
	try{
		$rst=$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: QUERY FAILED.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
	if($rst->num_rows>0){ // found device id with inactive status 
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
   		$output[]='MSG: Device inactive status already set.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();	
		
	}
	
}else{ //invalid status request
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: INVALID STATUS REQUEST.';
    $output[]='Action: modify_device_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
	
}

	
		
// device id is valid and status check passed
//$statN is set earlier so the sql query will correctly change the status based on the option selected			

$updatesql="UPDATE `devices` SET status = '$statN' WHERE auto_id = '$did'";
try{
	$updaterst=$dblink->query($updatesql);
}catch(Exception $e){
	header('Content-Type: application/json');
    	header('HTTP/1.1 200 OK');
    	$output[]='Status: ERROR';
    	$output[]='MSG: QUERY FAILED.';
    	$output[]='Action: modify_device_status';
    	$responseData=json_encode($output);
    	echo $responseData;
    	die();
}
			
			
			
			
			
			
		//action completed successfully
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: SUCCESS';
    		$output[]='MSG: Dev status Updated Successfully.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
		
}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: REQUEST FAILED.';
    		$output[]='Action: modify_device_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}


?>