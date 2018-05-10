<?php
class HrmgtHoliday extends HrmgtAttendanceDetails
{	
	
	public function hrmgt_add_holiday($data)
	{
		global $wpdb;
		$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';
		$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
		$holidaydata['holiday_title']=$data['holiday_title'];
		$holidaydata['start_date']=$data['start_date'];
		$holidaydata['end_date']=$data['end_date'];
		$holidaydata['description']=$data['description'];		
		$holidaydata['created_by']=get_current_user_id();
		
		
		if($data['action'] == 'edit')
		{			
			$strStatDate  	=  	strtotime($data['start_date']);
			$strEndDate  	=  	strtotime($data['end_date']);
			$startMonth 	= 	date("m",$strStatDate);
			$StartYear 		= 	date("Y",$strStatDate);
			$endtMonth 		= 	date("m",$strEndDate);			
			
			$begin 	= 	new DateTime($data['start_date']);
			$end 	= 	new DateTime($data['end_date'] ."+1 day");
			$daterange 	= 	new DatePeriod($begin, new DateInterval('P1D'), $end);

			$hiddenbegin 	= 	new DateTime($data['hidden_start_date']);
			$hiddenend 	= 	new DateTime($data['hidden_end_date'] ."+1 day");
			$hidden_daterange 	= 	new DatePeriod($hiddenbegin, new DateInterval('P1D'), $hiddenend);
			
			
			foreach($hidden_daterange as $hiddendate)
			{
				//$newDates[] =  strtotime($date->format("Y-m-d"));
				$hiddennewDates[] =  $hiddendate->format("Y-m-d");
			}
			
			foreach($daterange as $date)
			{
				//$newDates[] =  strtotime($date->format("Y-m-d"));
				$newDates[]   =  $date->format("Y-m-d");
			}
			
			$AddHoliday     =  array_diff($newDates,$hiddennewDates);
			$RemoveHoliday  =  array_diff($hiddennewDates,$newDates);
			
			foreach($RemoveHoliday as $remove)
			{	
				$strHoliday 	= strtotime($remove);				
				$Where['month'] = date("m",$strHoliday);
				$Where['year'] 	= date("Y",$strHoliday);
				$day = date('j', $strHoliday);							
				$RemoveHolidays["day_{$day}"] = "A";
				$updateAttendance = $wpdb->update($tbl_name,$RemoveHolidays,$Where);				
			}
			
			
			foreach($AddHoliday as $add)
			{	
				$straddHoliday 	= strtotime($add);				
				$Where['month'] = date("m",$straddHoliday);
				$Where['year'] 	= date("Y",$straddHoliday);
				$day = date('j', $straddHoliday);							
				$AddHolidays["day_{$day}"] = "H";
				$updateAttendance = $wpdb->update($tbl_name,$AddHolidays,$Where);				
			}
			
			$month = date("m",strtotime($data['start_date']));
			$year  = date("Y",strtotime($data['start_date']));
			$AllAttRecord = $this->get_all_attendance_deatail(array('emplyee'=>'All','date'=>$month.'-'.$year));
		
		
		
		$wheredata['month'] = date("m",strtotime($data['start_date']));
		$wheredata['year']  = date("Y",strtotime($data['start_date']));
		
	foreach($AllAttRecord as $record)
	{
		$employee_id = $record->employee_id;	
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
	
		$payable_days 	= 	$total_present + $used_pl;		
		$AttCountData["total_aa"]	 = 	$aa;
		$AttCountData['tatal_present']	=	$presents;
		$AttCountData['tatal_absent']	=	$absents;
		$AttCountData['total_hl']		=	$half_days;
		$AttCountData['tatal_holidy']	=	$holidays;
		$AttCountData['total_p_p']		=	$p_p;	
		$AttCountData["opening_pl"] 	= 	$last_month_balance;		
		$AttCountData["used_pl"] 		= 	$used_pl;
		$AttCountData["remaining_pl"] 	= 	$remaining_pl;
		$AttCountData["payable_days"] 	= 	$payable_days;		
		$AttCountData["payable_days"] 	= 	$payable_days;		
		
		$AttCountData = $wpdb->update($tbl_name,$AttCountData,$wheredata);
	}	
			
			/* $OldHoliday = $this->get_current_month_holidy($startMonth,$StartYear);
			if($OldHoliday)
			{
				foreach($OldHoliday as $Holiday)
				{					
					$Oldbegin = new DateTime($Holiday->start_date);
					$Oldend = new DateTime($Holiday->end_date ."+1 day");					
					// $Oldbegin = new DateTime("2017-10-09");
					// $Oldend = new DateTime("2017-10-14");
					$olddaterange = new DatePeriod($Oldbegin, new DateInterval('P1D'), $Oldend);
					
					foreach($olddaterange as $olddate)
					{
						$OldDates[] =  strtotime($olddate->format("Y-m-d"));
					}	 			
				}				
			} */
			
			/* $AllNewHol = array_unique(array_merge($newDates,$OldDates));
			var_dump($AllNewHol);
			var_dump($OldDates);
			var_dump($newDates); */
			
			/* foreach($AllNewHol as $holiday)
			{							
				$strHoliday 	= $holiday;
				$Where['month'] = date("m",$strHoliday);
				$Where['year'] 	= date("Y",$strHoliday);
				$day = date('j', $strHoliday);							
				$AddHoliday["day_{$day}"] = "H";
				$updateAttendance = $wpdb->update($tbl_name,$AddHoliday,$Where);
			}
			die;
			 */
			/* if(isset($data['hidden_end_date']))
			{
				$end_date = strtotime($data['end_date']);
				$hidden_end_date = strtotime($data['hidden_end_date']);
				if($end_date < $hidden_end_date)
				{					
					$period = new DatePeriod(new DateTime($data['end_date'] .' +1 day'), new DateInterval('P1D'), new DateTime($data['hidden_end_date'] .' +1 day'));
					foreach ($period as $date)
					{			
						$HolidayRemove[] = $date->format("Y-m-d");
					}	
					if($HolidayRemove)
					{
						foreach($HolidayRemove as $holiday)
						{							
							$strHoliday 	= strtotime($holiday);
							$Where['month'] = date("m",$strHoliday);
							$Where['year'] 	= date("Y",$strHoliday);
							$day = date('j', $strHoliday);							
							$RemoveHoliday["day_{$day}"] = "A";
							$updateAttendance = $wpdb->update($tbl_name,$RemoveHoliday,$Where);
						}
					}
				}				
			}
			
			if(isset($data['hidden_start_date']))
			{
				$start_date = strtotime($data['start_date']);
				$hidden_start_date = strtotime($data['hidden_start_date']);
				if($start_date > $hidden_start_date)
				{					
					$period = new DatePeriod(new DateTime($data['hidden_start_date']), new DateInterval('P1D'), new DateTime($data['start_date']));
					foreach ($period as $date)
					{			
						$HolidayRemove[] = $date->format("Y-m-d");
					}	
					
					if($HolidayRemove)
					{						
						foreach($HolidayRemove as $holiday)
						{							
							$strHoliday 	= strtotime($holiday);
							$Where['month'] = date("m",$strHoliday);
							$Where['year'] 	= date("Y",$strHoliday);
							$day = date('j', $strHoliday);							
							$RemoveHoliday["day_{$day}"] = "A";
							$updateAttendance = $wpdb->update($tbl_name,$RemoveHoliday,$Where);
						}
					}
				}				
			} */
		
	
			
			$holiday_id = $data['holiday_id'];			
			/* $dates = strtotime($OldHolidyRow->end_date);
			$OldEndDay = $dates-86400; */
			$OldHolidyRow = $wpdb->get_row("SELECT * FROM $table_hrmgt_holiday WHERE id=$holiday_id");			
			$whereid['id']=$data['holiday_id'];
			$result=$wpdb->update( $table_hrmgt_holiday, $holidaydata ,$whereid);			
			return $result;
		}
		else
		{		
			$this->add_holidy_entry_in_attendance_details($data['start_date'],$data['end_date']);	
			$result=$wpdb->insert( $table_hrmgt_holiday, $holidaydata );
			return $result;
		}
	}
	
	
	public function get_all_holidays($year)
	{		
		global $wpdb;
		$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';
		//print "SELECT * FROM $table_hrmgt_holiday  WHERE YEAR(start_date)=$year AND YEAR(end_date)=$year"; die;
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_holiday  WHERE YEAR(start_date)=$year OR YEAR(end_date)=$year");
		return $result;	
	}
	
	
	public function hrmgt_get_single_holidays($id)
	{
		global $wpdb;
		$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_holiday where id=".$id);
		return $result;
	}
	
	
	public function hrmgt_delete_holidays($id)
	{	
		global $wpdb;
		$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';
		$HolidaData = $this->hrmgt_get_single_holidays($id);
		$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
		
		
		$begin 	= 	new DateTime($HolidaData->start_date);
		$end 	= 	new DateTime($HolidaData->end_date ."+1 day");
		$daterange 	= 	new DatePeriod($begin, new DateInterval('P1D'), $end);
		foreach($daterange as $date)
		{
			$newDates[]   =  $date->format("Y-m-d");
		}
		
		foreach($newDates as $remove)
		{	
			$strHoliday 	= strtotime($remove);				
			$Where['month'] = date("m",$strHoliday);
			$Where['year'] 	= date("Y",$strHoliday);
			$day = date('j', $strHoliday);							
			$RemoveHolidays["day_{$day}"] = "A";
			$updateAttendance = $wpdb->update($tbl_name,$RemoveHolidays,$Where);				
		}
		
		
		$month = date("m",strtotime($HolidaData->start_date));
		$year  = date("Y",strtotime($HolidaData->start_date));
		$AllAttRecord = $this->get_all_attendance_deatail(array('emplyee'=>'All','date'=>$month.'-'.$year));		
		
		$wheredata['month'] = date("m",strtotime($HolidaData->start_date));
		$wheredata['year']  = date("Y",strtotime($HolidaData->start_date));
		
		foreach($AllAttRecord as $record)
		{
			$employee_id = $record->employee_id;	
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
		
			$payable_days 	= 	$total_present + $used_pl;		
			$AttCountData["total_aa"]	 = 	$aa;
			$AttCountData['tatal_present']	=	$presents;
			$AttCountData['tatal_absent']	=	$absents;
			$AttCountData['total_hl']		=	$half_days;
			$AttCountData['tatal_holidy']	=	$holidays;
			$AttCountData['total_p_p']		=	$p_p;	
			$AttCountData["opening_pl"] 	= 	$last_month_balance;		
			$AttCountData["used_pl"] 		= 	$used_pl;
			$AttCountData["remaining_pl"] 	= 	$remaining_pl;
			$AttCountData["payable_days"] 	= 	$payable_days;		
			$AttCountData["payable_days"] 	= 	$payable_days;			
			$AttCountDataa = $wpdb->update($tbl_name,$AttCountData,$wheredata);			
		}
			
		$result = $wpdb->query("DELETE FROM $table_hrmgt_holiday where id= ".$id);	
		return $result;
	}
	
	
	
	public function add_holidy_entry_in_attendance_details($holiday_start_date,$holiday_end_date)
	{	
		global $wpdb;
		$tbl_name = $wpdb->prefix .'hrmgt_attendance_details';
		$employeedata = hrmgt_get_working_user('employee');
		$start = $holiday_start_date;
		$end   = $holiday_end_date;
		$holiday_start_date = strtotime($holiday_start_date);
		$month = date('n',$holiday_start_date);
		$year  = date('Y',$holiday_start_date);
		$holiday_end_date = strtotime($holiday_end_date);
		
		/* if(!empty($employeedata))
		{
			foreach($employeedata as $employee)
			{
				$employee_id = $employee->ID;
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
						if($day_name == "Sunday")
						{
							$Attendacedata["day_{$day}"] = "H";
						}
						else
						{
							$Attendacedata["day_{$day}"] = "A";								
						}
					}
					$result = $wpdb->insert($tbl_name,$Attendacedata);																	
				}				
			}			
		} */

		for ($i=$holiday_start_date; $i<=$holiday_end_date; $i+=86400) 
		{
			$day =  date('j',$i);
			$wheredata['month'] =  date('n',$i);
			$wheredata['year'] =  date('Y',$i);				
			$updateAttendanceDetails["day_$day"]="H";
			$holidydata = $wpdb->get_row("SELECT tatal_holidy FROM $tbl_name WHERE month=$month AND year=$year");			
			$wpdb->update($tbl_name,$updateAttendanceDetails,$wheredata);			
		}
		
		$month = date("m",strtotime($start));
		$year  = date("Y",strtotime($end));
		$AllAttRecord = $this->get_all_attendance_deatail(array('emplyee'=>'All','date'=>$month.'-'.$year));		
		
		$wheredata['month'] = date("m",strtotime($start));
		$wheredata['year']  = date("Y",strtotime($end));
		
		foreach($AllAttRecord as $record)
		{
			$employee_id = $record->employee_id;	
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
		
			$payable_days 	= 	$total_present + $used_pl;		
			$AttCountData["total_aa"]	 = 	$aa;
			$AttCountData['tatal_present']	=	$presents;
			$AttCountData['tatal_absent']	=	$absents;
			$AttCountData['total_hl']		=	$half_days;
			$AttCountData['tatal_holidy']	=	$holidays;
			$AttCountData['total_p_p']		=	$p_p;	
			$AttCountData["opening_pl"] 	= 	$last_month_balance;		
			$AttCountData["used_pl"] 		= 	$used_pl;
			$AttCountData["remaining_pl"] 	= 	$remaining_pl;
			$AttCountData["payable_days"] 	= 	$payable_days;		
			$AttCountData["payable_days"] 	= 	$payable_days;			
			$AttCountDataa = $wpdb->update($tbl_name,$AttCountData,$wheredata);
		}	
	}
	
	
	public function get_current_month_holidy($month,$year)
	{
		global $wpdb;
		$table_hrmgt_holiday = $wpdb->prefix. 'hrmgt_holiday';		
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_holiday  WHERE MONTH(start_date)=$month AND YEAR(start_date)=$year");	
		return $result;
	}
	
	

}
?>