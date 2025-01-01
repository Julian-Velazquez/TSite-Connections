<?php
//main file for endpoint redirection. essentially sets up $endPoint to contain the requested endpoint's name in order to determine which "path" to take
//to see more info about each endpoint that the switch case essentially redirects to, please see comments at the beginning of the file listed in the include statement of each case  

include("../[placeholder errorfile].php"); //file that has functions dealing with error checking along with other needed functions

$url=$_SERVER['REQUEST_URI']; // get url data
$path = parse_url($url, PHP_URL_PATH); //grab the requested path/endpoint contained in the url
$pathComponents = explode("/", trim($path, "/")); //break into components to get specific part
$endPoint=$pathComponents[1]; //store name into variable for usage in switch case

//switch case which contains each "path/endpoint" as a case. default case is an error case, must have specific valid name.

switch($endPoint)
{
    	case "add_equipment":
        	$did=$_REQUEST['did'];
        	$mid=$_REQUEST['mid'];
        	$sn=$_REQUEST['sn'];
        	include("add_equipment.php");
        	break;
	case "query_device":
		$did=$_REQUEST['did'];
		$stat=$_REQUEST['stat'];
		include("query_device.php");
		break;
	case "query_manufacturer":
		$mid=$_REQUEST['mid'];
		$stat=$_REQUEST['stat'];
		include("query_manufacturer.php");
		break;
	case "query_serial_number":
		$sn=$_REQUEST['sn'];
		$stat=$_REQUEST['stat'];
		include("query_serial_number.php");
		break;
	case "query_two":
		$did=$_REQUEST['did'];
		$mid=$_REQUEST['mid'];
		$stat=$_REQUEST['stat'];
		include("query_two.php");
		break;	
	case "list_devices":
		include("list_devices.php");
		break;
	case "list_manufacturer":
		include("list_manufacturer.php");
		break;
	case "listALL_devices":
		include("listALL_devices.php");
		break;
	case "listALL_manufacturer":
		include("listALL_manufacturer.php");
		break;
	case "add_device_type":
		$dname=$_REQUEST['dname'];
		include("add_device_type.php");
		break;
	case "add_manufacturer_type":
		$mname=$_REQUEST['mname'];
		include("add_manufacturer_type.php");
		break;
	case "modify_device":
		$did=$_REQUEST['did'];
		$sn=$_REQUEST['sn'];
		include("modify_device.php");
		break;
	case "modify_manufacturer":
		$mid=$_REQUEST['mid'];
		$sn=$_REQUEST['sn'];
		include("modify_manufacturer.php");
		break;
	case "modify_serial_number":
		$sn=$_REQUEST['sn'];
		$sntwo=$_REQUEST['sntwo'];
		include("modify_serial_number.php");
		break;
	case "modify_device_type":
		$did=$_REQUEST['did'];
		$updatedid=$_REQUEST['updatedid'];
		include("modify_device_type.php");
		break;
	case "modify_manufacturer_type":
		$mid=$_REQUEST['mid'];
		$updatemid=$_REQUEST['updatemid'];
		include("modify_manufacturer_type.php");
		break;
	case "modify_device_status":
		$did=$_REQUEST['did'];
		$stat=$_REQUEST['stat'];
		include("modify_device_status.php");
		break;
	case "modify_manufacturer_status":
		$mid=$_REQUEST['mid'];
		$stat=$_REQUEST['stat'];
		include("modify_manufacturer_status.php");
		break;
	case "modify_sn_status":
		$sn=$_REQUEST['sn'];
		$stat=$_REQUEST['stat'];
		include("modify_sn_status.php");
		break;		
	case "view_status":
		$did=$_REQUEST['did'];
		include("view_status.php");
		break;
	case "view_status_man":
		$mid=$_REQUEST['mid'];
		include("view_status_man.php");
		break;
    default:
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Invalid or missing endpoint';
        $output[]='Action: None';
        $responseData=json_encode($output);
        echo $responseData;
        break;
}
die();
?>