<?php
class HrmgtAttendanceDetails 
{	
	
public function hrmgt_save_attendance_details($employee_id,$attendanceDay,$month,$year,$action=null,$working_hours=null)
{
	global $wpdb;
	$AttendaceHoliday=array();
	$MonthHoliday = array();
	$AttDate = $year.'-'.$month.'-'.$attendanceDay;		
	
	$full_day = get_option('full_working_hour');
	$half_day = get_option('half_working_hour');
		
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
	$tbl_attendance = $wpdb->prefix .'hrmgt_attendance';
	
	$MohtHoliday = hrmgt_get_current_month_holidy($month,$year);
	
	foreach($MohtHoliday as $holiday)
	{		
		$period = new DatePeriod(new DateTime($holiday->start_date), new DateInterval('P1D'), new DateTime($holiday->end_date .' +1 day'));
		foreach ($period as $date)
		{			
			$MonthHoliday[] = strtotime($date->format("Y-m-d"));
		}		
	}	
	if($action=="dayin")
	{
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
			$Attendacedata['approval_status']="0";
			
			$start_date = "01-".$month."-".$year;
			$start_time = strtotime($start_date);
			$end_time = strtotime("+1 month", $start_time);			
		
			for($i=$start_time; $i<$end_time; $i+=86400)
			{				
				$day = date('j', $i);			
				$day_name = date('l', $i);
				if($day_name == "Sunday" || in_array($i,$MonthHoliday))
				{					
					$Attendacedata["day_{$day}"] = "H";
				}				
				else
				{
					$Attendacedata["day_{$day}"]= "A";								
				}	  
			}		
			$result = $wpdb->insert($tbl_name,$Attendacedata);								
		}
	}
	else
	{
		$wheredata['employee_id']=$employee_id;			
		$wheredata['month']=$month;	
		$wheredata['year']=$year;
		$start_date = "01-".$month."-".$year;
		$start_time = strtotime($start_date);		
		$end_time = strtotime("+1 month", $start_time);
			
			
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
			$Attendacedata['approval_status']="0";
			
			/* $start_date = "01-".$month."-".$year;
			$start_time = strtotime($start_date);
			$end_time = strtotime("+1 month", $start_time); */			
		
			for($i=$start_time; $i<$end_time; $i+=86400)
			{						
				$day_name = date('l', $i);
				if($day_name == "Sunday" || in_array($i,$MonthHoliday))
				{					
					$Attendacedata["day_{$day}"] = "H";
				}				
				else
				{
					$Attendacedata["day_{$day}"]= "A";									
				}				
			}			
			$result = $wpdb->insert($tbl_name,$Attendacedata);								
		}	
		
		for($i=$start_time; $i<$end_time; $i+=86400)
		{	
			$day = date('j', $i);							
			$day_name = date('l', $i);					
			if(in_array($i,$MonthHoliday) || $day_name == "Sunday")
			{	
				$AttendaceHoliday["day_{$day}"] = "H";	
				$updateAttendance = $wpdb->update($tbl_name,$AttendaceHoliday,$wheredata);
			} 				
		}		 
	
		
		
		$status = $this->WorkTimeStatus(strtotime($working_hours),$AttDate,$attendanceDay);		
		$AttDayName = date("D",strtotime($AttDate));	
		$Attendaceupdate["day_{$attendanceDay}"]=$status;			
			
		if($AttDayName=="Mon")
		{
			$DayStatus = get_attendance_status_by_date($AttDate,$employee_id);
			if($status=="A")
			{
				if(date("j",strtotime($AttDate))=="1" && $month!=1)
				{
					$month = $month-1;
					$SatarDay = 29;
				} 
				else if($month=="1")
				{				
					$month = 12;
					$year = $year - 1;
					$SatarDay = 30;
				}	
				else		
				{
					$SatarDay = $attendanceDay-2;
				}				
				$suterdaydate = $year.'-'.$month.'-'.$SatarDay;			
				$SatDayName = date("D",strtotime($suterdaydate));
				if($SatDayName=="Sat")
				{
					$DayStatus = get_attendance_status_by_date($suterdaydate,$employee_id);				
					if($DayStatus=="A")
					{
						$Sunday = $attendanceDay-1;					
						$Attendaceupdate["day_{$Sunday}"]="AA";
						$updateAttendance = $wpdb->update($tbl_name,$Attendaceupdate,$wheredata);
					}
				}
			}
			else
			{
				$updateAttendance = $wpdb->update($tbl_name,$Attendaceupdate,$wheredata);
			}
		}
		else
		{
			$updateAttendance = $wpdb->update($tbl_name,$Attendaceupdate,$wheredata);
		}
		
		$last_month_balance = $this->get_leave_balance($employee_id,$month,$year);
		//$monthly_leave = get_user_meta( $employee_id,'monthly_leave',true);	
		$monleave = hrmgt_get_emp_pl($employee_id,$month,$year);
		$pl = "month_".$month;
		$monthly_leave = $monleave->$pl;
		
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
		$absents = $total_present["A"];
		$manual_absents = (isset($total_present["manual_A"])) ? $total_present["manual_A"] : 0;
		$absents = $this->hrmgt_get_absent(date('d'),$month,$year,$employee_id);	
		$holidays = isset($total_present["H"]) ? $total_present["H"] : 0;
		$manual_holidays = (isset($total_present["manual_H"])) ? $total_present["manual_H"] : 0;
		$holidays = $holidays + $manual_holidays;
		$p_p = isset($total_present["P.5"]) ? $total_present["P.5"] : 0;
		$manual_p_p = (isset($total_present["manual_P.5"])) ? $total_present["manual_P.5"] : 0;
		$p_p = $p_p + $manual_p_p;
	
				
		$total_present = ($presents != 0  ) ? $presents + $holidays +($p_p * 1.5): 0;  
		$total_present = $total_present + ($half_days * 0.5);
	

		$pl_balance = $last_month_balance + $monthly_leave;
		$remaining_pl = $pl_balance - $absents;
	
		if($remaining_pl >= 0 )
		{
			$used_pl = $absents;
		}
		else
		{
			$remaining_pl = 0;
			$used_pl = $pl_balance;
		}
		
		$payable_days = $total_present + $used_pl;		
		$AttCountData["total_aa"] = $aa;
		$AttCountData['tatal_present']=$presents;
		$AttCountData['tatal_absent']=$absents;
		$AttCountData['total_hl']=$half_days;
		$AttCountData['tatal_holidy']=$holidays;
		$AttCountData['total_p_p']=$p_p;	
		$AttCountData["opening_pl"] = $last_month_balance;		
		$AttCountData["used_pl"] = $used_pl;
		$AttCountData["remaining_pl"] = $remaining_pl;
		$AttCountData["payable_days"] = $payable_days;		
		$AttCountDatas = $wpdb->update($tbl_name,$AttCountData,$wheredata);
		
	}

} // close main function..

public function get_single_attendance_deatail($AttendaceDetailID)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
	return $result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE id=$AttendaceDetailID");	
}

public function update_attendance_details($attendanceinfo)
{	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';	
	$status=$attendanceinfo['status'];
	$detail_id=$attendanceinfo['attendancedetailid'];	
	$AttInfo = explode('/',$attendanceinfo['data']);	
	$employee_id = $AttInfo[0];
	$day = $AttInfo[1];
	$month = $AttInfo[2];
	$year = $AttInfo[3];
	if( isset($attendanceinfo['manual']) && $attendanceinfo['manual']=='0')
	{
		$AttendanceDetailsData['day_'.$day]=$status;
	}
	else 
	{
		$AttendanceDetailsData['day_'.$day]='manual_'.$status;
	}
	$whereid['id']=$detail_id;	
	$wpdb->update($tbl_name,$AttendanceDetailsData,$whereid);	
	
	$last_month_balance = $this->get_leave_balance($employee_id,$month,$year);
	//$monthly_leave = get_user_meta( $employee_id,'monthly_leave',true);
	
	//$monleave = hrmgt_get_emp_pl($employee_id,$month,$year);
	//$pl = "month_".$month;
	//$monthly_leave = $monleave->$pl;
	$monthly_leave = hrmgt_get_emp_pl($employee_id,$month,$year);
		

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
	

	
	
	$absents = $total_present["A"];
	$manual_absents = (isset($total_present["manual_A"])) ? $total_present["manual_A"] : 0;
	
	$absents = $this->hrmgt_get_absent(date('d'),$month,$year,$employee_id);	
	
	

	$holidays = isset($total_present["H"]) ? $total_present["H"] : 0;
	$manual_holidays = (isset($total_present["manual_H"])) ? $total_present["manual_H"] : 0;
	$holidays = $holidays + $manual_holidays;

	
	$p_p = isset($total_present["P.5"]) ? $total_present["P.5"] : 0;
	$manual_p_p = (isset($total_present["manual_P.5"])) ? $total_present["manual_P.5"] : 0;
	$p_p = $p_p + $manual_p_p;
	
	
	
	$total_present = ($presents != 0  ) ? $presents + $holidays +($p_p * 1.5) : 0; /* Dont include holiday as present if absent whole month*/
	$total_present = $total_present + ($half_days * 0.5);
	

	$pl_balance = $last_month_balance + $monthly_leave;
	
	$remaining_pl = $pl_balance - $absents;
	
	if($remaining_pl >= 0 )
	{	
		$used_pl = $absents;	
	}
	else 
	{
		$remaining_pl = 0;
		$used_pl = $pl_balance;		
	}
	
	$payable_days = $total_present + $used_pl;	
	$AttCountData["payable_days"] = $payable_days;
	$AttCountData['tatal_present']=$presents;
	$AttCountData['total_aa']=$aa;
	$AttCountData['total_p_p']=$p_p;
	$AttCountData['tatal_absent']=$absents;
	$AttCountData['total_hl']=$half_days;
	$AttCountData['tatal_holidy']=$holidays;			
	$AttCountData["opening_pl"] = $last_month_balance;		
	$AttCountData["used_pl"] = $used_pl;
	$AttCountData["remaining_pl"] = $remaining_pl;	
	$AttCountDataResult = $wpdb->update($tbl_name,$AttCountData,$whereid);
	
}


public function get_all_attendance_deatail($data)
{	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
	 $date = '01-'.$data['date'];	
	 $month = date('n', strtotime($date));
	 $year = date('Y', strtotime($date));		
	 
	if($data['emplyee']=="All")
	{
		$sql = "SELECT * FROM $tbl_name WHERE month={$month} AND year={$year}";
	}
	else
	{
		$sql = "SELECT * FROM $tbl_name WHERE month={$month} AND year={$year} AND employee_id={$data['emplyee']}";
	}
	return $result = $wpdb->get_results($sql);
}
public function get_date_wise_attendance_deatail($data)
{	
	 $date = '01-'.$data['date'];	
	 $month = date('n', strtotime($date));
	 $year = date('Y', strtotime($date));		
	 global $wpdb;
	 $tbl_name = $wpdb->prefix .'hrmgt_attendance_details';	
	
	if(isset($data['employee_id']))
	{
		if($data['employee_id']=="All")
		{
			$sql = "SELECT * FROM $tbl_name WHERE month={$month} AND year={$year}";
		}
		else
		{
			$sql = "SELECT * FROM $tbl_name WHERE month={$month} AND year={$year} AND employee_id={$data['employee_id']}";
		}
	}
	else
	{
		 $sql = "SELECT * FROM $tbl_name WHERE month={$month} AND year={$year}";
	}
	$result = $wpdb->get_results($sql);
	return $result;
}

function get_today_working_hour($employee_id)
{
	global $wpdb;	
	$date = date("Y-m-d");
	$tbl_attendance = $wpdb->prefix .'hrmgt_attendance';
	$row = $wpdb->get_row("SELECT * FROM $tbl_attendance WHERE employee_id=$employee_id AND attendance_date='$date'");
	return $row->working_hours;
	
}


function get_total_present_days($employee_id,$month,$year)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
	$row = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");
	return $row->tatal_present;
}


function WorkTimeStatus($workingtime,$AttDate,$attendanceDay)
{		
	$half_day_work_hour = strtotime(get_option('half_working_hour'));
	$full_day_work_hour = strtotime(get_option('full_working_hour'));
		
	$MonthLatter = date('M',strtotime($AttDate));			
	$year = date('Y',strtotime($AttDate));			
	$SatDayTwo =  showDay($MonthLatter,$year,'saturday', 1111);
	$SatDayForth =  showDay($MonthLatter,$year,'saturday', 1111);
				
	if($attendanceDay==$SatDayTwo || $attendanceDay==$SatDayForth)
	{
		if($workingtime >=$full_day_work_hour)
		{
			$DayStatus ="P.5";
		}
		elseif($workingtime >= $half_day_work_hour)
		{
			$DayStatus ="P";
		}
		else
		{
			$DayStatus ="A";
		}
	}
	else
	{	
		if($workingtime < $half_day_work_hour)
		{		
			$DayStatus ="A";		
		}
		elseif($workingtime >= $half_day_work_hour && $workingtime < $full_day_work_hour)
		{
			$DayStatus= "HL";
		}	
		else
		{
			$DayStatus= "P";
		}
	}	
	return $DayStatus;
}

function get_leave_balance($employee_id,$month,$year )
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';	
	$leave_balance = "";
	if($month == 1)
	{
		$month = 12;
		$year = $year - 1;
	}
	else
	{
		$month = $month - 1;		
	}

	$cnt = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");
	
	if($cnt == 1)
	{
		$leave_data= $wpdb->get_row("SELECT remaining_pl FROM $tbl_name WHERE employee_id=$employee_id AND month=$month AND year=$year");
		if($leave_data->remaining_pl == "")
		{
			$leave_balance  = 0;
		}
		else
		{
			$leave_balance = $leave_data->remaining_pl;
		}
	}	
	else
	{
		$leave_balance =0;		
	} 
	return $leave_balance;  
}


public function hrmgt_get_absent($day,$month,$year,$employee_id)
{
	global $wpdb;
	$tbl_attendance = $wpdb->prefix .'hrmgt_attendance_details';
	if($month!= date('m'))
	{
		$day=cal_days_in_month(CAL_GREGORIAN,$month,$year);	
	}	 
	$sqla = "SELECT ";
	for($i=1;$i<=$day;$i++)
	{
		$sqla .= "day_$i,";
	}
	$sqa = rtrim($sqla,',');
	$query =  $sqa ." FROM $tbl_attendance WHERE month=$month AND year=$year AND employee_id=$employee_id";

	$count = $wpdb->get_row($query,ARRAY_A); 
	$count = array_count_values($count);
	$Total_A = isset($count['A'])?$count['A']:0;	
	$Total_MA = isset($count['manual_A'])?$count['manual_A']:0;
	$TotalAbs = $Total_A + $Total_MA;
	return $TotalAbs;
	
}


public function get_monthly_working_hour($emp_id,$month,$year){
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance';	
	 $sql = "SELECT working_hours FROM $tbl_name  WHERE EXTRACT(YEAR FROM attendance_date)='$year' AND EXTRACT(MONTH FROM attendance_date)='$month' AND employee_id=$emp_id";
	$Hours = $wpdb->get_results($sql);
	$time = array();
	foreach($Hours as $key=>$hour){
		$time[] = $hour->working_hours .':00';
	}
	
	$seconds = $mins = $hours = array();
	foreach($time as $tk => $tv) {	
		$tv_parts = explode(":", $tv);
		$seconds[] =":00";
		$mins[] = $tv_parts['1'];
		$hours[] = $tv_parts['0'];
	}
	$ts = array_sum($seconds);
	$tm = array_sum($mins);
	$th = array_sum($hours);

	if($ts > 59) {
		$ts = $ts % 60;
		$tm = $tm + floor($ts / 60);
	}
	if($tm > 59) {
		$tm = $tm % 60;
		$th = $th + floor($tm / 60);
	}
	
	$th = str_pad($th, 2, "0", STR_PAD_LEFT);
	$tm = str_pad($tm, 2, "0", STR_PAD_LEFT);
	$ts = str_pad($ts, 2, "0", STR_PAD_LEFT);


	return "$th:$tm"; 
	
}


function get_outof_working_hour($emp_id,$month,$year)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
	$row = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id=$emp_id AND month=$month AND year=$year",ARRAY_A);
	
	$count = array_count_values(array_filter($row));	
	$Holiday_H = isset($count['H'])?$count['H']:0;
	$Holiday_MH = isset($count['manual_H'])?$count['manual_H']:0;
	
	$TotalHoliday = $Holiday_H + $Holiday_MH;	
	$MonthDays=cal_days_in_month(CAL_GREGORIAN,$month,$year);	
	$WorkingDay = $MonthDays-$TotalHoliday;
	return $WorkingDay * 9;
}

}

?>