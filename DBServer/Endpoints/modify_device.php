<?php
//this endpoint is used to modify the device type of a specific record

try{			
if ($did==NULL)//decive id is missing send error msg
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if ($sn==NULL)//missing serial number send error msg
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing serial number.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
//received data length is checked and validation is done with the regex pattern to ensure only numeric characters and only of a certain length

$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);
if($pCheckN==1 || (strlen($did) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device ID.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	

//additional check for length and validation of serial number

$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $sn);
	
	
if($pCheck1==1 || (strlen($sn) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Serial Number.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
	

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");


//finds specific record with given serial number
$sql="Select `auto_id` from `serials` where `serial_number`='$sn'";
try{
    $rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Query Failed.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//finds device type given device id
$didsql="Select `auto_id` from `devices` where `auto_id`='$did'";
try{
    $didrst=$dblink->query($didsql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Query Failed.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
		
if($didrst->num_rows<=0){ // device id not in database
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device Not Found.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
		
if ($rst->num_rows>0)//found row to modify
{
	$sql="UPDATE `serials` SET device_id = '$did' WHERE serial_number = '$sn'"; //gets specific record using serial number and changes device id to given device id
	try{
        	$dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
   		$output[]='Status: ERROR';
   		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_device';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
}else{
			
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Record Not Found.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
            
}
	

//action completed successfully
	
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$output[]='MSG: Device Modified Successfully';
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
	
	
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: modify_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>