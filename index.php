<?php 
//Initialize variable and Index to prevent error in the application
$note=""; if (!isset($_REQUEST['action'])){$_REQUEST['action']='';	} 

//Enter here to view files sent to successtar
if ($_REQUEST['action']=='receive'){

	//Scan sent directory to view all files available
	$pend=scandir("sent");

	//Test if there is/are file(s) in the directory
	if(COUNT($pend)>2 ){
		$pender='';
		$ii=1;

		//Loop through all the files available and display later to the user
		for($i=2;$i<COUNT($pend);$i++){
			$uploadsname=ucwords(strtolower(str_replace('-',' ',str_replace('_',' ',$pend[$i]))));
			$pender=$pender.'<li style="list-style-type:none; padding:5px; font-size:large" ><a href="sent/'.$pend[$i].'" download title="Download '.$uploadsname.'" style="text-decoration:none;  color:#000000;">'.$ii.'. '.$uploadsname.'</a> </li>';
			$ii++;		
		}	
		$insert='<ul style="display:block; text-align:left;margin: 5px; margin-left:12%">'.$pender.'</ul>';	}
	else {
		$insert='<span style="font-size:large"> Now new file available, contact successtar.</span><br/>';		
	}

	$insert=$insert.'<br/><h2><a href="index.php" title="Back to Home" style="text-decoration:none; padding:5px 10px; margin:15px; color:#0000FF; border-radius:10px;border:2px solid #0000FF">Home</a></h2>';
}
//If the request is to send file to successtar or everyone, enter here
elseif ($_REQUEST['action']=='send'){

	//Test if file is uploaded here
	if (!isset($_FILES["file"]["name"])){
		$_FILES["file"]["name"]='';	
	} 
	//If file is uploaded, enter here to proceed
	if ($_FILES["file"]["name"]!=""){ 
		//Test for error in uploading the files
		if ($_FILES["file"]["error"] > 0)   { 
			$note= $_FILES["file"]["error"] . "<br/> Unable to send file <br />";   }
		else {
			//If no error, check if the file is to be sent to successtar or everyone to know the appropriate folder to save file to
			if ($_POST['to']==="successtar"){
				move_uploaded_file($_FILES["file"]["tmp_name"],"received/".$_FILES["file"]["name"]);  
				$note=ucfirst($_FILES["file"]["name"])." Sent to Successtar Successfully";	}
			elseif ($_POST['to']==="all") {
				move_uploaded_file($_FILES["file"]["tmp_name"],"sent/".$_FILES["file"]["name"]);  
				$note=ucfirst($_FILES["file"]["name"])." Sent to Everyone Successfully";
			}
		}
	}

	$insert='<br/>'.$note.'<br/><br/><form action="index.php"  method="post" enctype="multipart/form-data"> <input type="hidden" name="action" value="send"/><input type="file" name="file"/>  <p> <input type="radio" name="to" value="successtar" checked=checked /> Share with Successtar</p> <p><input type="radio" name="to" value="all" /> Share with  Everyone </p><input type="submit" value="Send" style=" font-size:large;padding:5px 12px; margin:15px; color:#0000FF; border-radius:10px;border:2px solid #0000FF"/> </form> <br/><h2><a href="index.php" title="Back to Home" style="text-decoration:none; padding:5px 10px; margin:15px; color:#0000FF; border-radius:10px;border:2px solid #0000FF">Home</a></h2>';
}
else{
	//Load home page if no request sent
	$insert='<h2><br/><br/><a href="index.php?action=send" title="Send File to Successtar" style="text-decoration:none; padding:5px 10px; margin:15px; color:#0000FF; border-radius:10px;border:2px solid #0000FF">Send File</a></h2><br/><br/>
	<h2><a href="index.php?action=receive" title="Receive File from Successtar" style="text-decoration:none; padding:5px 10px; margin:15px; color:#0000FF; border-radius:10px;border:2px solid #0000FF">Receive File</a></h2>';
}

?>

<html><head><title> Successtar File Sharing</title> <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" /> </head> <body><center><h1>Welcome to Successtar File Sharing Centre</h1> <?php echo $insert; ?></center></body></html>
