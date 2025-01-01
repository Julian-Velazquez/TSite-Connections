<?php
//this endpoint is to modify an existing manufacturer type's name to another manufacturer name

try{
if ($mid==NULL)//manufacturer id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer id.';
    $output[]='Action: modify_manufacturer_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if ($updatemid==NULL)//new manufacturer name is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer name.';
    $output[]='Action: modify_manufacturer_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}


//validates the given new manufacturer name that is going to be set as existing manufacturer type's new name
//then validates existing manufacturer id to ensure correct length and valid characters
//essentially keeps same manufacturer id but changes name

	
$pattern="~[^a-zA-Z0-9- ]~";
$pCheck=preg_match($pattern, $updatemid);

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $mid);

if($pCheckN==1 || (strlen($mid) > 8)){
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update Manufacturer Invalid ID.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}

if($pCheck==1 || (strlen($updatemid) > 128)){
			
			
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update Manufacturer Invalid Name.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}
	
	

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");

	


//manufacturer id and new name is valid at this point
//this query is used to get the specific manufacturer type with the given manufacturer id	
$checkidsql="Select `auto_id` from `manufacturer` where `auto_id` ='$mid'";
try{
		$CISrst=$dblink->query($checkidsql);
}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}

if($CISrst->num_rows<=0){ // manufacturer id not found
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Manufacturer ID NOT FOUND.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}
	
	
	
//queries database to check if there is an existing manufacturer type with the new manufacturer name
$upmansql="Select `auto_id` from `manufacturer` where `name`='$updatemid'";
try{
		$upmanrst=$dblink->query($upmansql);
}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}

//existing manufacturer does have the new manufacturer name set to that already
if($upmanrst->num_rows>0)//manufacturer name already exist
{
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: manufacturer name already exists.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
}
			
			
//data is valid at this point
//updates given existing manufacturer type. changes name to the given NEW manufacturer name				
$updatesql="UPDATE `manufacturer` SET name = '$updatemid' WHERE auto_id = '$mid'";
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
    		$output[]='MSG: Man Value Updated Successfully.';
    		$output[]='Action: modify_manufacturer_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
		
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: modify_manufacturer_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>