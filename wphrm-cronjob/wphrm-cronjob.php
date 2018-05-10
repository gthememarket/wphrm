<?php
$servername = "localhost";
//$username = "root";
$username = "joomlacu_ss_d98d";
$password="POKKitYztFhe";
//$password="";
//$dbname="das_wphr";
$dbname =DB_NAME; 

//$_SERVER[REQUEST_URI]
 
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Database Connection Fails");
if($conn)
{
	
	$tbl_usermeta = "wp_mnbt_usermeta";
	$meta_key ="birth_date";
	//$meta_value =  date("m/d");
	$meta_value = "07/29";
	
	 $sql = "SELECT * FROM $tbl_usermeta WHERE meta_key='$meta_key' AND meta_value LIKE '$meta_value%'";	
	
	$result = mysqli_query($conn, $sql);
	if($result)
	{		
		
		if(mysqli_num_rows($result) > 0)
		{			
			while($row = mysqli_fetch_assoc($result))
			{

				$tbl_user = "wp_mnbt_users";
				$user_id = $row['user_id'];							
				$user_data_q = "SELECT * FROM $tbl_user WHERE ID='$user_id'";				
				$user_data_result = mysqli_query($conn, $user_data_q);				
				while($user_data_row = mysqli_fetch_assoc($user_data_result))
				{
					 $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http")."://hr.dasinfomedia.com/wp-content/plugins/wphrm/assets/images/birthday.gif";
					//$actual_link = "http://hr.dasinfomedia.com/";
					$name = $user_data_row['display_name'];
					$subject = "Happy Birthday";
					$messege = "<p><img src='$actual_link'> <br> Hello <strong>$name</strong>\r\n  Wishing  you the beauty of the perfect day.\r\n the laughter of a happy heart the joy of being with people you love\r\n\r\n
					</p><h1>Happy Bithday!</h1>";
					$to = $user_data_row['user_email'];
					$to = "meru@dasinfomedia.com";					
					$mail = hmgt_send_mail($to,$subject,$messege);
				}
			}
		}
	}	
} 
?>