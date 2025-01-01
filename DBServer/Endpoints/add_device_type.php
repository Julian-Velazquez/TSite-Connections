<?php
//this endpoint is for adding a new device type to the database
try{
if ($dname==NULL)//new device name is missing send error msg
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device.';
    $output[]='Action: add_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//new device name is checked by a regex pattern, additionally length of name is also checked. if invalid data is found then error msg is sent

$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $dname);	
	
if($pCheck1==1 || (strlen($dname) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device Name.';
    $output[]='Action: add_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
	

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");

//looks to see if device name already exists
$sql="Select `name` from `devices` where `name`='$dname'";
$status="active";
	
try{
    $rst=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: add_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
if ($rst->num_rows>0)//device already exists send error msg
{
            			header('Content-Type: application/json');
				header('HTTP/1.1 200 OK');
				$output[]='Status: ERROR';
				$output[]='MSG: DEVICE ALREADY EXISTS.';
				$output[]='Action: add_device_type';
				$responseData=json_encode($output);
				echo $responseData;
				die();
}
	
//new device name is valid and not already in database at this point
$sql="Insert into `devices` (`name`,`status`) values ('$dname','$status')";
try{
	$dblink->query($sql);
}catch(Exception $e){
				header('Content-Type: application/json');
				header('HTTP/1.1 200 OK');
				$output[]='Status: ERROR';
				$output[]='MSG: QUERY FAILED.';
				$output[]='Action: add_device_type';
				$responseData=json_encode($output);
				echo $responseData;
				die();
}
			
			
		
			
//success msg sent once this point is reached
	
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: SUCCESS';
    		$output[]='MSG: Device Added Successfully.';
    		$output[]='Action: add_device_type';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	
	

}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: add_device_type';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>