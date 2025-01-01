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
                    <a href="#" class="navbar-brand">Add New Equipment</a>
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
						//originally used to request and list out valid devices
						$ch=curl_init([placeholder for site]/where/endpoints/are/file");
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
				   		
				   		//originally used to request and list valid manufacturers
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
			
			//conditionals used to display to the user possible errors that have occurred OR to display a successful action
				   
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="IDN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Name Invalid!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DAE")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Name Already Exists!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DAS")
                        {
                            echo '<div class="alert alert-success" role="alert">Device Added Successfully!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DMISS")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Name Missing!</div>';
                        }
				   
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="IMN")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Name Invalid!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MAE")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Name Already Exists!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MAS")
                        {
                            echo '<div class="alert alert-success" role="alert">Manufacturer Added Successfully!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="MMISS")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer Name Missing!</div>';
                        }
				   		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ADDSUC")
                        {
                            echo '<div class="alert alert-success" role="alert">Equipment Added Successfully!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNINVALID")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number invalid!</div>';
                        }
				   if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SNMISSING")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number Missing!</div>';
                        }
				   
                   
                   ?>
                    <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleDevice">Device:</label>
                        <select class="form-control" name="device">
                            <?php
				//list of devices obtained through curl request sent to specific api endpoint
                                foreach($devices as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleManufacturer">Manufacturer:</label>
                        <select class="form-control" name="manufacturer">
                            <?php
				//list of manufacturers obtained through curl request sent to specific api endpoint
                                foreach($manufacturers as $key=>$value)
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                            ?>
                        </select>
                    
                    <div class="form-group">
                        <label for="exampleSerial">Serial Number:</label>
                        <input type="text" class="form-control" id="serialInput" name="serialnumber">
                    </div>
                        <button type="submit" class="btn btn-primary" name="addsubmit" value="submit">Add Equipment</button>
						<div>
						<h2>Adding new equipment type?</h2>
						</div>
						<div class="form-group">
                        <label for="exampleDevice">New Device to Add:</label>
                        <input type="text" id="newdevice" class="form-control" name="newdevice"/>
                                 
                    </div>
                    <div class="form-group">
                        <label for="exampleManufacturer">New Manufacturer to Add:</label>
                        <input type="text" id="newmanufacturer" class="form-control" name="newmanufacturer"/>
                    </div>
							<button type="submit" class="btn btn-primary" name="adddevsubmit" value="submit">Add New Device Type</button>
						<button type="submit" class="btn btn-primary" name="addmansubmit" value="submit">Add New Manufacturer Type</button>
						</div>
                   </form>
               </div>
          </div>
     </section>
</body>
</html>
<?php
    if (isset($_POST['addsubmit']))
    {
		
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serialNumber=trim($_POST['serialnumber']);
		
		
			//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
        			//originally used to add equipment to a database to keep a record (equiptment in this context has a device type, manufacturer type, and a serial number)
						$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="did=".$device."&mid=".$manufacturer."&sn=".$serialNumber."";
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
	
						//error or success messages based on returned info from the endpoint

						if($paydata[1]=="Equipment Added Successfully."){
							header("Location: add.php?msg=ADDSUC");
						}
						if($paydata[1]=="Invalid Serial Number."){
							header("Location: add.php?msg=SNINVALID");
						}
						if($paydata[1]=="Invalid or missing serial number."){
							header("Location: add.php?msg=SNMISSING");
						}

			
    	
	}



if (isset($_POST['adddevsubmit']))
    {
		
        $newdevice=$_POST['newdevice'];
        $status="active";
	
			//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
				//originally used to add a new device type possibility for new equipment additions
        					$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="dname=".$newdevice;
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
	
						//error or success messages based on returned info from the endpoint

						if($paydata[1]=="Invalid Device Name."){
							header("Location: add.php?msg=IDN");
						}
						if($paydata[1]=="Device Added Successfully."){
							header("Location: add.php?msg=DAS");
						}
						if($paydata[1]=="DEVICE ALREADY EXISTS."){
							header("Location: add.php?msg=DAE");
						}
						if($paydata[1]=="Invalid or missing device."){
							header("Location: add.php?msg=DMISS");
						}
						
        
			
    
}
if (isset($_POST['addmansubmit']))
    {
		
        $status="active";
        $newmanufacturer=$_POST['newmanufacturer'];
        
				//note: server is no longer active so some lines have placeholders, site address and file architecture must be modified based on what is being used
					//originally used to add new manufacturer types possibilities for new equipment additions
						$ch=curl_init("[placeholder for site]/where/endpoints/are/file");
						$data="mname=".$newmanufacturer;
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
	
						//error or success messages based on returned info from the endpoint

						if($paydata[1]=="Invalid manufacturer Name."){
							header("Location: add.php?msg=IMN");
						}
						if($paydata[1]=="Manufacturer Added Successfully."){
							header("Location: add.php?msg=MAS");
						}
						if($paydata[1]=="Manufacturer already exists."){
							header("Location: add.php?msg=MAE");
						}
						if($paydata[1]=="Invalid or missing manufacturer."){
							header("Location: add.php?msg=MMISS");
						}
			
        
    
}
?>