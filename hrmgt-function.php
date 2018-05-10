<?php 
add_action( 'wp_ajax_hrmgt_verify_pkey', 'hrmgt_verify_pkey');
function hrmgt_is_cmgtpage()
{
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "hrmgt-");	
	
	if($pos !== false)			
	{
		return true;
	}
	return false;
}

/* check server live */
function hrmgt_chekserver($server_name)
{
	if($server_name == 'localhost')
	{
		return true;
	}		
}
function hrmgt_check_ourserver()
{
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	//$api_server = '192.168.1.22';
	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=hrmgt-hr_system';
	if (!$fp)
        return false; /*server down*/
	else
        return true; /*Server up*/
}
/*Check is_verify*/
function hrmgt_check_verify_or_not($result)
{		
	$server_name = $_SERVER['SERVER_NAME'];
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "hrmgt-");	
	if($pos !== false)			
	{ 	 
		if($server_name == 'localhost')
		{
			return true;
		}
		else
		{ 
			if($result == '0')
			{
				return true;
			}
		}	
		return false;
	}	
}

function hrmgt_check_productkey($domain_name,$licence_key,$email)
{	
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	//$api_server = '192.168.1.22';
	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=hrmgt-hr_system';
	if (!$fp)
              $server_rerror = 'Down';
        else
              $server_rerror = "up";
	if($server_rerror == "up")
	{
	// $url = 'http://192.168.1.22/php/test/index.php';
	$url = 'http://license.dasinfomedia.com/index.php';
	$fields = 'result=2&domain='.$domain_name.'&licence_key='.$licence_key.'&email='.$email.'&item_name=wphrm';
	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);

	//execute post
	$result = curl_exec($ch);
	
	curl_close($ch);
	return $result;
	}
	else
	{
		return '3';
	}		
}




function hrmgt_verify_pkey()
{
	//$api_server = '192.168.1.22';
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	$fp = fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=hrmgt-hr_system';
	if (!$fp)
        $server_rerror = 'Down';
    else
        $server_rerror = "up";
	
	if($server_rerror == "up")
	{
		$domain_name	=	 $_SERVER['SERVER_NAME'];
		$licence_key 	= 	$_REQUEST['licence_key'];
		$email 	= 	$_REQUEST['enter_email'];
		$data['domain_name']	= 	$domain_name;
		$data['licence_key']	= 	$licence_key;
		$data['enter_email']	= 	$email;

		//$verify_result = amgt_submit_setupform($data);
		$result 	= 	hrmgt_check_productkey($domain_name,$licence_key,$email);
		if($result == '1')
		{
			$message = 'Please provide correct Envato purchase key.';
				$_SESSION['hrmgt_verify'] = '1';
		}
		elseif($result == '2')
		{
			$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@dasinfomedia.com ';
				$_SESSION['hrmgt_verify'] = '2';
		}
		elseif($result == '3')
		{
			$message = 'There seems to be some problem please try after sometime or contact us on sales@dasinfomedia.com';
				$_SESSION['hrmgt_verify'] = '3';
		}
		elseif($result == '4')
		{
			$message = 'Please provide correct Envato purchase key for this plugin.';
				$_SESSION['hrmgt_verify'] = '4';
		}
		else
		{
			update_option('domain_name',$domain_name,true);
			update_option('licence_key',$licence_key,true);
			update_option('hrmgt_setup_email',$email,true);
			$message = 'Success fully register';
				$_SESSION['hrmgt_verify'] = '0';
		}	
		$result_array = array('message'=>$message,'hrmgt_verify'=>$_SESSION['hrmgt_verify'],'location_url'=>$location_url);
		echo json_encode($result_array);
	}
	else
	{
		$message 	= 	'Server is down Please wait some time';
		$_SESSION['hrmgt_verify'] 	= 	'3';
		$result_array = array('message'=>$message,'hrmgt_verify'=>$_SESSION['hrmgt_verify'],'location_url'=>$location_url);
		echo json_encode($result_array);
	}
	die();
}


function hrmgt_get_user_role($user_id)
{
	$user = new WP_User( $user_id );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) 
	{
		foreach ( $user->roles as $role )
			return $role;
	}
}
function object_to_array($object)
{
    return (array) $object;
}

function hrmgt_travel_destinations()
{
	return $destinations=array('By Car','By Bus','By Train','By Taxi','By Rental Car');
}

function hrmgt_complaint_status()
{
	return $status=array("Requested","Pending","Resolved");
}

function hrmgt_arrangement_type()
{
	return $arrangement_type=array('Personal Arrangement','Hotel','Guest House','Motel','AirBnB');
}

function hrmgt_get_display_name($id)
{	
	if($id)
	{
		$user=get_userdata($id);
			//var_dump($user);
		return $user->display_name;
	}
}

function hrmgt_get_emailid_byuser_id($id)
{
	if (!$user = get_userdata($id))
		return false;
	return $user->data->user_email;
}

function hrmgt_get_department_name($id)
{
	$obj_department=new HrmgtDepartment;
	$department = $obj_department->hrmgt_get_single_department($id);
		if(empty($department->department_name)){
			$department->department_name ="No Department";
		}
		else
		{
			$department->department_name;
		}
		return $department->department_name;	

}

function hrmgt_get_job_title($id)
{
	$obj_requirements=new HrmgtRequirements;
	$result = $obj_requirements->hrmgt_get_single_posted_job($id);
	return $result->job_title;
}

function hrmgt_get_project_title($id)
{
	$obj_project=new HrmgtProject();
	$result = $obj_project->hrmgt_get_single_project($id);
	return $result->project_title;
}

function hrmgt_leave_duration_label($id)
{
	$lable="";
	if($id=='half_day')
		$lable="Half Day";
	if($id=='full_day')
		$lable="Full Day";
	if($id=='more_then_day')
		$lable="More Then One Day";
	return $lable;
	
}

function hrmgt_change_dateformat($date)
{
	return mysql2date(get_option('date_format'),$date);
}

function hrmgt_get_time_difference($start,$end)
{
	$datetime1 =  new DateTime($start);
	$datetime2 =  new DateTime($end);
	$interval = $datetime1->diff($datetime2);	
	$hours_diff =  $interval->format('%h').":".$interval->format('%i');
	return $hours_diff;
}


function hrmgt_get_working_hours($totalhours,$lunchhouse)
{

	$lunchdata = array();
	$lunchdata = explode(':',$lunchhouse);
	$date = date($totalhours);
		

	$time = strtotime($date);
	$hour_minut =0;
	$minut=0;
		
	if($lunchdata[0]=="0")
	{
		$minut = $lunchdata[1];			
	} 
	else 
	{	
		$minut = isset($lunchdata[1])?$lunchdata[1]:'';			
		$hour_minut =($lunchdata[0] * 60);
	}
				
	$total_minut=$minut + $hour_minut;	
	$time = $time - ($total_minut * 60);	
	$date = date("H:i", $time);
	return $date;
}
	

function hrmgt_blood_group()
{
	return $blood_group=array('O+','O-','A+','A-','B+','B-','AB+','AB-');
}
function hrmgt_get_remote_file($url, $timeout = 30)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return ($file_contents) ? $file_contents : FALSE;
}

function hrmgt_get_country_phonecode($country_name)
{
	$url = plugins_url( 'countrylist.xml', __FILE__ );
	$xml =simplexml_load_string(hrmgt_get_remote_file($url));
	
	foreach($xml as $country)
	{
		if($country_name == $country->name)
			return $country->phoneCode;

	}
}
function hrmgt_load_documets($file,$type,$nm) 
{
		
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
	$document_dir .= '/uploads/hr_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);
	}
	$imagepath="";		
	if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename))
	{
		$imagepath= $inventoryimagename;	
	}
	return $imagepath;
}

function hrmgt_upload_profile($file)
{
	$FileDdata = pathinfo($file);
	if($FileDdata['extension']=="png" || $FileDdata['extension']=="jpg" || $FileDdata['extension']=="jpeg")
	{
		return $file;
	} 
	else
	{
		return false;
	}
}

function hrmgt_get_all_user_in_message(){
	$employee=hrmgt_get_working_user('employee');
	$admin = get_users(array('role'=>'administrator'));
	$hr_manager = get_users(array('role'=>'manager'));	
	$accountant = get_users(array('role'=>'accountant'));	
	
	$all_user = array('employee'=>$employee,
		'administrator'=>$admin,
		'HR Manager'=>$hr_manager,
		'Accountant'=>$accountant
	);	
	
	$return_array = array();
	
	foreach($all_user as $key => $value)
	{ 
		if(!empty($value))
		{
			echo '<optgroup label="'.$key.'" style = "text-transform: capitalize;">';
			foreach($value as $user)
			{			
				echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
			}
		}
	}	
}

function hrmgt_change_read_status($id)
{
	global $wpdb;	
	$table_name = $wpdb->prefix . "hrmgt_message";
	$data['msg_status']=1;
	$whereid['message_id']=$id;
	return $retrieve_subject = $wpdb->update($table_name,$data,$whereid);
}

function hrmgt_print_init()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print'){ ?>
	<script>window.onload = function(){ window.print(); };</script>
	<?php
	if(isset($_REQUEST['type']) && $_REQUEST['type']=='exepriance')
	{
		hrmgt_print_exprience_latter($_REQUEST['employee_id']);		
		exit;
	}
	if(isset($_REQUEST['type']) && $_REQUEST['type']=='payslip')
	{
		hrmgt_print_payslip($_REQUEST['payslip_id']);
		exit;
	}
	if(isset($_REQUEST['type']) && $_REQUEST['type']=='salary_slip')
	{
		hrmgt_print_salary_slip($_REQUEST['AttDetail_id']);
		exit;
	}
	if(isset($_REQUEST['type']) && $_REQUEST['type']=='tranee')
	{		
		hrmgt_print_tranee($_REQUEST['training_id']);
		exit;
	}
	
	}
 }
add_action('init','hrmgt_print_init');

function hrmgt_get_role_name($role)
{
	if($role=='all')
		$role_title=__('All','hr_mgt');
	if($role=='employee')
		$role_title=__('Employee','hr_mgt');	
	return $role_title;
}



function get_parent_dept_name($id)
{
	global $wpdb;
	$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
	$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_department where id=".$id);	
	return $result->department_name;		
}


function hrmgt_employee_attendance_report($emp_id)
{
	global $wpdb;
	$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
	$year=date("Y");	
	$months_data = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun',
	'07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Desc');
	
	foreach($months_data as $key=>$value)
	{
		$month_days=cal_days_in_month(CAL_GREGORIAN,(int)$key,$year);
				
		$result = $wpdb->get_var("SELECT count(*) FROM $table_hrmgt_attendance 
		where MONTH(attendance_date) = {$key} AND employee_id=".$emp_id);
		
		$months[$value]=$result;		
		$absent=$month_days-$result;
		$chart_array[0] = array('Month','Present','Days');
		$chart_array[] = array($value,(int)$result,(int)$month_days);		
	}
	
	return $chart_array;
}

function get_count($name)
{
	global $wpdb;
	$table_name = $wpdb->prefix .$name;
	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
	return $rowcount;
}

function hrmgt_count_inbox_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_message';
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver = $id and msg_status=0");
	return $inbox;
}

function hrmgt_get_all_user_in_plugin()
{
	$all_user=array();
	$employee = get_users(array('role'=>'employee'));
	$manager = get_users(array('role'=>'manager'));
	$accountant = get_users(array('role'=>'accountant'));
	$all_role = array_merge($employee,$manager,$accountant);
	$all_user = array($all_role);	
	foreach($all_user as $key=>$values)
	{
		return $values;
	}
}


function hrmgt_documets($file,$type,$nm) 
{		
	$parts = pathinfo($type['name']);
	
	$inventoryimagename = time()."-".$nm;
	$document_dir = WP_CONTENT_DIR ;
	$document_dir .= '/uploads/hr_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}	
	return $imagepath;
}



function hrmgt_string_replacemnet($arr,$message)
{
	$data = str_replace(array_keys($arr),array_values($arr),$message);
	return $data;
}


function hmgt_send_mail($emails,$subject,$message)
{	
	$message = "<pre style='font-size:14px'>".$message."</pre>";	
	$headers ="";	
	$headers .= 'From: '.get_option('hrmgt_system_name').' <'.get_option("hrmgt_email").'>' . "\r\n";	
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 
		//var_dump($emails); 
	return wp_mail($emails,$subject,$message,$headers);
}

function get_all_plugin_users_email()
{
	$users = array();
	$roles = array('employee', 'accountant', 'manager');
	foreach ($roles as $role) :
		$users_query = new WP_User_Query( array( 		
		'role' => $role, 
		'orderby' => 'display_name'
		) );
		$results = $users_query->get_results();
		if ($results) $users = array_merge($users, $results);
		endforeach;
		foreach($users as $user_key=>$user_val){
			$emails[] = $user_val->user_email;
		}
		return $emails;
}

function hrmgt_get_user_email_by_role($role)
{
	$args = array('role'=>$role);
	$userdata = get_users($args);
	foreach($userdata as $key=>$user_data)
	{
		$result = $user_data->user_email;
	}
	return $result;	
}


function hrmgt_get_date_diff($joining_date,$currant_date)
{
	$datetime1 = date_create($joining_date); 							
	$datetime2 = date_create($currant_date);  							
	$interval = date_diff($datetime1, $datetime2); 
	$year =  $interval->format('%y');							
	$month =  $interval->format('%m');							
	$day =  $interval->format('%d');
	if($year)
	{
		$years = $year.' Year';
	}
	else
	{
		$years="";
	}
	if($month)
	{
		$months = $month.' Month';
	}
	else
	{
		$months="";
	}
	if($day)
	{
		$days = $day.' Days';
	}
	else
	{
		$days="";
	}
	return $years." ".$months." ".$days;							
}

function get_employee_by_project_id($project_id)
{
	global $wpdb;
	$wp_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_project_meta';
	$result = $wpdb->get_results("SELECT * FROM $wp_hrmgt_client_feedback WHERE project_id= ".$project_id);
	return $result;
}


function get_monthly_total_attendace($employee_id,$month,$year)
{
	global $wpdb;
	$tbl_attendance_details = $wpdb->prefix. 'hrmgt_attendance_details';
	$data = $wpdb->get_results("SELECT * FROM $tbl_attendance_details WHERE employee_id=$employee_id AND month=$month AND year=$year",ARRAY_A);

	unset($data[0]["id"]);
	unset($data[0]["employee_id"]);
	unset($data[0]["month"]);
	unset($data[0]["year"]);
	unset($data[0]["tatal_present"]);
	unset($data[0]["tatal_absent"]);
	unset($data[0]["tatal_holidy"]);
	unset($data[0]["total_hl"]);
	unset($data[0]["total_aa"]);
	unset($data[0]["total_p_p"]);
	unset($data[0]["opening_pl"]);
	unset($data[0]["new"]);
	unset($data[0]["used_pl"]);
	unset($data[0]["remaining_pl"]);
	unset($data[0]["payable_days"]);	
	unset($data[0]["appoval_status"]);	
	foreach($data[0] as $k=>$v)
	{
		if(is_null($v))
		{
			unset($data[0][$k]);
		}
	}
	$data = $data[0];	
	$vals["A"] = 0;
	$vals["P"] = 0;
	$vals["HL"] = 0;
	$vals["H"] = 0;
	$vals['HL']=0;
	$vals["used_pl"] = 0;
	$vals["manual_A"] = 0;
	$vals["manual_P"] = 0;
	$vals["manual_H"] = 0;
	$vals["AA"] = 0;
	$vals["P.5"] = 0;
	$vals["-"] = 0;
	
	
$vals = array_merge($vals,array_count_values($data));
return $vals; 
}

 function showDay($month, $year, $day, $count=1111) {
	if($count!=1111){
	  $list = array(1=>'first',2=>'second',3=>'third',4=>'fourth',5=>'fifth');
	  $first = date('d', strtotime($month . ' ' . $year . ' ' . $list[1] .' '.$day));
	  $show= ($first>7) ?  $count-1 : $count;
	  return $day = date('j', strtotime($month . ' ' . $year . ' ' . $list[$show] .' '.$day));
	}
 }



function get_user_by_role($role)
{
	$args = array('role' =>$role); 
	return get_users( $args ); 
}

function get_attendance_status_by_date($date,$employee_id)
{
	$date= explode("-",$date);	
	global $wpdb;	
	$table_hrmgt_attendance_details = $wpdb->prefix . "hrmgt_attendance_details";
	
	$status =  $wpdb->get_row("SELECT day_{$date[2]} FROM $table_hrmgt_attendance_details WHERE employee_id=$employee_id AND year='{$date[0]}' AND month='{$date[1]}'");
	$obj = "day_".$date[2];	
	return $status->$obj;	
}

function get_days_in_month($month, $year)
{
   return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

function get_monthly_emoployee_earning($emp_id,$month,$year)
{
	global $wpdb;
	$tbl_hrmgt_payslip  = $wpdb->prefix .'hrmgt_payslip';
	$sql = "SELECT * FROM $tbl_hrmgt_payslip WHERE employee_id=$emp_id AND EXTRACT(MONTH FROM salary_date)=$month AND  EXTRACT(YEAR FROM salary_date)=$year";
	return $result = $wpdb->get_results($sql);
}

function hrmgt_get_working_user($role)
{
	$args = array(		
		'role'         => $role,		
		'meta_key'     => 'working_status',
		'meta_value'   => 'Working'		
	 ); 
	$emplyee=  get_users( $args );
	return $emplyee;
}


function removeEmptyElementsFromArray($element)
{
	if($element)
	{
		if (is_array($element)) 
		{
			if ($key = key($element)) 
			{
				$element[$key] = array_filter($element);
			}

			if (count($element) != count($element, COUNT_RECURSIVE)) 
			{
				$element = array_filter(current($element), __FUNCTION__);
			}

			return $element;
		} 
		else
		{
			return empty($element) ? false : $element;
		}
	}
}


function export_csv_by_role($role)
{

	$userdata = get_users(array('role'=>$role));
	if(!empty($userdata))
	{
		$header = array();			
		$header[] = 'employee_code';
		$header[] = 'user_login';
		$header[] = 'user_email';		
		$header[] = 'first_name';
		$header[] = 'middle_name';
		$header[] = 'last_name';
		$header[] = 'gender';
		$header[] = 'birth_date';
		$header[] = 'marital_status';
		$header[] = 'blood_group';
		$header[] = 'working_status'; 
		$header[] = 'joining_date';
		$header[] = 'contract_end_date';
		$header[] = 'deposit';
		$header[] = 'employee_level';
		$header[] = 'term_detail';
		$header[] = 'monthly_leave';
		$header[] = 'designation';
		$header[] = 'employee_salary';
		$header[] = 'qualification';
		$header[] = 'mobile';
		$header[] = 'gov_id'; 
		$header[] = 'passport_number';
		$header[] = 'passport_expiry_date';
		$header[] = 'driving_license_number';
		$header[] = 'driving_license_expiry_date';
		
		$header[] = 'p_address';
		$header[] = 'p_city_name';
		$header[] = 'p_state_name';
		$header[] = 'p_zip_code';

		$header[] = 'address';
		$header[] = 'city_name';
		$header[] = 'state_name';
		$header[] = 'zip_code';		
		
		$header[] = 'ac_holder_name';
		$header[] = 'account_number';
		$header[] = 'IFSC_code';
		$header[] = 'PAN_number';
		$header[] = 'branch_name';
		$filename='Reports/export_'.$role.'.csv';		
		$fh = fopen(HRMS_PLUGIN_DIR.'/'.$filename, 'w') or die("can't open file");			
		
		fputcsv($fh, $header);
		foreach($userdata as $retrive_data)
		{		
			$row=array();	
			$mobile = $retrive_data->mobile;			
			$row[] = $retrive_data->employee_code;
			$row[] = $retrive_data->user_login;
			$row[] = $retrive_data->user_email;
			$row[] = $retrive_data->first_name;
			$row[] = $retrive_data->middle_name;
			$row[] = $retrive_data->last_name;
			$row[] = ucfirst($retrive_data->gender);			
			$row[] = date("Y-m-d",strtotime($retrive_data->birth_date));
			$row[] = $retrive_data->marital_status;
			$row[] = $retrive_data->blood_group;
			$row[] = $retrive_data->working_status; 
			$row[] =  date("Y-m-d",strtotime($retrive_data->joining_date));
			$row[] =  date("Y-m-d",strtotime($retrive_data->contract_end_date));
			$row[] = "$retrive_data->deposit";
			$row[] = $retrive_data->employee_level;
			$row[] = $retrive_data->term_detail;
			$row[] = $retrive_data->monthly_leave;
			$row[] = $retrive_data->designation;
			$row[] = $retrive_data->employee_salary;
			$row[] = $retrive_data->qualification;
			$row[] = "$mobile";
			$row[] = $retrive_data->gov_id;
			$row[] = $retrive_data->passport_number;
			$row[] = date("Y-m-d",strtotime($retrive_data->passport_expiry_date));
			$row[] = $retrive_data->driving_license_number; 		
			$row[] =  date("Y-m-d",strtotime($retrive_data->driving_license_expiry_date));	
			
			$row[] = $retrive_data->p_address;
			$row[] = $retrive_data->p_city_name;
			$row[] = $retrive_data->p_state_name;
			$row[] = $retrive_data->p_zip_code;	
			
			$row[] = $retrive_data->address;
			$row[] = $retrive_data->city_name;
			$row[] = $retrive_data->state_name;
			$row[] = $retrive_data->zip_code;	
			
			$row[] = $retrive_data->ac_holder_name;
			$row[] = $retrive_data->account_number;
			$row[] = $retrive_data->IFSC_code;
			$row[] = $retrive_data->PAN_number;
			$row[] = $retrive_data->branch_name;								
			fputcsv($fh, $row);				
		}
		fclose($fh);		
		ob_clean();
		$file=HRMS_PLUGIN_DIR .'/'. $filename; //file location
		$mime = 'text/plain';
		//header('Content-Type:application/force-download');
		header('Content-Type: text/csv; charset=utf-8');
		header('Pragma: public');       // required
		header('Expires: 0');           // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Content-Transfer-Encoding: binary');
		//header('Content-Length: '.filesize($file_name));      // provide file size
		header('Connection: close');
		readfile($file);
		exit;
	}	
}

function get_current_month_event($month,$year)
{	
	$args = array(
		'post_type'         => 'hrmgt_events',
		'post_status'       => 'publish',		
		'meta_query'        => array(
		'relation'  => 'AND',
			array(
				'key'       => 'event_start_date',
				'value'     => $year.'-'.$month,
				'compare'   => 'LIKE'
			)
		)
	);
	return $posts = get_posts($args);
}

function get_role_wise_notice($role)
{
	if($role=='manager')
	{
		$role = 'hr_manager';
	}
	
	$args = array(
			'post_type'         => 'hrmgt_notice',
			'post_status'       => 'publish',		
			'meta_query'        => array(
			'relation'  		=> 'AND',
			array(
				'key'       => 'notice_for',
				'value'     => array($role,'All')					
			)
		)
	);
	return $NoticeData = get_posts($args);
}

function get_current_month_notice($month,$year,$role)
{
	if($role=='manager')
	{
		$role = 'hr_manager';
	}
	
	$args = array(
			'post_type'         => 'hrmgt_notice',
			'post_status'       => 'publish',		
			'meta_query'        => array(
				'relation'  => 'AND',
				array(
					'key'       => 'notice_for',
					'value'     => array($role,'All')					
				),
				array(
					'key'       => 'start_date',
					'value'     => $year.'-'.$month,
					'compare'   => 'LIKE'					
				),
			)
		);
	return $NoticeData = get_posts($args);	
}



function get_admin_current_month_notice($month,$year)
{
	$args = array(
		'post_type'         => 'hrmgt_notice',
		'post_status'       => 'publish',		
		'meta_query'        => array(
			'relation'  => 'AND',		
			array(
				'key'       => 'start_date',
				'value'     => $year.'-'.$month,
				'compare'   => 'LIKE'					
			),
		)
	);
	return $NoticeData = get_posts($args);	
}


function get_employee_birthday($month)
{

$employes = get_users(
	array(
      'role' => 'employee',
      'meta_query' => array(
          array(
              'key' => 'birth_date',
              'value' =>$month,
              'compare' => 'LIKE'
           ), 
        )
    ));
	 
	 
	$birthday_emp =array();
	if(!empty($employes))
	{
		foreach($employes as $employe)
		{
			if(substr($employe->birth_date,0,2)==$month){
				$birthday_emp[] = $employe;
			}			
		}
	}
	return $birthday_emp; 
	  
}
	
function day_name_by_month_year($day,$month,$year)
{	
	$date = "$day-$month-$year";
	$nameOfDay = date('D', strtotime($date));
	return $nameOfDay;
}

function hrmgt_get_current_month_holidy($month,$year)
{
	global $wpdb;
	$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';		
	$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_holiday  WHERE MONTH(start_date)=$month AND YEAR(start_date)=$year");	
	return $result;
}	
function hrmgt_get_emp_pl($emp_id,$month,$year)
{
	// global $wpdb;		
	// $tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
	// $result = $wpdb->get_row("SELECT month_".$month." FROM $tbl_name WHERE employee_id = $emp_id AND year=$year");
	// return $result;
	$month = ltrim($month, '0');
		
		global $wpdb;
		$column = "month_".$month;
		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$column = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
		$wpdb->dbname, $tbl_name, $column
		) );
		
		if ( ! empty( $column ) ) 
		{	
			$returndata =0;
			$sql 	= "SELECT month_".$month." FROM $tbl_name WHERE employee_id = $emp_id AND year=$year";
			$result = $wpdb->get_row($sql);	
			if($result)
			{
				$obj = "month_".$month;
				$returndata = $result->$obj;
			}			
			return $returndata;
		} 
		else
		{
			return 0;
		}
}
function hrmgt_get_attendance_empid($empid)
	{
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance_details';
		$result =$wpdb->get_results("SELECT id FROM $table_hrmgt_attendance where employee_id=$empid");
		return $result;
	}
?>