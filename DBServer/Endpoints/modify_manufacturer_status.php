<?php

//this endpoint is for changing a manufacturer type's status (active to inactive or inactive to active)

try{
if ($mid==NULL)//manufacturer id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer id.';
    $output[]='Action: modify_manufacturer_status';
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
    $output[]='Action: modify_manufacturer_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}


//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");



//data validation using regex and checking length
//ensures only valid characters for the manufacturer id and also that the id is of a specific length

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $mid);

if($pCheckN==1 || (strlen($mid) > 8)){
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Update manufacturer Invalid ID.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}



//sql query searches for an existing manufacturer type that has the given manufacturer id

$checkidsql="Select `auto_id` from `manufacturer` where `auto_id` ='$mid'";
try{
		$CISrst=$dblink->query($checkidsql);
}catch(Exception $e){	
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
}
if($CISrst->num_rows<=0){ // manufacturer id not in database
			
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: manufacturer ID NOT FOUND.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}




//manufacturer id is valid at this point
//this if else determines if the request is for changing a manufacturer type's status from active to inactive OR inactive to active

if($stat==0){ // change from inactive to active. errors out if already active
	$statN = "active"; // this is used later to actually set the status
	$sql="SELECT `name`, `auto_id`, `status` FROM `manufacturer`
	WHERE status = 'active' and auto_id = '$mid'";
	try{
		$rst=$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
	if($rst->num_rows>0){ // found manufacturer id with active status 
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: manufacturer active status already set.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();		
	}
	
	
	
}else if($stat==1){//change from active to inactive. errors out if already inactive
	$statN = "inactive"; //used later to actually set status
	$sql="SELECT `name`, `auto_id`, `status` FROM `manufacturer`
	WHERE status = 'inactive' and auto_id = '$mid'";
	try{
		$rst=$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: QUERY FAILED.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
	if($rst->num_rows>0){ // found manufacturer id with inactive status 
	
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: manufacturer inactive status already set.';
		$output[]='Action: modify_manufacturer_status';
		$responseData=json_encode($output);
		echo $responseData;
		die();	
	}
	
}else{//invalid status request
	
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: INVALID STATUS REQUEST.';
    $output[]='Action: modify_manufacturer_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
	
}


	
// manufacturer id is valid and status check passed
//$statN is set earlier so the sql query will correctly change the status based on the option selected		
			
$updatesql="UPDATE `manufacturer` SET status = '$statN' WHERE auto_id = '$mid'";
try{
	$updaterst=$dblink->query($updatesql);
}catch(Exception $e){
	header('Content-Type: application/json');
    	header('HTTP/1.1 200 OK');
   	$output[]='Status: ERROR';
   	$output[]='MSG: QUERY FAILED.';
    	$output[]='Action: modify_manufacturer_status';
    	$responseData=json_encode($output);
    	echo $responseData;
    	die();
}
			
			
			
		//action completed successfully
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: SUCCESS';
    		$output[]='MSG: manufacturer status Updated Successfully.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
			
		
}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: REQUEST FAILED.';
    		$output[]='Action: modify_manufacturer_status';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
}


?>