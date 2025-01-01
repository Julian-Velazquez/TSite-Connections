<?php

//this file is to be used with import file to ensure invalid data is not inserted into database



//used for connection to database whose name is passed into the function (made with intent to utilize fake data, real data requires better security)
//when working with real data use env file system or secret management system

function db_connect($db){
	
	$username= (poor security)
	$password= (poor security)
	
	$host= (poor security)
	$dblink=new MySQLi($host,$username,$password,$db);
	return $dblink;
}

//function uses regex to ensure only letter characters a-z and A-Z, spaces, and numeric characters 0-9 are allowed
//parameters include 
//$string = row/record from the file to be tested
//$count = number of record currently being tested such as the 350th record having 350
//$check = 0 or other number based on if theres errors. if 0 there is no error else error type is indicated by the specific number

function allowedchars($string, $count, $check){
		if($check !== 0){//error already found no further testing needed
			return $check;
		}
		$pattern="~[^a-zA-Z0-9- ]~"; // regex for testing, $string[i] for i number of fields in the record/row
		$pCheck0=preg_match($pattern, $string[0]);
		$pCheck1=preg_match($pattern, $string[1]);
		$pCheck2=preg_match($pattern, $string[2]);
		
		//if else is used for tracking and logging specific error types based on number

		if($pCheck2 == 1){
			echo "ERROR: INVALID CHARACTERS in field SN on line $count \n";
			return 7;
		}else if($pCheck0 == 1){
			echo "ERROR: INVALID CHARACTERS in field DEVICE NAME on line $count \n";
			return 8;
		}else if($pCheck1 == 1){
			echo "ERROR: INVALID CHARACTERS in field MANUFACTURER on line $count \n";
			return 9;
		}else if($pCheck0 == 0 && $pCheck1 == 0 && $pCheck2 == 0){
			return 0; //NO ERRORS FOUND
		}else{
			echo "\n\n ERROR: PREG_MATCH ENCOUNTERED UNEXPECTED ERROR on line $count \n\n";
		}
		
		
		
}

//function checks if fields in the inputted record/row are blank
//parameters include
//$string = row/record from the file to be tested
//$count = number of record currently being tested such as the 350th record having 350
//$check = 0 or other number based on if theres errors. if 0 there is no error else error type is indicated by the specific number
//$errcheck = passed in current errors found ( mainly used in testing not really necessay for function)

function blankCheckFull($string, $count, $check, $errcheck){
	if($check !== 0){
		return $check; //error found already, further testing not needed
	}
	if(strlen($string[0]) == 0 && strlen($string[1]) == 0 && strlen($string[2]) == 0){
		echo "ERROR: ALL FIELDS ARE BLANK on line $count \n";
		return 3;
	}else if(strlen($string[2]) == 0){
		echo "ERROR: SN IS BLANK on line $count errors so far: $errcheck + 1 \n";
		return 4;
	}else if(strlen($string[0]) == 0){
		echo "ERROR: DEVICE NAME IS BLANK on line $count \n";
		return 5;
	}else if(strlen($string[1]) == 0){
		echo "ERROR: MANUFACTURER IS BLANK on line $count \n";
		return 6;
	}
		
	return 0; // fields are not blank, no error
	
	
	
}


//function checks row/record for valid field count. only allows records/rows with valid number of fields to go through
//can adjust based on database architecture by adjusting count($string) !== i for i number of fields
//parameters include
//$string = row/record from the file to be tested
//$count = number of record currently being tested such as the 350th record having 350
//$check = 0 or other number based on if theres errors. if 0 there is no error else error type is indicated by the specific number


function fieldsCheck($string, $count, $check){
	if($check !== 0){
		return $check; // error already found further testing not needed
	}
	if(count($string) !== 3){
		echo "ERROR: INVAILD FIELD COUNT on line $count \n";
		return 2;
	}
		
	
	return 0; // no errors found
}



?>
