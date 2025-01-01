<?php

//this endpoint is to modify an existing device type's name to another device name

try{
if ($did==NULL)//decive id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: modify_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if ($updatedid==NULL)//new device name is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device name.';
    $output[]='Action: modify_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");


//validates the given new device name that is going to be set as existing device type's new name
//then validates existing device id to ensure correct length and valid characters
//essentially keeps same device id but changes name

$errCheck=0;
$pattern="~[^a-zA-Z0-9- ]~";
$pCheck=preg_match($pattern, $updatedid);

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);

if($pCheckN==1 || (strlen($did) > 8)){
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update Device Invalid ID.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}

if($pCheck==1 || (strlen($updatedid) > 128)){
			
			
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update Device Invalid Name.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}



//device id and new name is valid at this point
//this query is used to get the specific device type with the given device id		

$checkidsql="Select `auto_id` from `devices` where `auto_id` ='$did'";
try{
		$CISrst=$dblink->query($checkidsql);
}catch(Exception $e){
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}


if($CISrst->num_rows<=0){ // device id not found
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Device ID NOT FOUND.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}


//queries database to check if there is an existing device type with the new device name
$updevsql="Select `auto_id` from `devices` where `name`='$updatedid'";
try{
		$updevrst=$dblink->query($updevsql);
}catch(Exception $e){
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}

//existing device does have the new device name set to that already
if($updevrst->num_rows>0)//device name already exist
{
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Device name already exists.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
			
}
			

//data is valid at this point
//updates given existing device type. changes name to the given NEW device name		
$updatesql="UPDATE `devices` SET name = '$updatedid' WHERE auto_id = '$did'";
try{
		$updaterst=$dblink->query($updatesql);
			
}catch(Exception $e){
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}
		//action completed successfully
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: SUCCESS';
    		$output[]='MSG: Dev Value Updated Successfully.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
		
    

}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: REQUEST FAILED.';
    		$output[]='Action: modify_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}
?>