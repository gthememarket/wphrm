<?php
class HrmgtEmployee
{	
	public function hrmgt_add_user($data)
	{		
		if(isset($data['employee_code']))
			$usermetadata['employee_code']=$data['employee_code'];
		if(isset($data['middle_name']))
			$usermetadata['middle_name']=$data['middle_name'];		
		if(isset($data['gender']))
			$usermetadata['gender']=$data['gender'];
		if(!empty($data['birth_date']))
			$usermetadata['birth_date']=date("m/d/Y",strtotime($data['birth_date']));		
		if(isset($data['marital_status']))
			$usermetadata['marital_status']=$data['marital_status'];
		if(isset($data['blood_group']))
			$usermetadata['blood_group']=$data['blood_group'];	
		if(isset($data['working_status']))		
			$usermetadata['working_status']=$data['working_status'];		
		if(isset($data['p_address']))
			$usermetadata['p_address']=$data['p_address'];
		if(isset($data['p_city_name']))
			$usermetadata['p_city_name']=$data['p_city_name'];
		if(isset($data['p_state_name']))
			$usermetadata['p_state_name']=$data['p_state_name'];
		if(isset($data['p_country_name']))
			$usermetadata['p_country_name']=$data['p_country_name'];
		if(isset($data['p_zip_code']))
			$usermetadata['p_zip_code']=$data['p_zip_code'];		
		if(isset($data['monthly_leave']))
			$usermetadata['monthly_leave']=$data['monthly_leave'];		
		if(isset($data['address']))
			$usermetadata['address']=$data['address'];
		if(isset($data['city_name']))
			$usermetadata['city_name']=$data['city_name'];
		if(isset($data['state_name']))
			$usermetadata['state_name']=$data['state_name'];
		if(isset($data['country_name']))
			$usermetadata['country_name']=$data['country_name'];
		if(isset($data['zip_code']))
			$usermetadata['zip_code']=$data['zip_code'];		
		if(isset($data['phone']))
			$usermetadata['phone']=$data['phone'];		
		if(!empty($data['joining_date']))
			$usermetadata['joining_date']=date('Y-m-d',strtotime($data['joining_date']));		
		if(!empty($data['contract_end_date']))
			$usermetadata['contract_end_date']=date('Y-m-d',strtotime($data['contract_end_date']));	
		if(isset($data['department']))
			$usermetadata['department']=$data['department'];
		if(isset($data['designation']))
			$usermetadata['designation']=$data['designation'];
		if(isset($data['employee_salary']))
			$usermetadata['employee_salary']=$data['employee_salary'];
		if(isset($data['qualification']))
			$usermetadata['qualification']=$data['qualification'];
		if(isset($data['deposit']))
			$usermetadata['deposit']=$data['deposit'];
		if(isset($data['employee_level']))
			$usermetadata['employee_level']=$data['employee_level'];
		if(isset($data['term_detail']))
			$usermetadata['term_detail']=$data['term_detail'];
		
		if(isset($data['mobile']))
			$usermetadata['mobile']=$data['mobile'];
		if(isset($data['gov_id']))
			$usermetadata['gov_id']=$data['gov_id'];
		if(isset($data['passport_number']))
			$usermetadata['passport_number']=$data['passport_number'];
		if(!empty($data['passport_expiry_date']))
			$usermetadata['passport_expiry_date']=date("m/d/Y",strtotime($data['passport_expiry_date']));		
		if(isset($data['driving_license_number']))
			$usermetadata['driving_license_number']=$data['driving_license_number'];
		if(!empty($data['driving_license_expiry_date']))
			$usermetadata['driving_license_expiry_date']=date("m/d/Y",strtotime($data['driving_license_expiry_date']));		
		if(isset($data['ac_holder_name']))
			$usermetadata['ac_holder_name']=$data['ac_holder_name'];
		if(isset($data['account_number']))
			$usermetadata['account_number']=$data['account_number'];
		if(isset($data['bank_name']))
			$usermetadata['bank_name']=$data['bank_name'];
		if(isset($data['IFSC_code']))
			$usermetadata['IFSC_code']=$data['IFSC_code'];
		if(isset($data['PAN_number']))
			$usermetadata['PAN_number']=$data['PAN_number'];
		if(isset($data['branch_name']))
			$usermetadata['branch_name']=$data['branch_name'];		
		if(isset($data['hrmgt_user_avatar']))
			$usermetadata['hrmgt_user_avatar']=	hrmgt_upload_profile($data['hrmgt_user_avatar']);
		if(isset($data['username']))
			$userdata['user_login']=$data['username'];
		if(isset($data['email']))
			$userdata['user_email']=$data['email'];
		
		if(isset($data['first_name']))
			$userdata['display_name']=$data['first_name']." ".$data['last_name'];		
		
		if(isset($data['first_name']))
			$userdata['first_name']=$data['first_name'];
		
		if(isset($data['last_name']))
			$userdata['last_name']=$data['last_name'];
		
		
		if($data['password'] != "")
			$userdata['user_pass']=$data['password'];
	
		
		$extra_earnings = get_option('earning');
		if($extra_earnings)
		{
			foreach($extra_earnings as $key=>$value)
			{
				$extra_earning[] = array(
					'title'=>str_replace("_"," ",$value),
					'amount'=>$data[$value],
					'status'=>'visible'
				);
			}
		}
		
		
		$Earning_Arr = array(
			$Dearness_Allowance = array(
				'title'=>'Dearness Allowance (D.A.)',
				'amount'=>$data['Dearness_Allowance'],
				'status'=>$data['Dearness_Allowance_Status']
			),
			$House_Rent_Allowance = array(
				'title'=>'House Rent Allowance (H.R.A.)',
				'amount'=>$data['House_Rent_Allowance'],
				'status'=>$data['House_Rent_Allowance_Status']
			),
			$Conveyanc_Allowance = array(
				'title'=>'Conveyance Allowance',
				'amount'=>$data['Conveyanc_Allowance'],
				'status'=>$data['Conveyanc_Allowance_Status']
			),
			$Travel_Allowance = array(
				'title'=>'Travel Allowance (T.A.)',
				'amount'=>$data['Travel_Allowance'],
				'status'=>$data['Travel_Allowance_Status']
			),
			$Medical_Allowance = array(
				'title'=>'Medical Allowance',
				'amount'=>$data['Medical_Allowance'],
				'status'=>$data['Medical_Allowance_Status']
			),
			$Food_Allowance = array(
				'title'=>'Food Allowance',
				'amount'=>$data['Food_Allowance'],
				'status'=>$data['Food_Allowance_Status']
			),
			$Mobile_Allowance = array(
				'title'=>'Mobile Allowance',
				'amount'=>$data['Mobile_Allowance'],
				'status'=>$data['Mobile_Allowance_Status']
			),
			$Perfomance_Incentives = array(
				'title'=>'Performance Incentives',
				'amount'=>$data['Performance_Incentives'],
				'status'=>$data['Perfomance_Incentives_Status']
			),
			$Salary_Difference = array(
				'title'=>'Salary Difference',
				'amount'=>$data['Salary_Difference'],
				'status'=>$data['Salary_Difference_Status']
			)			
		);
		$AllEarning = array_merge($Earning_Arr,$extra_earning);		
		
		$extra_deduction = get_option('deduction');
		if($extra_deduction)
		{
			foreach($extra_deduction as $extra_deduction_key=>$extra_deduction_value)
			{
				$extra_deductions[] = array(
					'title'=>str_replace("_"," ",$extra_deduction_value),
					'amount'=>$data[$extra_deduction_value],
					'status'=>'visible'
				);
			}
		}
		
		$Deduction_Arr = array(
			$Professional_Tax = array(
				'title'=>'Professional Tax',
				'amount'=>$data['Professional_Tax'],
				'status'=>$data['Professional_Tax_Status']
			),
			$Loan_Repayment = array(
				'title'=>'Loan Repayment / Advance',
				'amount'=>$data['Loan_Repayment'],
				'status'=>$data['Loan_Repayment_Status']
			),
			$Mobile_Bill_Recovery = array(
				'title'=>'Mobile Bill Recovery',
				'amount'=>$data['Mobile_Bill_Recovery'],
				'status'=>$data['Mobile_Bill_Recovery_Status']
			),
			$Tax_Deducted_at_Source = array(
				'title'=>'Tax Deducted at Source (T.D.S.)',
				'amount'=>$data['Tax_Deducted_at_Source'],
				'status'=>$data['Tax_Deducted_at_Source_Status']
			)			
		);
		$AllDeduction = array_merge($Deduction_Arr,$extra_deductions);
		
		$usermetadata['other_earning_entry'] = json_encode($AllEarning);
		$usermetadata['other_deduction_entry'] = json_encode($AllDeduction);
		
		if($data['action']=='edit')
		{				
			$userdata['ID']=$data['id'];			
			$user_id = wp_update_user($userdata);
			
			$returnans=update_user_meta( $user_id, 'first_name', $data['first_name'] );
			$returnans=update_user_meta( $user_id, 'last_name', $data['last_name'] );
				
				foreach($usermetadata as $key=>$val)
				{
					$returnans=update_user_meta( $user_id, $key,$val );
				}
				return $user_id;
		}
		else
		{
			$user_id = wp_insert_user( $userdata );			
			
		
			$arr['{{username}}']=$data['username'];			
			$arr['{{password}}']=$data['password'];			
			$arr['{{email}}']=$data['email'];			
			$arr['{{system_name}}']=get_option('hrmgt_system_name');
			
			
			$message = get_option('registration_email_template');			
			
			$message_replacement = hrmgt_string_replacemnet($arr,$message);			
			
			
			if($message_replacement)
			{
				$to = array();
				$to[]=$_POST['email'];
				$emails = get_option('registration_emails');			
				$emails = explode(",",$emails);
				foreach($emails as $email)
				{
					$to[] = $email;
				}
				$subject =get_option('registration_subject');
					hmgt_send_mail($to,$subject,$message_replacement);
			} 
			
			
			$user = new WP_User($user_id);
			$user->set_role($data['role']);
			foreach($usermetadata as $key=>$val){
				$returnans=add_user_meta( $user_id, $key,$val, true );
			}
			if(isset($data['first_name']))
				$returnans=update_user_meta( $user_id, 'first_name', $data['first_name'] );
			if(isset($data['last_name']))
				$returnans=update_user_meta( $user_id, 'last_name', $data['last_name'] );
			return $user_id;
		}	
	}
	
	public function hrmgt_upload_documents($upload_docs_array,$user_id)
	{	
		foreach($upload_docs_array as $key=>$val)
		{				
			if($key != '' && $val != '' )
			{
				$returnans=add_user_meta( $user_id, $key,$val, true );
			}		
		}		
	}

	public function hrmgt_update_upload_documents($upload_docs_array,$user_id)
	{		
		foreach($upload_docs_array as $key=>$val)
		{
			if($key != '' && $val != '' )
			{				
				$returnans=update_user_meta( $user_id, $key,$val);		
			}
		}		
	}
	
	public function delete_usedata($record_id)
	{
		global $wpdb;		
		$table_name = $wpdb->prefix . 'usermeta';
		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE user_id= %d",$record_id));
		$retuenval=wp_delete_user( $record_id );
		return $retuenval;
	}
	
	
	function hrmgt_user_barthday($user_id)
	{	
		$result = get_user_meta($user_id);		
		$resultdata['profile_img'] =get_user_meta($user_id,'hrmgt_user_avatar',true);		
		$resultdata['fname'] = get_user_meta($user_id,'first_name',true);
		$resultdata['lname'] = get_user_meta($user_id,'last_name',true);
		return $resultdata;	
	}
	
	function hrmgt_get_user_aniversary($date)
	{
		global $wpdb;					 
		$table_usermeta = $wpdb->prefix . 'usermeta';					 
		$sql="SELECT * FROM $table_usermeta WHERE DATE_FORMAT( meta_value , '%m-%d' ) > DATE_FORMAT( '".$date['today']."', '%m-%d' ) AND DATE_FORMAT( meta_value , '%m-%d' ) < DATE_FORMAT( '".$date['fivedaylatter']."', '%m-%d' )";
					 
		$users=$wpdb->get_results($sql);		
		if(!empty($users))
		{
			return $users;
		}
	}	
	
	
	
	function hrmgt_get_single_employee_data($id)
	{
		global $wpdb;					 
		$table_usermeta = $wpdb->prefix . 'users';
		$sql = "SELECT * FROM $table_usermeta WHERE ID=$id";
		$user = $wpdb->get_row($sql);
		return $user->ID;		
	}
	
	function hrmgt_get_single_employee_data_new($id)
	{
		return get_userdata($id);	
	}
	
	function generate_employee_code()
	{
		global $wpdb;
		$user_tbl = $wpdb->prefix . "users";
		$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$user_tbl}'");
		$lastid = $last->Auto_increment;
		$code = "E".sprintf("%03d",$lastid);
		return $code;
	}
}
?>