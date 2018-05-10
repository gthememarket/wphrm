<?php
if(!class_exists('Attendance')){
	
class Attendance{
	public function __construct(){
		add_action("template_redirect",array($this,"redirectMethod"),1);
	}
	
	public function redirectMethod()
	{
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "enroll")
		{
			$response = $this->check_enroll($_REQUEST);
			if(is_array($response))
			{				
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		
		//for user list
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "userlist")	{			
			$response = $this->check_user_list($_REQUEST);			
			if(is_array($response))	{				
				header('HTTP/1.1 200 OK');
				$json = json_encode($response);
				$json = str_replace("\/","/",$json);
				echo $json;
				//echo json_encode($response);				
			}
			else{
				header("HTTP/1.1 401 Unauthorized");
			} 
			die();
		}
		
		
		
		//for user file upload...
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "upload"){			
			$response = $this->user_file_upload($_FILES);			
			if(is_array($response)) {				
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else{
				header("HTTP/1.1 401 Unauthorized");
			} 
			die();
		}
		
		
		//for delete user thumb...
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "delete"){
			$response = $this->delete_user($_REQUEST);
			if(is_array($response))	{				
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		
		
		
		
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "dayin") {
			$response = $this->dayin($_REQUEST);
			if(is_array($response))
			{
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "lunchstart")
		{
			$response = $this->lunchstart($_REQUEST);
			if(is_array($response))
			{
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "lunchend")
		{
			$response = $this->lunchend($_REQUEST);
			if(is_array($response))
			{
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if(isset($_REQUEST["hrmgt-json-api"]) && $_REQUEST["hrmgt-json-api"] == "dayout")
		{
			$response = $this->dayout($_REQUEST);
			if(is_array($response))
			{
				header('HTTP/1.1 200 OK');
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
	}
	
	public function check_enroll($request)
	{   
		if(isset($request["id"]) || $request["id"] != "")
		{
			$user_id = $request["id"];
			$userdata = get_userdata($user_id);
			if($userdata === false)
			{
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]= "";
			}
			else{
				$data["id"] = $user_id;
				$data["first_name"] = $userdata->first_name;
				$data["last_name"] = $userdata->last_name;
				$data["email"] = $userdata->user_email;
				
				$response["error"]="";
				$response["status"]="1";
				$response["result"]=$data;
			}
			
		}else
		{
			$response["error"]="Sorry,No User Found.";
			$response["status"]="5";
			$response["result"]="";
		}
		
		return $response;
	}
	
	
	
	
	
	// for user list
	public function check_user_list($request){  
			
		if(isset($request["hrmgt-json-api"]) || $request["hrmgt-json-api"] != ""){		
			$args = array('role'=> 'employee');
			
			$userdata = get_users($args);
						
			if($userdata === false)
			{
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]= "";
			}
			else{
				$data= array();
				$i=0;
				foreach($userdata as $key=>$val){					
					$data[$i]["id"] = $val->ID;
					$data[$i]["first_name"] = $val->first_name;
					$data[$i]["last_name"] = $val->last_name;
					$data[$i]["email"] = $val->user_email;	
									
					 $file_path = HRMS_PLUGIN_URL . "/assets/thumb/TemplateFP_{$val->ID}_finger0_1.pkc";					
					
					$file_dir = HRMS_PLUGIN_DIR . "/assets/thumb/TemplateFP_{$val->ID}_finger0_1.pkc";					
					if(file_exists($file_dir))	{						
						$data[$i]["pic"] =$file_path;
					}else{						
						$data[$i]["pic"] = "";
					} 					
					$i++;
				}
				
				$response["error"]="";
				$response["status"]="1";
				$response["result"]=$data;
				
				
			} 
			
		}else
		{
			$response["error"]="Sorry,No User Found .";
			$response["status"]="5";
			$response["result"]="";
		}
		
		return $response;
	}
	
	
	
	// for user file upload
	public function user_file_upload ($file){  
			
		if(isset($file['pic']['name'])){		
			$file = $file["pic"];
			$img_name = $file["name"]; 
			if($img_name != ""){
				$tmp_name = $file["tmp_name"];				
				if(move_uploaded_file($tmp_name,HRMS_PLUGIN_DIR . "/assets/thumb/".$img_name)){
					$response["error"]="";
					$response["status"]="1";
					$response["result"]="File Uploaded successfully";
				}
				else{
					$response["error"]="Error!File could not uploaded.Try again.";
					$response["status"]="12";
					$response["result"]="";
				}
				
			}
			
		}
		else {
			$response["error"]="Sorry,No file found .";
			$response["status"]="13";
			$response["result"]="";
		}		
		return $response;
	}
	
	// for delete user
	public function delete_user($data){  
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
			$userid = $_REQUEST['id'];
			$file =  HRMS_PLUGIN_DIR ."/assets/thumb/TemplateFP_{$userid}_finger0_1.pkc";			
			//print $file =  HRMS_PLUGIN_DIR ."/assets/thumb/TemplateFP_69_finger0_1.pkc";			
			if(file_exists($file)){
				unlink($file);
			}
			$response["error"]="";
			$response["status"]="1";
			$response["result"]= "User thumb entry deleted successfully";
		}
		else{			
			$response["error"] = "No parameter data provided";
			$response["status"] = "6";
			$response["result"] = "";
		}
		//TemplateFP_2_finger0_1		
		return $response;
	}
	
	
	
	
	
	public function dayin($request)	{
		$HrmgtAttendanceDetails= new HrmgtAttendanceDetails();		
		date_default_timezone_set('Asia/Kolkata');
		if($request["id"] != ""){			
			$user_id = $request["id"];
			$userdata = get_userdata($user_id);
			if($userdata === false)	{
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]="";
			}
			else{
				$punch_in['employee_id'] =$request["id"];
				$punch_in['attendance_date'] = date("Y-m-d");
				$punch_in['signin_time'] = date("H:i:s");		
				
				global $wpdb;			
				$tbl = $wpdb->prefix . "hrmgt_attendance";
				
				$count = $wpdb->get_var("SELECT COUNT(*) FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'");
				if($count >= 1){
					$day_check = $wpdb->get_row("SELECT * FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'",ARRAY_A);
					if($day_check["signout_time"] != "")
					{
						$response["error"]="Sorry,your day already ended.";
						$response["status"]="4";
						$response["result"]="";
						return $response;
					}
					else {					
						$response["error"]="Sorry,your day already started.";
						$response["status"]="14";
						$response["result"]="";						
					}
				}
				else{	
					$attendanceDay =date('n',date("d"));					
					$month= date('n',strtotime(date('Y-m-d')));					
					$year =  date('Y');
				
					$result = $HrmgtAttendanceDetails->hrmgt_save_attendance_details($request["id"],$attendanceDay,$month,$year,'dayin');					
					$result = $wpdb->insert( $tbl, $punch_in );	
					if($result != false)
					{
						$message["message"] = "Day Started Successfuly.";
						$response["error"]="";
						$response["status"]="1";
						$response["result"]="Day Started Successfuly.";
					}
				}
			}
			
		}
		else{
			$response["error"]="Sorry,No User Found.";
			$response["status"]="5";
			$response["result"]="";
		}
		return $response;
	}
	
	public function lunchstart($request){
		$HrmgtAttendance= new HrmgtAttendance();
		date_default_timezone_set('Asia/Kolkata');
		if($request["id"] != "")
		{
			$user_id = $request["id"];
			$userdata = get_userdata($user_id);
			if($userdata === false)
			{
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]="";
				return $response;
			}
			else
			{				
				global $wpdb;			
				$tbl = $wpdb->prefix . "hrmgt_attendance";
				
				$count = $wpdb->get_var("SELECT COUNT(*) FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'");
				if($count == 0)
				{
					$response["error"]="Sorry,your day not started yet.";
					$response["status"]="3";
					$response["result"]="";
					return $response;
				}
				else
				{
					$data = $wpdb->get_row("SELECT * FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'",ARRAY_A);
					if($data["signout_time"] != "")
					{
						$response["error"]="Sorry,your day already ended.";
						$response["status"]="4";
						$response["result"]="";
						return $response;
					}
					else if($data["lunch_start_time"] != "")
					{
						$response["error"]="Sorry,your lunch already started.";
						$response["status"]="7";
						$response["result"]="";
						return $response;					
					}
					else if($data["lunch_end_time"] != "")
					{
						$response["error"]="Sorry,your lunch already taken.";
						$response["status"]="8";
						$response["result"]="";
						return $response;					
					}
					else
					{						
						$punch_in['lunch_start_time'] = date("H:i:s");
						$whereid['employee_id'] = $request['id'];
						$whereid['attendance_date'] = date("Y-m-d");					
						$result = $wpdb->update($tbl,$punch_in,$whereid);
						if($result != false)
						{
							$message["message"] = "Lunch started successfully.";
							$response["error"]="";
							$response["status"]="1";
							$response["result"]="Lunch started successfully.";	
							return $response;
						}
					}						
				}				
			}
		}
		
	}
	
	public function lunchend($request)
	{
		$HrmgtAttendance= new HrmgtAttendance();
		date_default_timezone_set('Asia/Kolkata');
		if($request["id"] != "")
		{
			$user_id = $request["id"];
			$userdata = get_userdata($user_id);
			if($userdata === false)
			{
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]="";
				return $response;
			}
			else
			{				
				global $wpdb;			
				$tbl = $wpdb->prefix . "hrmgt_attendance";
				
				$count = $wpdb->get_var("SELECT COUNT(*) FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'");
				
				
				if($count == 0)
				{
					$response["error"]="Sorry,your day not started yet.";
					$response["status"]="3";
					$response["result"]="";
					return $response;
				}
				else
				{
					$data = $wpdb->get_row("SELECT * FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'",ARRAY_A);
					if($data["signout_time"] != "")
					{
						$response["error"]="Sorry,your day already ended.";
						$response["status"]="0";
						$response["result"]="";
						return $response;
					}
					else if($data["lunch_start_time"] == "")
					{
						$response["error"]="Sorry,your lunch not started yet.";
						$response["status"]="9";
						$response["result"]="";
						return $response;					
					}
					else if($data["lunch_end_time"] != "")
					{
						$response["error"]="Sorry,your lunch already taken.";
						$response["status"]="8";
						$response["result"]="";
						return $response;					
					}
					else
					{
						$curr_time = date("H:i:s");
						$lunchhours = $this->hrmgt_get_time_difference($data["lunch_start_time"],$curr_time);
						$punch_in['lunch_end_time'] = $curr_time;
						$punch_in['lunch_hourse'] = $lunchhours;
						
						$whereid['employee_id'] = $request['id'];
						$whereid['attendance_date'] = date("Y-m-d");
						//$result = $HrmgtAttendance->hrmgt_add_attendance($punch_in);
						$result = $wpdb->update($tbl,$punch_in,$whereid);
						if($result != false)
						{
							$message["message"] = "Lunch ended successfully.";
							$response["error"]="";
							$response["status"]="1";
							$response["workhours"]=$lunchhours;
							$response["result"]="Lunch ended successfully.";							
							return $response;
						}
					}
				}				
			}
		}
	}
	
	public function dayout($request){
		$HrmgtAttendanceDetails = new HrmgtAttendanceDetails();
		date_default_timezone_set('Asia/Kolkata');
		if($request["id"] != ""){
			$user_id = $request["id"];
			$userdata = get_userdata($user_id);
			if($userdata === false){
				$response["error"]="Sorry,No User Found.";
				$response["status"]="5";
				$response["result"]="";
				return $response;
			}
			else{				
				global $wpdb;			
				$tbl = $wpdb->prefix . "hrmgt_attendance";
				$curr_month = date('n');
				$curr_year = date('Y');
				$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
				$AttDetails = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=".$request["id"]." AND month=$curr_month AND year=$curr_year");
				
				
				$count = $wpdb->get_var("SELECT COUNT(*) FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'");
				
				$today_racord = $wpdb->get_row("SELECT * FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'");
				
				if($count == 0)	{
					$response["error"]="Sorry,your day not started yet.";
					$response["status"]="3";
					$response["result"]="";
					return $response;
				}
				else {
					$data = $wpdb->get_row("SELECT * FROM {$tbl} WHERE employee_id = {$request["id"]} and attendance_date = '".date('Y-m-d')."'",ARRAY_A);
					if($data["signout_time"] != ""){
						$response["error"]="Sorry,your day already ended.";
						$response["status"]="4";
						$response["result"]="";
						return $response;
					}
					else if($data["lunch_start_time"] == "" && $data["lunch_end_time"] == ""){
						$curr_time = date("H:i:s");
						$workhours = $this->hrmgt_get_time_difference($data["signin_time"],$curr_time);
						//$workhours ="09:20"; // for testing
						if(empty($today_racord->lunch_end_time)){
							$punch_in['lunch_end_time']="00:00";
						}
						else{
							$punch_in['lunch_end_time']=$today_racord->lunch_end_time;
						}
						
						if(empty($today_racord->lunch_start_time)){
							$punch_in['lunch_start_time']="00:00";
						}
						else{
							$punch_in['lunch_start_time']=$today_racord->lunch_start_time;
						}
						
						if(empty($today_racord->lunch_hourse)){
							$punch_in['lunch_hourse']="00:00";
						}
						else{
							$punch_in['lunch_hourse']=$today_racord->lunch_hourse;
						}			
						$punch_in['signout_time'] = $curr_time;
						$punch_in['working_hours'] = $workhours;															
						$punch_in['employee_id'] = $request['id'];						
						$punch_in['attendance_date'] = date("Y-m-d");
						$whereid['employee_id'] = $request['id'];						
						$whereid['attendance_date'] = date("Y-m-d");
						
						$attendanceDay = date('j',strtotime(date("Y-m-d")));
						$month =  date('n',strtotime(date("Y-m-d")));
						$year =  date('Y',strtotime(date("Y-m-d")));			
						$resultdata = $HrmgtAttendanceDetails->hrmgt_save_attendance_details($request['id'],$attendanceDay,$month,$year,'dayout',$workhours);
						
					
						$result = $wpdb->update($tbl,$punch_in,$whereid);
						
						if($result != false)
						{
							$message["message"] = "Day ended successfully.";
							$response["error"]="";
							$response["status"]="1";
							$response["workhours"]=$workhours;
							$response["result"]="Day ended successfully.";	
							return $response;
						}
					}
					else if($data["lunch_start_time"] != "" && $data["lunch_end_time"] != ""){
						$curr_time = date("H:i:s");
						$totalhours=0;
						$totalhours = $this->hrmgt_get_time_difference($data["signin_time"],$curr_time);					
						$working_hours = $this->hrmgt_get_working_hours($totalhours,$data['lunch_hourse']);						
						$punch_in['signout_time'] = $curr_time;
						$punch_in['working_hours'] = $working_hours;
						
						$whereid['employee_id'] = $request['id'];
						$whereid['attendance_date'] = date("Y-m-d");
						$punch_in['employee_id'] = $request['id'];
						$punch_in['attendance_date'] = date("Y-m-d");
						
						
						$month =  date('n',strtotime(date("Y-m-d")));
						$year =  date('Y',strtotime(date("Y-m-d")));			
						$attendanceDay =  date('j',strtotime(date("Y-m-d")));
						$AttDate = $year.'-'.$month.'-'.$attendanceDay;
						//$result = $wpdb->update($tbl,$punch_in,$whereid);
						//$dayStatus = $HrmgtAttendanceDetails->WorkTimeStatus(strtotime('9:15')); //for testing
						
						$dayStatus = $HrmgtAttendanceDetails->WorkTimeStatus(strtotime($working_hours),$AttDate,$attendanceDay);
						//$dayStatus ="A"; // for testing
						$AtteInfo['manual']=0;
						$AtteInfo['status']=$dayStatus;
						$AtteInfo['attendancedetailid']=$AttDetails->id;
						$AtteInfo['data']=$request['id'].'/'.$attendanceDay.'/'.$month.'/'.$year;					
						$HrmgtAttendanceDetails->update_attendance_details($AtteInfo);						
						$result = $wpdb->update($tbl,$punch_in,$whereid);
						if($result != false) {
							$message["message"] = "Day ended successfully.";
							$response["error"]="";
							$response["status"]="1";
							$response["workhours"]=$working_hours;							
							$response["result"]="Day ended successfully.";	
							return $response;
						}
					}
					else {
						$response["error"]="Sorry,Finish your lunch first.";
						$response["status"]="10";
						$response["result"]="";
						return $response;						
					}
				}
			}
		}
	}
	
	private function hrmgt_get_time_difference($start,$end)	{		
		$datetime1 =  new DateTime($start);
		$datetime2 =  new DateTime($end);
		$interval = $datetime1->diff($datetime2);	
		$hours_diff =  $interval->format('%h').":".$interval->format('%i');		
		return $hours_diff;
	}	
	
	
	private function hrmgt_get_working_hours($totalhours,$lunchhouse){	
		$lunchdata = array();
		$lunchdata = explode(':',$lunchhouse);
		$date = date($totalhours);
		
		$time = strtotime($date);
		$hour_minut =0;
		$minut=0;
		if($lunchdata[0]=="0"){
			$minut = $lunchdata[1];
		} 
		else {	
			$minut = $lunchdata[1];
			$hour_minut =($lunchdata[0] * 60);
		}
		$total_minut=$minut + $hour_minut;
		$time = $time - ($total_minut * 60);
		$date = date("H:i", $time);
		return $date;
	}
	
	
}
	
}
