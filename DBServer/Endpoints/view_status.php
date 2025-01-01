<?php
//endpoint to view a device type's status (active or inactive)
try{

if ($did==NULL)//missing device id send error msg
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//ensures only valid device id is used (only numeric characters)
//uses regex to check, along with checking length of given id
$pattern="~[^0-9]~";
$pCheckN=preg_match($pattern, $did);
if($pCheckN==1 || (strlen($did) > 8)){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid Device ID.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//did is valid at this point

//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");
$sql="Select `status` from `devices` WHERE `auto_id` = '$did'";

//looks for the specific device type using its id and returns the requested status information
try{
$result=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Query Failed.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
//query succeeds, then checks that a row/record is actually returned/ able to be found in the database
if ($result->num_rows>0){
	$datresponse = $result->fetch_row(); 
}else{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device ID Not Found.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if($datresponse==null){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device ID Not Found.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

// request is valid, record/row is found, and the requested status information is prepared and sent back

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$jsonVStat=json_encode($datresponse);
$output[]='MSG: '.$jsonVStat;
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
	
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Request Failed.';
    $output[]='Action: view_status';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
	
?>