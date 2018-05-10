<?php
class PlManagement
{	
	
	public function hrmgt_manage_paidleave($data)
	{		
		global $wpdb;		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$emp_id = $data['emp_id'];
		$year = $data['year'];
		$PlData['employee_id']=$data['emp_id'];
		$PlData['year']=$data['year'];
		$PlData['month_1']=$data['month_1'];
		$PlData['month_2']=$data['month_2'];
		$PlData['month_3']=$data['month_3'];
		$PlData['month_4']=$data['month_4'];
		$PlData['month_5']=$data['month_5'];
		$PlData['month_6']=$data['month_6'];
		$PlData['month_7']=$data['month_7'];
		$PlData['month_8']=$data['month_8'];
		$PlData['month_9']=$data['month_9'];
		$PlData['month_10']=$data['month_10'];
		$PlData['month_11']=$data['month_11'];
		$PlData['month_12']=$data['month_12'];		
		$PlData['created_by']=get_current_user_id();
		$PlData['created_at']=date("Y-m-d");
		
		$result =$this->hrmgt_get_pl_by_empid_year($emp_id,$year); 		
		if($result)
		{
			$whereData['id']=$result->id;
			$result=$wpdb->update( $tbl_name, $PlData, $whereData);
		}
		else
		{
			$result=$wpdb->insert( $tbl_name, $PlData );
		}		
		return $result;
			
	}
	
	public function hrmgt_get_pl_by_empid_year($emp_id,$year)
	{
		global $wpdb;		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$result = $wpdb->get_row("SELECT * FROM $tbl_name WHERE employee_id = $emp_id AND  year=$year ");
		return $result;
	}
	public function hrmgt_get_emp_pl($emp_id,$month,$year)
	{	
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
		
		/* 				
		print $sql = 'IF EXISTS("SELECT   FROM $tbl_name WHERE employee_id = '.$emp_id.' AND year='.$year.'")';
		$result = $wpdb->get_row($sql);	
		return $result; */
	}
	public function hrmgt_get_all_pl()
	{
		global $wpdb;		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$result = $wpdb->get_results("SELECT * FROM $tbl_name");
		return $result;
		
	}
	public function hrmgt_delete_pl($pl_id)
	{
		global $wpdb;		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$result = $wpdb->query("DELETE  FROM $tbl_name WHERE id=$pl_id");
		return $result;
	}
	public function hrmgt_get_employee_pl($empID)
	{
		global $wpdb;		
		$tbl_name = $wpdb->prefix. 'hrmgt_pl_menaegment';
		$result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE employee_id=$empID");
		return $result;
	}
	
	
}
?>