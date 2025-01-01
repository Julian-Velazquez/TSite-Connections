<?php
ob_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TSite Connections</title>
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.css">
<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/templatemo-style.css">
</head>
<body>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">
               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Search Equipment Database</a>
               </div>
               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                        <li><a href="index.php" class="smoothScroll">Home</a></li>
                        <li><a href="search.php" class="smoothScroll">Search Equipment</a></li>
                        <li><a href="add.php" class="smoothScroll">Add Equipment</a></li>
			<li><a href="modify.php" class="smoothScroll">Modify Equipment</a></li>
                    </ul>
               </div>
          </div>
     </section>
 <!-- HOME -->
     <section id="home">
          </div>
     </section>
     <!-- FEATURE -->
     <section id="feature">
          <div class="container">
               <div class="row">
                   
                   <?php 
			//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
				//originally used for requesting all device types
						$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="";
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
						curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'content-type: application/x-www-form-urlencoded',
							'content-length: '.strlen($data))
									);
						$result=curl_exec($ch);
						curl_close($ch);
						$resultsarr=json_decode($result,true);
				   		$tmp=$resultsarr[1];
				   		$paydata=explode("MSG:",$tmp);
				   		$devices=json_decode($paydata[1],true);
				   		
				   //originally used for requesting all manufacturer types
				   		$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="";
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
						curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'content-type: application/x-www-form-urlencoded',
							'content-length: '.strlen($data))
									);
						$result=curl_exec($ch);
						curl_close($ch);
						$resultsarr=json_decode($result,true);
				   		$tmp=$resultsarr[1];
				   		$paydata=explode("MSG:",$tmp);
				   		$manufacturers=json_decode($paydata[1],true);
						
						//device types, manufacturer types, and specific records have an active or inactive status. $stat is used to allow the user to view types and records based on status
						//i.e show all device types with active status, show all device types with inactive status, or just show all device types
                   		
				   		$stat=array();
				   		$stat[0]="active";
				   		$stat[1]="all";
				   		$stat[2]="inactive";

				   //error messages to display to the user based on error returned by the endpoint that received the curl request
				   
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DNF")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Not Found in Database!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DNR")
                        {
                            echo '<div class="alert alert-danger" role="alert">Data Not Found in Database!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MNF")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Not Found in Database!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNF")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number Not Found in Database!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="TNF")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Manufacturer Pair Not Found in Database!</div>';
                        }
				   
                   ?>
                    <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleDevice">Device:</label>
                        <select class="form-control" name="device">
                            <?php
				//list out all device types (list received through curl request made to an endpoint)
                                foreach($devices as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleManufacturer">Manufacturer:</label>
                        <select class="form-control" name="manufacturer">
                            <?php
				//list out all manufacturer types (list received through curl request made to an endpoint)
                                foreach($manufacturers as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSerial">Serial Number:</label>
                        <input type="text" class="form-control" id="serialInput" name="serialnumber">
                    </div>
					<div class="form-group">
                        <label for="exampleStatus">Status:</label>
                        <select class="form-control" name="status">
                            <?php
				//lists out status options (active, inactive, and all) to be saved and used later based on user input
                                foreach($stat as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
                        <button type="submit" class="btn btn-primary" name="devsubmit" value="submit">Search By Device</button>
						<button type="submit" class="btn btn-primary" name="mansubmit" value="submit">Search By Manufacturer</button>
						<button type="submit" class="btn btn-primary" name="sersubmit" value="submit">Search By Serial Number</button>
						<button type="submit" class="btn btn-primary" name="twosubmit" value="submit">Search By Device AND Manufacturer</button>
                   </form>
				   <?php
    if (isset($_POST['sersubmit']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
		
		$stat=$_POST['status'];
		
		//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
		//originally used to seach for a specific record based on serial number
		
		$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
		$data="sn=".$serialNumber."&stat=".$stat;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
		curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: '.strlen($data))
					);
		$result=curl_exec($ch);
		curl_close($ch);
		$resultsarr=json_decode($result,true);
		$tmp=$resultsarr[1];
		$paydata=explode("MSG: ",$tmp);
		
		$endres=json_decode($paydata[1],true);

		//error messages

        	if($paydata[1]=="Serial Number Not Found."){
							header("Location: search.php?msg=SNF");
						}
		if($paydata[1]=="Data Failed to be retrieved."){
							header("Location: search.php?msg=DNR");
						}
		
       		if ($endres != null){//records are found so it displays all results in a table

        		//table header containing names for each column
            		echo "<table border=2px id='testtable'><tr><td>Device</td><td>Manufacturer</td><td>Serial Number</td><td>Status</td></tr>";

			//results
            		foreach($endres as $value){
				echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$value[2]." </td><td>".$value[3]." </td></tr>";
			}
            		echo "</table>";
	   }
			
			
			
    	
	}
	if (isset($_POST['devsubmit']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
	$stat=$_POST['status'];
		
		//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
		//originally used to search for specific device type

        	$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
		$data="did=".$device."&stat=".$stat;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
		curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: '.strlen($data))
					);
		$result=curl_exec($ch);
		curl_close($ch);
		$resultsarr=json_decode($result,true);
		$tmp=$resultsarr[1];
		$paydata=explode("MSG: ",$tmp);
		
		$endres=json_decode($paydata[1],true);
		
		//error messages

		if($paydata[1]=="Device Not Found."){
							header("Location: search.php?msg=DNF");
						}
		if($paydata[1]=="Data Failed to be retrieved."){
							header("Location: search.php?msg=DNR");
						}
		
		
        if ($endres != null)//devices are found so it displays the results on a table
        {
            
	    //table header
            echo "<table border=2px id='testtable'><tr><td>Device</td><td>Manufacturer</td><td>Serial Number</td><td>Status</td></tr>";
	    //results	
            foreach($endres as $value){
	    	echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$value[2]." </td><td>".$value[3]." </td></tr>";
	    }
            echo "</table>";
			
        }
        
    	}
if (isset($_POST['mansubmit']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
        $stat=$_POST['status'];
	
		//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
		//originally used to search for specific manufacturer type

        	$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
		$data="mid=".$manufacturer."&stat=".$stat;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
		curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: '.strlen($data))
					);
		$result=curl_exec($ch);
		curl_close($ch);
		$resultsarr=json_decode($result,true);
		$tmp=$resultsarr[1];
		$paydata=explode("MSG: ",$tmp);
		
		$endres=json_decode($paydata[1],true);
		
		//error messages	

		if($paydata[1]=="Manufacturer Not Found."){
							header("Location: search.php?msg=MNF");
						}
		if($paydata[1]=="Data Failed to be retrieved."){
							header("Location: search.php?msg=DNR");
						}
	
	
        if ($endres != null)//manufacturers are found so displays results on a table
        {
            
	    //table header	
            echo "<table border=2px id='testtable'><tr><td>Device</td><td>Manufacturer</td><td>Serial Number</td><td>Status</td></tr>";
	    //results	
            foreach($endres as $value){
	    	echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$value[2]." </td><td>".$value[3]." </td></tr>";
	    }
            echo "</table>";
			
        }
        
    	}
				   
if (isset($_POST['twosubmit']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
        $stat=$_POST['status'];
	
		//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
		//originally used to search for device and manufacturer type pairings (records with both the specified device type AND specified manufacturer type)

        	$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
		$data="did=".$device."&mid=".$manufacturer."&stat=".$stat;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
		curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: '.strlen($data))
					);
		$result=curl_exec($ch);
		curl_close($ch);
		$resultsarr=json_decode($result,true);
		$tmp=$resultsarr[1];
		$paydata=explode("MSG: ",$tmp);
		
		$endres=json_decode($paydata[1],true);
		
		//error messages
		if($paydata[1]=="Device and manufacturer pair Not Found."){
							header("Location: search.php?msg=TNF");
						}
		if($paydata[1]=="Data Failed to be retrieved."){
							header("Location: search.php?msg=DNR");
						}
	
        if ($endres != null)//pairings are found so displays results in a table
        {
            
	    //table header	
            echo "<table border=2px id='testtable'><tr><td>Device</td><td>Manufacturer</td><td>Serial Number</td><td>Status</td></tr>";
	    //results	
            foreach($endres as $value){
	    	echo "<tr><td>".$value[0]."</td><td>".$value[1]."</td><td>".$value[2]." </td><td>".$value[3]." </td></tr>";
	    }
            echo "</table>";
			
        }
       
    	}
				   
				   
				   
?>
				   
				   
				   
				   
				   
               </div>
          </div>
     </section>
</body>
</html>
