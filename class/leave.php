<?php
class HrmgtLeave extends HrmgtAttendanceDetails
{	
	public function hrmgt_add_leave($data)
	{		
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$leavedata['employee_id']=$data['employee_id'];
		$leavedata['leave_type']=$data['leave_type'];
		$leavedata['leave_duration']=$data['leave_duration'];
		$leavedata['start_date']=date("Y-m-d", strtotime($data['start_date']));
		if(isset($data['end_date']))
		$leavedata['end_date']=date("Y-m-d", strtotime($data['end_date']));;
		$leavedata['status']=$data['status'];
		$leavedata['reason']=$data['reason'];
		$leavedata['created_by']=get_current_user_id();

		if($data['action']=='edit'){
			$whereid['id']=$data['leave_id'];
			if($data['leave_duration']!='more_then_day'){
				$leavedata['end_date']='';
			}
			$result=$wpdb->update( $table_hrmgt_leave, $leavedata ,$whereid);
			return $result;
		}
		else{
			
			$this->add_leave_entry_in_attendance_details($data['start_date'],isset($data['end_date'])?$data['end_date']:'',$data['leave_duration'],$data['employee_id']);
			
			$resultdata=$wpdb->insert( $table_hrmgt_leave, $leavedata );
			if($resultdata)
			{
				$arr['{{start_date}}'] = hrmgt_change_dateformat($_POST['start_date']);
				$arr['{{end_date}}'] = hrmgt_change_dateformat(isset($_POST['end_date'])? $_POST['end_date']:'');
				$arr['{{leave_type}}'] = get_the_title($_POST['leave_type']);
				$arr['{{leave_duration}}'] = str_replace('_',' ',$_POST['leave_duration']);
				$arr['{{reason}}'] = $_POST['reason'];
				$arr['{{employee_name}}'] = hrmgt_get_display_name($_POST['employee_id']);
				$arr['{{system_name}}'] = get_option('hrmgt_system_name');				
				$message = get_option('addleave_email_template');				
				if($data['leave_duration']!='more_then_day'){				
					$message = str_replace("to  {{end_date}}","",$message);
				}
				
				
				$replace_message =  hrmgt_string_replacemnet($arr,$message);
			
				if($replace_message)
				{
					$to[]= hrmgt_get_emailid_byuser_id($_POST['employee_id']);				
					 $emails = get_option('add_leave_emails');
					$emails = explode(',',$emails);
					foreach($emails as $email)
					{
						$to[]=$email;
					}					
					$managers = get_user_by_role('manager');
										
					$subject = get_option('add_leave_subject');
					$result =  hmgt_send_mail($to,$subject,$replace_message);
				}
			}
			return $result =$resultdata ;
		}	
	}
	public function get_all_leaves()
	{
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave");
		return $result;	
	}
	

	public function get_single_user_leaves($id)
	{
		global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave WHERE employee_id=$id");
		return $result;
	}

	
	public function get_single_user_leaves_for_report($employee_id,$start_date,$end_date)
	{		
		global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$sql = "SELECT * FROM $table_hrmgt_leave WHERE start_date between '".$start_date."' AND '".$end_date."' AND employee_id='".$employee_id."' ";
		
		$result = $wpdb->get_results($sql);
		return $result;	
	}
	
	public function hrmgt_get_single_leave($id)
	{
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave where id=".$id);			
		return $result;
	}
	
	public function hrmgt_approve_leave($data)
	{
		global $wpdb;
		$id = $data['leave_id'];
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);
		$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Approved' where id=".$id);		
		if($update)
		{			
			$leave_data = $this->hrmgt_get_single_leave($id);
			$arr=array();
			if(!empty($leave_data->end_date))
			{
				$date = hrmgt_change_dateformat($leave_data->start_date) .' To '. hrmgt_change_dateformat($leave_data->end_date);
			}
			else
			{
				$date  = hrmgt_change_dateformat($leave_data->start_date);
			}
			
			$arr['{{date}}']= $date;					
			$arr['{{system_name}}'] = get_option('hrmgt_system_name');
			$arr['{{user_name}}'] = hrmgt_get_display_name($leave_data->employee_id);
			$arr['{{comment}}'] = $data['comment'];
			$message = get_option('leave_approve_email_template');		
			$replace_message =  hrmgt_string_replacemnet($arr,$message);			
			if($replace_message)
			{
				$subject = get_option('leave_approve_subject');						
				$to[]= hrmgt_get_emailid_byuser_id($leave_data->employee_id);				
				$emails = get_option('leave_approveemails');
				$emails = explode(",",$emails);
				foreach($emails as $email)
				{
					$to[]=$email;
				}
				
				$mail = hmgt_send_mail($to,$subject,$replace_message);				
				if($mail)
				{
					return true;
				}
			} 			
		}
	}
	
	
	
	public function hrmgt_reject_leave($data)
	{
		global $wpdb;
		$id = $data['leave_id'];
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);
		$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Rejected' where id=".$id);		
		if($update)
		{ 	
			$replace_message="";
			$to = array();
			
			$leave_data = $this->hrmgt_get_single_leave($id);
			$to[]= hrmgt_get_emailid_byuser_id($leave_data->employee_id);
			$emails= explode(",",get_option('leave_approveemails'));
			foreach($emails as $email)
			{
				$to[] = $email;
			}			
			$subject="Reject Leave";
			$replace_message .= "Hello, \r\n \r\n Leave of ". hrmgt_get_display_name($leave_data->employee_id) . " is  rejected.";
			$replace_message .="\r\n \r\n";
			$replace_message .= "Comment  : ". $data['comment'];
			
			$mail = hmgt_send_mail($to,$subject,$replace_message);			
			if($mail)
			{
				return true;					
			}
		}
	}
	
	public function hrmgt_delete_leave($service_id)
	{
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'hrmgt_leave';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_leave where id= ".$service_id);		
		return $result;
	}
	
	
	public function add_leave_entry_in_attendance_details($start_date,$end_date='',$leave_duration,$employee_id)
	{
		global $wpdb;		
		$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';			
		$start_date=strtotime($start_date);	
		$end_date= strtotime($end_date);
		
		
		if($leave_duration == "more_then_day")
		{	
			for($i=$start_date; $i<=$end_date; $i+=86400)
			{ 
				$Leavday =  date('j',$i);			
				$wheredata['month'] =  date('n',$i);
				$wheredata['year']=  date('Y',$i);
				$wheredata['employee_id']=$employee_id;					
				$month =  date('n',$i);
				$year =  date('Y',$i);			
				
				 $count = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");			
							
				 if($count=="0")
				 {
					$Attendacedata['employee_id']=$employee_id;
					$Attendacedata['month']=$month;
					$Attendacedata['year']=$year;
					$Attendacedata['tatal_present']="0";
					$Attendacedata['tatal_absent']="0";
					$Attendacedata['tatal_holidy']="0";
					$Attendacedata['total_hl']="0";
					$Attendacedata['payable_days']="0";
					$Attendacedata['opening_pl']="0";
					$Attendacedata['used_pl']="0";
					$Attendacedata['remaining_pl']="0";				
					$Attendacedata['total_aa']="0";
					$Attendacedata['total_p_p']="0";
					$en_start_date = "01-".$month."-".$year;
					$en_start_time = strtotime($en_start_date);
					$en_end_time = strtotime("+1 month", $en_start_time);			
						
					for($a=$en_start_time; $a<$en_end_time; $a+=86400)
					{				
						$day = date('j', $a);			
						$day_name = date('l', $a);
						if($day_name == "Sunday")
						{					
							$Attendacedata["day_{$day}"] = "H";
						}
						elseif($Leavday==$day)
						{
							$Attendacedata["day_{$day}"]= "A";
						}
						else
						{
							if($day > date('j'))
							{
								$Attendacedata["day_{$day}"]= "-";
							}								
							else
							{
								$Attendacedata["day_{$day}"]= "A";
							}							
						}	  
					}	
					$wpdb->insert($tbl_name,$Attendacedata);	
					$last_month_balance = $this->get_leave_balance($employee_id,$month,$year);
					$monthly_leave = get_user_meta( $employee_id,'monthly_leave',true);	
						
					$total_present =get_monthly_total_attendace($employee_id,$month,$year);	
					
					$presents = (isset($total_present["P"])) ? $total_present["P"] : 0; 
					$manual_present = (isset($total_present["manual_P"])) ? $total_present["manual_P"] : 0; 
					$presents = $presents + $manual_present;
					$half_days = (isset($total_present["HL"])) ? $total_present["HL"] : 0;
					$manual_half_days = (isset($total_present["manual_HL"])) ? $total_present["manual_HL"] : 0;
					$half_days = $half_days + $manual_half_days;

					$aa = (isset($total_present["AA"])) ? $total_present["AA"] : 0;
					$manual_aa = (isset($total_present["manual_AA"])) ? $total_present["manual_AA"] : 0;
					$aa = $aa + $manual_aa;
						
					$defult = isset($total_present["-"]) ? $total_present["-"] : 0;
						
					$absents = $total_present["A"];
					$manual_absents = (isset($total_present["manual_A"])) ? $total_present["manual_A"] : 0;
					$absents = $absents + $manual_absents + ($half_days * 0.5);
					
				

					$holidays = isset($total_present["H"]) ? $total_present["H"] : 0;
					$manual_holidays = (isset($total_present["manual_H"])) ? $total_present["manual_H"] : 0;
					$holidays = $holidays + $manual_holidays;
						
					$p_p = isset($total_present["P.5"]) ? $total_present["P.5"] : 0;
					$manual_p_p = (isset($total_present["manual_P.5"])) ? $total_present["manual_P.5"] : 0;
					$p_p = $p_p + $manual_p_p;

					$total_present = ($presents != 0  ) ? $presents + $holidays +($p_p * 1.5): 0; 
					$total_present = $total_present + ($half_days * 0.5);
					$total_absents = $absents+ ( $aa*2 );

					$pl_balance = $last_month_balance + $monthly_leave;
					$remaining_pl = $pl_balance - $total_absents;
					
					if($remaining_pl >= 0 ){
						$used_pl = $total_absents;
					}
					else
					{
						$remaining_pl = 0;
						$used_pl = $pl_balance;
					}
					$payable_days = $total_present + $used_pl;
		
					$AttCountData["total_aa"] = $aa;
					$AttCountData['tatal_present']=$presents + ($half_days * 0.5);
					$AttCountData['tatal_absent']=$absents;
					$AttCountData['total_hl']=$half_days;
					$AttCountData['tatal_holidy']=$holidays;
					$AttCountData['total_p_p']=$p_p;	
					$AttCountData["opening_pl"] = $last_month_balance;		
					$AttCountData["used_pl"] = $used_pl;
					$AttCountData["remaining_pl"] = $remaining_pl;
					$AttCountData["payable_days"] = $payable_days;		
					$AttCountData = $wpdb->update($tbl_name,$AttCountData,$wheredata);
					} 
				else
				{
						
					$AttDetails = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=$employee_id AND month=".$month." AND year=".$year."");
					
					$AtteInfo['manual']=0;
					$AtteInfo['status']="A";
					$AtteInfo['attendancedetailid']=$AttDetails->id;
					$AtteInfo['data']=$employee_id.'/'.$Leavday.'/'.$month.'/'.$year;				
					$this->update_attendance_details($AtteInfo);	 
				} 
				
				$result ="";
				
			}
			
			
			
		} 
		elseif($leave_duration=="full_day")
		{
			$day =  date('j',$start_date);					
			$l_day =  date('j',$start_date);					
			$month = date('n',$start_date);
			$year = date('Y',$start_date);				
			$wheredata['month'] =  date('n',$start_date);
			$wheredata['year']=  date('Y',$start_date);	
			$wheredata['employee_id']=$employee_id;
						
			$AttDetails = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=$employee_id AND month=".$wheredata['month']." AND year=".$wheredata['year']."");
				
			$count = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");
			
			if($count=="0"){					
				$Attendacedata['employee_id']=$employee_id;
				$Attendacedata['month']=$month;
				$Attendacedata['year']=$year;
				$Attendacedata['tatal_present']="0";
				$Attendacedata['tatal_absent']="0";
				$Attendacedata['tatal_holidy']="0";
				$Attendacedata['total_hl']="0";
				$Attendacedata['payable_days']="0";
				$Attendacedata['opening_pl']="0";
				$Attendacedata['used_pl']="0";
				$Attendacedata['remaining_pl']="0";				
				$Attendacedata['total_aa']="0";
				$Attendacedata['total_p_p']="0";
		
				$start_date = "01-".$month."-".$year;
				$start_time = strtotime($start_date);
				$end_time = strtotime("+1 month", $start_time);			

				for($i=$start_time; $i<$end_time; $i+=86400){				
			
					$day = date('j', $i);			
					$day_name = date('l', $i);
					if($day_name == "Sunday"){					
						$Attendacedata["day_{$day}"] = "H";
					}
					elseif($l_day==$day){
						$Attendacedata["day_{$day}"]= "A";
					}
					else{
						if($day > date('j')){
							$Attendacedata["day_{$day}"]= "-";
						}
						else{
							$Attendacedata["day_{$day}"]= "A";
						}
					}	  
				}	
					$result = $wpdb->insert($tbl_name,$Attendacedata);	
				$last_month_balance = $this->get_leave_balance($employee_id,$month,$year);
				$monthly_leave = get_user_meta( $employee_id,'monthly_leave',true);	
					
				$total_present =get_monthly_total_attendace($employee_id,$month,$year);	
				
				$presents = (isset($total_present["P"])) ? $total_present["P"] : 0; 
				$manual_present = (isset($total_present["manual_P"])) ? $total_present["manual_P"] : 0; 
				$presents = $presents + $manual_present;

				$half_days = (isset($total_present["HL"])) ? $total_present["HL"] : 0;
				$manual_half_days = (isset($total_present["manual_HL"])) ? $total_present["manual_HL"] : 0;
				$half_days = $half_days + $manual_half_days;

				$aa = (isset($total_present["AA"])) ? $total_present["AA"] : 0;
				$manual_aa = (isset($total_present["manual_AA"])) ? $total_present["manual_AA"] : 0;
				$aa = $aa + $manual_aa;

				

				$defult = isset($total_present["-"]) ? $total_present["-"] : 0;
				
				$absents = $total_present["A"];
				$manual_absents = (isset($total_present["manual_A"])) ? $total_present["manual_A"] : 0;
				$absents = $absents + $manual_absents + ($half_days * 0.5);
				
				
				$holidays = isset($total_present["H"]) ? $total_present["H"] : 0;
				$manual_holidays = (isset($total_present["manual_H"])) ? $total_present["manual_H"] : 0;
				$holidays = $holidays + $manual_holidays;

				
				$p_p = isset($total_present["P.5"]) ? $total_present["P.5"] : 0;
				$manual_p_p = (isset($total_present["manual_P.5"])) ? $total_present["manual_P.5"] : 0;
				$p_p = $p_p + $manual_p_p;
	
				
				$total_present = ($presents != 0  ) ? $presents + $holidays +($p_p * 1.5): 0; /* Dont include holiday as present if absent whole month*/
				$total_present = $total_present + ($half_days * 0.5);
				$total_absents = $absents+ ( $aa*2 );

				$pl_balance = $last_month_balance + $monthly_leave;
				$remaining_pl = $pl_balance - $total_absents;
	
				if($remaining_pl >= 0 ){
					$used_pl = $total_absents;
				}
				else
				{
					$remaining_pl = 0;
					$used_pl = $pl_balance;
				}
				$payable_days = $total_present + $used_pl;
		
				$AttCountData["total_aa"] = $aa;
				$AttCountData['tatal_present']=$presents + ($half_days * 0.5);
				$AttCountData['tatal_absent']=$absents;
				$AttCountData['total_hl']=$half_days;
				$AttCountData['tatal_holidy']=$holidays;
				$AttCountData['total_p_p']=$p_p;	
				$AttCountData["opening_pl"] = $last_month_balance;		
				$AttCountData["used_pl"] = $used_pl;
				$AttCountData["remaining_pl"] = $remaining_pl;
				$AttCountData["payable_days"] = $payable_days;		
				$AttCountData = $wpdb->update($tbl_name,$AttCountData,$wheredata);
			}
			else{
				$AtteInfo['manual']=0;
				$AtteInfo['status']="A";
				$AtteInfo['attendancedetailid']=$AttDetails->id;
				$AtteInfo['data']=$employee_id.'/'.$day.'/'.$month.'/'.$year;
				$result = $this->update_attendance_details($AtteInfo);
			}			
				
		
			} 
			elseif($leave_duration=='half_day')
			{
				$day =  date('j',$start_date);		
				$l_day =  date('j',$start_date);		
				$wheredata['month'] =  date('n',$start_date);
				$wheredata['year']=  date('Y',$start_date);	
				$wheredata['employee_id']=$employee_id;
				
				$day =  date('j',$start_date);					
				$month = date('n',$start_date);
				$year = date('Y',$start_date);	
				
				$AttDetails = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=$employee_id AND month=".$wheredata['month']." AND year=".$wheredata['year']."");
				
				$count = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");
				
				
					if($count=="0"){					
						$Attendacedata['employee_id']=$employee_id;
						$Attendacedata['month']=$month;
						$Attendacedata['year']=$year;
						$Attendacedata['tatal_present']="0";
						$Attendacedata['tatal_absent']="0";
						$Attendacedata['tatal_holidy']="0";
						$Attendacedata['total_hl']="0";
						$Attendacedata['payable_days']="0";
						$Attendacedata['opening_pl']="0";
						$Attendacedata['used_pl']="0";
						$Attendacedata['remaining_pl']="0";				
						$Attendacedata['total_aa']="0";
						$Attendacedata['total_p_p']="0";
		
						$start_date = "01-".$month."-".$year;
						$start_time = strtotime($start_date);
						$end_time = strtotime("+1 month", $start_time);			
						
						for($i=$start_time; $i<$end_time; $i+=86400){				
							$day = date('j', $i);			
							$day_name = date('l', $i);
							if($day_name == "Sunday"){					
								$Attendacedata["day_{$day}"] = "H";
							}
							elseif($l_day==$day){
								$Attendacedata["day_{$day}"]= "HL";
							}
							else{
								if($day > date('j')){
									$Attendacedata["day_{$day}"]= "-";
								}
								
								else{
									$Attendacedata["day_{$day}"]= "A";
								}
							
							}	  
						}	
						$result = $wpdb->insert($tbl_name,$Attendacedata);	
							$last_month_balance = $this->get_leave_balance($employee_id,$month,$year);
						$monthly_leave = get_user_meta( $employee_id,'monthly_leave',true);	
							
						$total_present =get_monthly_total_attendace($employee_id,$month,$year);	
						
						$presents = (isset($total_present["P"])) ? $total_present["P"] : 0; 
						$manual_present = (isset($total_present["manual_P"])) ? $total_present["manual_P"] : 0; 
						$presents = $presents + $manual_present;

						$half_days = (isset($total_present["HL"])) ? $total_present["HL"] : 0;
						$manual_half_days = (isset($total_present["manual_HL"])) ? $total_present["manual_HL"] : 0;
						$half_days = $half_days + $manual_half_days;

						$aa = (isset($total_present["AA"])) ? $total_present["AA"] : 0;
						$manual_aa = (isset($total_present["manual_AA"])) ? $total_present["manual_AA"] : 0;
						$aa = $aa + $manual_aa;
						$defult = isset($total_present["-"]) ? $total_present["-"] : 0;
	
						$absents = $total_present["A"];
						$manual_absents = (isset($total_present["manual_A"])) ? $total_present["manual_A"] : 0;
						$absents = $absents + $manual_absents + ($half_days * 0.5);
						
						
						$holidays = isset($total_present["H"]) ? $total_present["H"] : 0;
						$manual_holidays = (isset($total_present["manual_H"])) ? $total_present["manual_H"] : 0;
						$holidays = $holidays + $manual_holidays;

						
						$p_p = isset($total_present["P.5"]) ? $total_present["P.5"] : 0;
						$manual_p_p = (isset($total_present["manual_P.5"])) ? $total_present["manual_P.5"] : 0;
						$p_p = $p_p + $manual_p_p;
						
									
						$total_present = ($presents != 0  ) ? $presents + $holidays +($p_p * 1.5): 0; /* Dont include holiday as present if absent whole month*/
						$total_present = $total_present + ($half_days * 0.5);
						$total_absents = $absents+ ( $aa*2 );

						$pl_balance = $last_month_balance + $monthly_leave;
						$remaining_pl = $pl_balance - $total_absents;
	
						if($remaining_pl >= 0 ){
							$used_pl = $total_absents;
						}
						else
						{
							$remaining_pl = 0;
							$used_pl = $pl_balance;
						}
						$payable_days = $total_present + $used_pl;
							
						$AttCountData["total_aa"] = $aa;
						$AttCountData['tatal_present']=$presents + ($half_days * 0.5);
						$AttCountData['tatal_absent']=$absents;
						$AttCountData['total_hl']=$half_days;
						$AttCountData['tatal_holidy']=$holidays;
						$AttCountData['total_p_p']=$p_p;	
						$AttCountData["opening_pl"] = $last_month_balance;		
						$AttCountData["used_pl"] = $used_pl;
						$AttCountData["remaining_pl"] = $remaining_pl;
						$AttCountData["payable_days"] = $payable_days;		
						$AttCountData = $wpdb->update($tbl_name,$AttCountData,$wheredata);
					} 
					
				
				else{
					$AtteInfo['manual']=0;
					$AtteInfo['status']="HL";
					$AtteInfo['attendancedetailid']=$AttDetails->id;
					$AtteInfo['data']=$employee_id.'/'.$day.'/'.$month.'/'.$year;
					$result = $this->update_attendance_details($AtteInfo);
				}
				
			}			
			return $result;	
		}
	}
?>