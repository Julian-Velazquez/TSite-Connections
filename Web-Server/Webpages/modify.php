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
                    <a href="#" class="navbar-brand">Modify Equipment Database</a>
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
						//originally used to list out device types for user selection
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
				   		
				   		//originally used to list out manufacturer types
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
						//i.e show all device types with active status or show all device types with inactive status

				   		$stat=array();
				   		$stat[0]="active";
				   		$stat[1]="inactive";
				   		
				   //error messages to display to the user based on error returned by the endpoint that received the curl request
				   
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MDTDup")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Name Already Exists!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DIA")
                        {
                            echo '<div class="alert alert-info" role="alert">Device Inactive!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ACTD")
                        {
                            echo '<div class="alert alert-info" role="alert">Device Active!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MIA")
                        {
                            echo '<div class="alert alert-info" role="alert">Manufacturer Inactive!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ACTM")
                        {
                            echo '<div class="alert alert-info" role="alert">Manufacturer Active!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="INVALID UPDATE DEV")
                        {
                            echo '<div class="alert alert-danger" role="alert">Invalid Chars in Updated Device Name!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MDTSuc")
                        {
                            echo '<div class="alert alert-success" role="alert">Device Name Changed Successfully!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MDTMISS")
                        {
                            echo '<div class="alert alert-danger" role="alert">Update Device Name Missing!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="NSN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number Missing!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ISN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number Invalid!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DMS")
                        {
                            echo '<div class="alert alert-success" role="alert">Device Modified Successfully!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="RNF")
                        {
                            echo '<div class="alert alert-danger" role="alert">Record Not Found!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMS")
                        {
                            echo '<div class="alert alert-success" role="alert">Manufacturer Modified Successfully!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SMS")
                        {
                            echo '<div class="alert alert-success" role="alert">Serial Number Modified Successfully!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="AISN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Additonal SN Invalid!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ANSN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Additional SN Missing!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MDTIDN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Updated Device Name Invalid!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMTDup")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Name already exists!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMTSuc")
                        {
                            echo '<div class="alert alert-success" role="alert">Updated manufacturer Name Successfully!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMTMISS")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Name Missing!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMTIDN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Updated manufacturer Name Invalid!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DSS")
                        {
                            echo '<div class="alert alert-success" role="alert">Dev stat change success!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DSA")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device status already active!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DSIA")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device status already inactive!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MSS")
                        {
                            echo '<div class="alert alert-success" role="alert">manufacturer stat change success!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MSA")
                        {
                            echo '<div class="alert alert-danger" role="alert">manufacturer status already active!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MSIA")
                        {
                            echo '<div class="alert alert-danger" role="alert">manufacturer status already inactive!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNS")
                        {
                            echo '<div class="alert alert-success" role="alert">Equipment stat change success!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNA")
                        {
                            echo '<div class="alert alert-danger" role="alert">Equipment status already active!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNIA")
                        {
                            echo '<div class="alert alert-danger" role="alert">Equipment status already inactive!</div>';

                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNMISS")
                        {
                            echo '<div class="alert alert-danger" role="alert">Equipment SN Missing!</div>';

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
                        <label for="exampleValue">New Serial Number:</label>
                        <input type="text" id="newvalue" class="form-control" name="newvalue"/>
                    </div>
					 <div class="form-group">
                        <label for="exampleStatus">Status:</label>
                        <select class="form-control" name="modstatus">
                            <?php
				//lists out status options (active or inactive) to be saved and used later based on user input
                                foreach($stat as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
					
					   <br><br><br><br>

                        <button type="submit" class="btn btn-primary" name="modifydev" value="submit">Modify Device ID</button>
						<button type="submit" class="btn btn-primary" name="modifyman" value="submit">Modify Manufacturer ID</button>
						<button type="submit" class="btn btn-primary" name="modifyser" value="submit">Modify Serial Number</button>
					   <button type="submit" class="btn btn-primary" name="serstatus" value="submit">Modify Serial Number status</button>
					   
					   <br><br>
					   
					   <div class="form-group">
                        <label for="exampleDevice">Device:</label>
                        <select class="form-control" name="newdevice">
                            <?php
				//list out all device types (list received through curl request made to an endpoint). this list option is used by a different function than previous lists
                                foreach($devices as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleManufacturer">Manufacturer:</label>
                        <select class="form-control" name="newmanufacturer">
                            <?php
				//list out all manufacturer types (list received through curl request made to an endpoint). this list option is used by a different function than previous lists
                                foreach($manufacturers as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
					   <div class="form-group">
                        <label for="exampleValue">Updated Value:</label>
                        <input type="text" id="newvalue" class="form-control" name="updatevalue"/>
                    </div>
					<div class="form-group">
                        <label for="exampleStatus">Status:</label>
                        <select class="form-control" name="status">
                            <?php
				//lists out status options (active or inactive). this list option is used by a different function than previous lists
                                foreach($stat as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
					   <br><br><br><br>
					   <button type="submit" class="btn btn-primary" name="viewdev" value="submit">View Device Status</button>
					   <button type="submit" class="btn btn-primary" name="viewman" value="submit">View Manufacturer Status</button>
					   <button type="submit" class="btn btn-primary" name="updatedev" value="submit">Modify Device Type Name</button>
					   <button type="submit" class="btn btn-primary" name="updateman" value="submit">Modify Manufacturer Type Name</button>
					   <button type="submit" class="btn btn-primary" name="devstat" value="submit">Modify Device Status</button>
					   <button type="submit" class="btn btn-primary" name="manstat" value="submit">Modify Manufacturer Status</button>
					   
                   </form>
                    

               </div>
          </div>
     </section>
</body>
</html>

<?php
if (isset($_POST['modifydev']))
    {
	$devarray = array();
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
	$newvalue=trim($_POST['newvalue']);
	
	
	
		
	 
	

						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify a device type for an existing record
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="did=".$device."&sn=".$serialNumber;
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
	
	//error and success messages

	if($paydata[1]=="Invalid or missing serial number."){
							header("Location: modify.php?msg=NSN");
						}
	if($paydata[1]=="Invalid Serial Number."){
							header("Location: modify.php?msg=ISN");
						}
	if($paydata[1]=="Device Modified Successfully"){
							header("Location: modify.php?msg=DMS");
						}
	if($paydata[1]=="Record Not Found."){
							header("Location: modify.php?msg=RNF");
						}
	
		


}
if (isset($_POST['modifyman']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
	$newvalue=trim($_POST['newvalue']);
	
		
       
    	
	
						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used modify manufacturer type for existing record
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="mid=".$manufacturer."&sn=".$serialNumber;
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
	
	//error and success messages

	if($paydata[1]=="Invalid or missing serial number."){
							header("Location: modify.php?msg=NSN");
						}
	if($paydata[1]=="Invalid Serial Number."){
							header("Location: modify.php?msg=ISN");
						}
	if($paydata[1]=="Manufacturer Modified Successfully"){
							header("Location: modify.php?msg=MMS");
						}
	if($paydata[1]=="Record Not Found."){
							header("Location: modify.php?msg=RNF");
						}
	
	
		

}


if (isset($_POST['modifyser']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
	$newvalue=trim($_POST['newvalue']);
	
		
	
		
		
						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify serial number for existing record
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="sn=".$serialNumber."&sntwo=".$newvalue;
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
	
	//error and success messages
	if($paydata[1]=="Invalid or missing serial number."){
							header("Location: modify.php?msg=NSN");
						}
	if($paydata[1]=="Invalid Serial Number."){
							header("Location: modify.php?msg=ISN");
						}
	if($paydata[1]=="Serial Number Modified Successfully"){
							header("Location: modify.php?msg=SMS");
						}
	if($paydata[1]=="Record Not Found."){
							header("Location: modify.php?msg=RNF");
						}	
	if($paydata[1]=="Invalid or missing additional serial number."){
							header("Location: modify.php?msg=ANSN");
						}	
	if($paydata[1]=="Invalid Additional Serial Number."){
							header("Location: modify.php?msg=AISN");
						}	
	
	
	
	
}




if (isset($_POST['updatedev']))
    {
		
        $updatedevice=$_POST['newdevice'];
        $updatemanufacturer=$_POST['newmanufacturer'];
        
	$updatevalue=trim($_POST['updatevalue']);
	
		
		
			
      						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify existing device type
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="did=".$updatedevice."&updatedid=".$updatevalue;
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
				   		
						//error and success messages
						if($paydata[1]=="Device name already exists."){
							header("Location: modify.php?msg=MDTDup");
						}
						if($paydata[1]=="Dev Value Updated Successfully."){
							header("Location: modify.php?msg=MDTSuc");
						}
						if($paydata[1]=="Invalid or missing device name."){
							header("Location: modify.php?msg=MDTMISS");
						}
						if($paydata[1]=="Update Device Invalid Name."){
							header("Location: modify.php?msg=MDTIDN");
						}
						
			
		
}


if (isset($_POST['updateman']))
    {
		
        
        $updatemanufacturer=$_POST['newmanufacturer'];
        
	$updatevalue=trim($_POST['updatevalue']);
	
		
	
        
		    				//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify existing manufacturer types
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="mid=".$updatemanufacturer."&updatemid=".$updatevalue;
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
				   		
						//error and success messages
						if($paydata[1]=="manufacturer name already exists."){
							header("Location: modify.php?msg=MMTDup");
						}
						if($paydata[1]=="Man Value Updated Successfully."){
							header("Location: modify.php?msg=MMTSuc");
						}
						if($paydata[1]=="Invalid or missing manufacturer name."){
							header("Location: modify.php?msg=MMTMISS");
						}
						if($paydata[1]=="Update Manufacturer Invalid Name."){
							header("Location: modify.php?msg=MMTIDN");
						}
	
	
		
}

if (isset($_POST['viewdev']))
    {
	$updatedevice=$_POST['newdevice'];
	
						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to view device status
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="did=".$updatedevice;
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

						//$Vstat is used to hold the requested information, which in this case is the status of the device
						//the following if else decides which messages to display to the user about the device status (active, inactive, or error)
				   		$Vstat=json_decode($paydata[1],true);

						if($Vstat[0]=="inactive"){
							header("Location: modify.php?msg=DIA");
						}else if($Vstat[0]=="active"){
							header("Location: modify.php?msg=ACTD");
						}else{
							header("Location: modify.php?msg=VIEWDEVERROR");
						}
}
if (isset($_POST['viewman']))
    {
	$updateman=$_POST['newmanufacturer'];
	
						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to view manufacturer status
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="mid=".$updateman;
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

						//$Vstat is used to hold the requested information, which in this case is the status of the manufacturer
						//the following if else decides which messages to display to the user about the manufacturer status (active, inactive, or error)
				   		$Vstat=json_decode($paydata[1],true);
						if($Vstat[0]=="inactive"){
							header("Location: modify.php?msg=MIA");
						}else if($Vstat[0]=="active"){
							header("Location: modify.php?msg=ACTM");
						}else{
							header("Location: modify.php?msg=VIEWMANERROR");
						}
}



if (isset($_POST['devstat']))
    {
		
        
        $updatedevice=$_POST['newdevice'];
        
	$stat=$_POST['status'];
	
		
	
        
		    				//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify device status
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="did=".$updatedevice."&stat=".$stat;
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
				   		
						//error and success messages
						
						if($paydata[1]=="Dev status Updated Successfully."){
							header("Location: modify.php?msg=DSS");
						}
						if($paydata[1]=="Device inactive status already set."){
							header("Location: modify.php?msg=DSIA");
						}
						if($paydata[1]=="Device active status already set."){
							header("Location: modify.php?msg=DSA");
						}
						
		
}
if (isset($_POST['manstat']))
    {
		
        
        $updatemanufacturer=$_POST['newmanufacturer'];
        
	$stat=$_POST['status'];
	
		
	
        
		    				//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify manufacturer status
                        			$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="mid=".$updatemanufacturer."&stat=".$stat;
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
				   		
						//error and success messages
						
						if($paydata[1]=="manufacturer status Updated Successfully."){
							header("Location: modify.php?msg=MSS");
						}
						if($paydata[1]=="manufacturer inactive status already set."){
							header("Location: modify.php?msg=MSIA");
						}
						if($paydata[1]=="manufacturer active status already set."){
							header("Location: modify.php?msg=MSA");
						}
		
}


if (isset($_POST['serstatus'])){
	$stat=$_POST['modstatus'];
	
	
	$serialNumber=trim($_POST['serialnumber']);
		
		
						//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
						//originally used to modify serial number status (status of entire record)
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
				   		
						//error and success messages
						if($paydata[1]=="status request successfull."){
							header("Location: modify.php?msg=SNS");
						}
						if($paydata[1]=="sn inactive status already set."){
							header("Location: modify.php?msg=SNIA");
						}
						if($paydata[1]=="sn active status already set."){
							header("Location: modify.php?msg=SNA");
						}
						if($paydata[1]=="Invalid or missing serial number."){
							header("Location: modify.php?msg=SNMISS");
						}
	
}


?>