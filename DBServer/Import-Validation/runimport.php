<?php

//this file is used for directly importing "records" from a csv file into a database, utilizes another file to handle error checking and giving the all clear before actually inserting
//originally created to deal with hardware/software restrictions that made working with large amounts of data near impossible / very tedious
//"parts" directory is where to store split parts of massive record csv files (confirmed successful test with 5 mil records on hardware with less than 1GB of ram)

//note: directories are currently placeholders now that server is not active


$directory = '/parts/go/here'; //place where split parts are stored
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
foreach($scanned_directory as $key=>$value)
{
	//echo "Processing: $key $value\n";
	shell_exec("/where/php/is/installed /error/file/goes/here/file.php $key $value > /log/files/go/here/$value.log 2>/log/files/go/here/$value.log &");
}
echo "Main Process Done\n";
?>