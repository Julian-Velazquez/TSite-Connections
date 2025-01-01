<?php
//endpoint that handles sending out a list of ACTIVE manufacturers
try{
//do not use, please see comment notes above function definition
//tl;dr poor security since it was being used with fake data, real data requires better security
$dblink=db_connect("[name of database]");
$sql="Select `name`, `auto_id` from `manufacturer` where `status`='active'";
//tries to query the database for list of active manufacturers, if it fails it sends out the written error message
try{
$result=$dblink->query($sql);
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: QUERY FAILED.';
    $output[]='Action: list_manufacturer';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
//if query succeeds, sets up $manufactur as an array and while manufacturers are still being listed out,
//it sets up key value pairs for the array listed as the 'auto_id' (all unique values) of the manufacturer type being the key and assigns the value 'name' (the actual manufacturer name)
//i.e., $manufacturer[1] = firstmanufacturername;
//accounts for errors and sends error messages should an error occur
$manufacturer=array();
while ($data=$result->fetch_array(MYSQLI_ASSOC))
	$manufacturer[$data['auto_id']]=$data['name'];
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$jsonManufacturer=json_encode($manufacturer);
$output[]='MSG: '.$jsonManufacturer;
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();
}catch(Exception $e){
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: REQUEST FAILED.';
    $output[]='Action: list_manufacturers';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
?>