<?php
//endpoint that handles sending a list of ACTIVE devices
try{
//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");
$sql="Select `name`, `auto_id` from `devices` where `status`='active'";
//tries to query database for list of active devices, if failure then sends out the written error message
try{
$result=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: list_devices';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
//if query succeeds, sets up $devices as an array and while devices are still being listed out,
//it sets up key value pairs for the array listed as the 'auto_id' (all unique values) of the device type being the key and assigns the value 'name' (the actual device name)
//i.e., $devices[1] = firstdevicename;
//accounts for errors and sends error messages should an error occur 
$devices=array();
while ($data=$result->fetch_array(MYSQLI_ASSOC))
	$devices[$data['auto_id']]=$data['name'];
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$jsonDevices=json_encode($devices);
$output[]='MSG: '.$jsonDevices;
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: list_devices';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>