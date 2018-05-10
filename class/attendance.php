<?php
class HrmgtAttendance extends HrmgtAttendanceDetails
{	
	public function hrmgt_punchin_user()
	{
		global $wpdb;		
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		$emp_id =get_current_user_id();
		$attendance_date = date("Y-m-d");		
		$sql = "select * from $table_hrmgt_attendance where employee_id=$emp_id and attendance_date='$attendance_date'";	
		return $result = $wpdb->get_row($sql);		
	}
	
	
	
	public function hrmgt_add_attendance($data)
	{
		$total_time="";
		$lunchhours="";	
			
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		if(isset($data['employee_id']))
			 $attendancedata['employee_id']=$data['employee_id'];
		if(isset($data['attendance_date']))
			$attendancedata['attendance_date']=date('Y-m-d',strtotime($data['attendance_date']));
		if(isset($data['signin_time']))
			$attendancedata['signin_time']=$data['signin_time'];
		if(isset($data['signout_time']))
			$attendancedata['signout_time']=$data['signout_time'];
		if(isset($data['lunch_start_time']))
			$attendancedata['lunch_start_time']=$data['lunch_start_time'];
		if(isset($data['lunch_end_time']))
			$attendancedata['lunch_end_time']=$data['lunch_end_time'];
		if(isset($data['note']))
			$attendancedata['note']=$data['note'];
		if(isset($data['lunch_start_time']) && isset($data['lunch_end_time']))
			$lunchhours=hrmgt_get_time_difference($data['lunch_start_time'],$data['lunch_end_time']);
		
		
		if(isset($data['signin_time']) && isset($data['signout_time']))
		{		
			$total_time=hrmgt_get_time_difference($data['signin_time'],$data['signout_time']);
			$workinghours = hrmgt_get_working_hours($total_time,$lunchhours);
		} 
		
		 
		if(isset($workinghours) &&  $workinghours!="")
		{
			$attendancedata['working_hours']=$workinghours;		
		}
		if(isset($lunchhours) &&  $lunchhours!="")
		{
			$attendancedata['lunch_hourse']=$lunchhours;
		}
		$attendancedata['created_by']=get_current_user_id();
		
		
			
		
		if(isset($data['action']) && $data['action']=='edit'){
			$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_attendance WHERE id=".$data['attendance_id']);		
		
			if(isset($data['signout_time'])){
				$month =  date('n',strtotime($row->attendance_date));
				$year =  date('Y',strtotime($row->attendance_date));			
				$attendanceDay =  date('j',strtotime($row->attendance_date));		
				$this->hrmgt_save_attendance_details($row->employee_id,$attendanceDay,$month,$year,'dayout',$workinghours);
			}
			
			$whereid['id']=$data['attendance_id'];
			$result=$wpdb->update( $table_hrmgt_attendance, $attendancedata ,$whereid);
			return $result;
				
		}
		else
		{
			$ckkdata = date('Y-m-d',strtotime($data['attendance_date']));
			$AttCheak =  $wpdb->get_var("SELECT COUNT(*)  FROM  $table_hrmgt_attendance WHERE employee_id=".$data['employee_id'] ." AND attendance_date='$ckkdata'");
			if($AttCheak <= 0){			
				$month =  date('n',strtotime($data['attendance_date']));
				$year =  date('Y',strtotime($data['attendance_date']));			
				$attendanceDay =  date('j',strtotime($data['attendance_date']));
				if(isset($data['signout_time']))
				{
						$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
						$sql = "SELECT COUNT(*) FROM $tbl_name WHERE employee_id=".$data['employee_id']." AND month=$month AND year=$year";
						
					$count = $wpdb->get_var($sql);
					if($count==0){				
						$this->hrmgt_save_attendance_details($data['employee_id'],$attendanceDay,$month,$year,'dayin');
						$AttDate =$year.'-'.$month.'-'.$attendanceDay;						
						$dayStatus = $this->WorkTimeStatus(strtotime($workinghours),$AttDate,$attendanceDay);						
						$lastid = $wpdb->insert_id;
						$AtteInfo['manual']=0;
						$AtteInfo['status']=$dayStatus;
						$AtteInfo['attendancedetailid']=$lastid;
						$AtteInfo['data']=$data['employee_id'].'/'.$attendanceDay.'/'.$month.'/'.$year;	
						
						$this->update_attendance_details($AtteInfo);
							
					} else {				
						$this->hrmgt_save_attendance_details($data['employee_id'],$attendanceDay,$month,$year,'dayout',$workinghours);
					}
				}
				else
				{
					$this->hrmgt_save_attendance_details($data['employee_id'],$attendanceDay,$month,$year,'dayin');
				}
				$result=$wpdb->insert( $table_hrmgt_attendance, $attendancedata );			
				return $result;
			}

		}	
	}
	
	public function get_all_attendance($AtttInfo)
{		
	$PreEmpS =array();
	$AllEmpID =array();
	$Present_emp_id =array();
	$AbsIds =array();
	global $wpdb;
	$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
	$HalfDayHours = get_option('half_working_hour');			
	if($AtttInfo['status']=="absent")
	{
		
 		$PreEmpID = array();
		$users= hrmgt_get_working_user('employee');
		foreach($users as $key=>$val)
		{
			$AllEmpID[] = $val->ID;
		}	
		if($AtttInfo['attendance_date']==date("Y-m-d"))
		{			
			$AbsEmpID = $wpdb->get_results("SELECT employee_id FROM {$table_hrmgt_attendance} WHERE attendance_date='{$AtttInfo['attendance_date']}' AND (working_hours <='{$HalfDayHours}' AND working_hours !='') ");			
			$PreEmpID = $wpdb->get_results("SELECT employee_id FROM $table_hrmgt_attendance WHERE attendance_date='".$AtttInfo['attendance_date']."'");
			
		}
		else
		{			
			$AbsEmpID = $wpdb->get_results("SELECT employee_id FROM $table_hrmgt_attendance WHERE attendance_date='".$AtttInfo['attendance_date']."' AND working_hours <='$HalfDayHours'");		
			$PreEmpID = $wpdb->get_results("SELECT employee_id FROM $table_hrmgt_attendance WHERE attendance_date='".$AtttInfo['attendance_date']."'");	
			
		}
		
		if($PreEmpID != null || !empty($PreEmpID))
		{
			foreach($PreEmpID as $key=>$PreId)
			{
				$PreEmpS[]=	$PreId->employee_id;		
			}
		}
		
		
		if($AbsEmpID != null || !empty($AbsEmpID))
		{
			foreach($AbsEmpID as $key=>$AbsId)
			{	
				$AbsIds[] =	$AbsId->employee_id;		
			}
		}
			
		foreach($PreEmpID as $PreId)
		{
			$PreEmpS[]=	$PreId->employee_id;		
		}
		
		$AllAbs  = array_diff($AllEmpID,$PreEmpS);			
		$result = array_merge($AllAbs,$AbsIds);		
	}
	else
	{			
		$role = hrmgt_get_user_role(get_current_user_id());	
		if($role=='employee')
		{
			
			//$HalfDayHours =  substr($HalfDayHours,1);
			//$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance where employee_id=".get_current_user_id()." and attendance_date='".$AtttInfo['attendance_date']."'  AND  working_hours >='$HalfDayHours'");
			$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance where employee_id=".get_current_user_id()." and attendance_date='".$AtttInfo['attendance_date']."'");
		
		}
		else
		{ 
			
			if($AtttInfo['attendance_date'] == date("Y-m-d"))
			{				
				$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance WHERE attendance_date='".$AtttInfo['attendance_date']."' AND  (working_hours >='$HalfDayHours' OR signout_time ='')");
			}
			else
			{			
				$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance WHERE attendance_date='".$AtttInfo['attendance_date']."' AND  (working_hours >='$HalfDayHours' AND signout_time !='')");
			}				
		 }			 
	}
	return $result;			
}

	public function hrmgt_get_single_attendance($id)
	{
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_attendance where id=".$id);
		return $result;
	}
	/* public function get_all_currat_day_attendance($date,$role)
	{
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		if($role=="employee")
		{
			$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance WHERE attendance_date ='$date' AND signout_time='' AND employee_id=".get_current_user_id());
		}
		else
		{
			$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance WHERE attendance_date ='$date' AND signout_time=''");
		}
		
		return $result;
	} */

	public function hrmgt_delete_attendancet($id)
	{
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_attendance where id= ".$id);
		return $result;
	}
	public function hrmgt_get_attendance($empid)
	{
		$date = date('m');
		global $wpdb;
		$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
		$result =$wpdb->get_results("SELECT * FROM $table_hrmgt_attendance where employee_id=$empid and MONTH(attendance_date) = {$date}");
		return $result;
	}
}
?>