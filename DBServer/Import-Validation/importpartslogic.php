<?php

//this file imports data into database if importing directly through a csv file
//originally created to deal with hardware/software restrictions that made working with large amounts of data near impossible / very tedious
//this file will work with broken up large files and concurrently import records from each split part  (confirmed successful test with 5 mil records on hardware with less than 1GB of ram)
//errors are handled and logged with error types indicated by values set in the errortype array


//note: directories and files are placeholders now that server is no longer active

include("[placeholder errorfile].php"); // error file
$dblink=db_connect("[placeholder database name]"); // database connection
echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
$fp=fopen("/where/parts/are/$argv[2]","r"); // split massive record files and store the parts in this directory
$count=0;
$errorCount=0;

$errorType = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0); // used for indicating what error type occurred with the current tested record

$time_start=microtime(true); // used for timing each process, not really necessary for function just for efficiency testing
echo "PHP ID:$argv[1]-Start time is: $time_start\n";
while (($row=fgetcsv($fp)) !== FALSE) 
{
	$ret=0;
	$count++;
	$sql="SELECT `serial_number` FROM `devices` WHERE `serial_number` = '$row[2]'"; // sql query was based on tested database architecture. must be adjusted for different databases
	$dupRet=$dblink->query($sql);
	if($dupRet->num_rows !== 0){ //checks if SN exists in database
		echo "ERROR: duplicate SN in line $count errorcount is $errorCount + 1 \n";
		$errorType[1]++;
		$errorCount++;
		continue;
	}else{ // SN does not exist in database so then test functions are ran to ensure only valid data is inserted to database
	$ret=blankCheckFull($row, $count, $ret, $errorCount);
	$ret=fieldsCheck($row, $count, $ret);
	$ret=allowedchars($row, $count, $ret);
		
	if($ret !== 0){//error was found, error type is specified by error checking functions. 
		$errorType[$ret]++; //specific errors
		$errorCount++; //overall errors
		continue;
	}else{//error checking passed. runs insert sql query
	
	$sql="Insert into `devices` (`device_type`,`manufacturer`,`serial_number`) values ('$row[0]','$row[1]','$row[2]')"; // sql query was based on tested database architecture. must be adjusted for different databases
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);
	}
	}
}
$time_end=microtime(true); // concludes time testing
//stats are displayed per process (time and error stats)
//time stats include how long each process ran along with insert rate (rows/records per second from the csv file part)
//error stats include overall errors and how many of each error type occured through all tested records per process

echo "\nTIME AND ERROR STATS\n";
echo "PHP ID:$argv[1]-End Time:$time_end\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "PHP ID:$argv[1]-Execution time: $execution_time minutes or $seconds seconds.\n";
$rowsPerSecond=$count/$seconds;
echo "PHP ID:$argv[1]-Insert rate: $rowsPerSecond per second\n";
echo "PHP ID:$argv[1]-Types of Errors found: ";

foreach($errorType as $typeCount){
	echo " $typeCount";
}
echo "\nPHP ID:$argv[1]-Total Errors found: $errorCount \n";

fclose($fp);
?>