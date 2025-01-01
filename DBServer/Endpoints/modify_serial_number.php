<?php
//this endpoint is used to modify the serial number of a specific record
		
try{

if ($sn==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing serial number.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($sntwo==NULL)//missing additional serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing additional serial number.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
//received data length is checked and validation is done with the regex pattern to ensure only specific characters and only of a certain length
$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $sn);
	
	
if($pCheck1==1 || (strlen($sn) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Serial Number.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//additional check for length and validation of additional serial number
	
$pattern="~[^a-zA-Z0-9- ]~";
$pCheck1=preg_match($pattern, $sntwo);
	
	
if($pCheck1==1 || (strlen($sntwo) > 128)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Additional Serial Number.';
    $output[]='Action: modify_serial_number';
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
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
		
	
	
//looks for record with given additional serial number
	
$twosql="Select `auto_id` from `serials` where `serial_number`='$sntwo'";
try{
    $tworst=$dblink->query($twosql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Query Failed.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
		
if($tworst->num_rows>0){ // Additional SN is already in database 
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Additonal Serial Number Already Exists.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
	
//result from first query, record with first serial number
	
if ($rst->num_rows>0)//found row to modify
{
	$sql="UPDATE `serials` SET serial_number = '$sntwo' WHERE serial_number = '$sn'"; //gets specific record using first serial number and changes that serial number to given additional serial number
	try{
            $dblink->query($sql);
	}catch(Exception $e){
		header('Content-Type: application/json');
    		header('HTTP/1.1 200 OK');
    		$output[]='Status: ERROR';
    		$output[]='MSG: Query Failed.';
    		$output[]='Action: modify_serial_number';
    		$responseData=json_encode($output);
    		echo $responseData;
    		die();
	}
}else{
			
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Record Not Found.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
			
}
	
//action completed successfully
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$output[]='MSG: Serial Number Modified Successfully';
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
	
	
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Request Failed.';
    $output[]='Action: modify_serial_number';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
?>