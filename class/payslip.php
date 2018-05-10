<?php
class HrmgtPayslip
{
	
	public function hrmgt_get_approve_attendace()
	{
		global $wpdb;
		$table_hrmgt_attendance_details = $wpdb->prefix. 'hrmgt_attendance_details';
		//$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance_details where approval_status=1");
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_attendance_details ORDER BY id DESC");
		return $result;
	}
	
	public function hrmgt_get_generated_slip()
	{
		global $wpdb;
		$table_hrmgt_generated_salary_slip = $wpdb->prefix. 'hrmgt_generated_salary_slip';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_generated_salary_slip");
		return $result;
	}
	public function hrmgt_get_single_generated_slip($id)
	{
		global $wpdb;
		$table_hrmgt_generated_salary_slip = $wpdb->prefix. 'hrmgt_generated_salary_slip';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_generated_salary_slip WHERE id=$id");
		return $result;
	}
	public function hrmgt_delete_paylisp($id)
	{
		global $wpdb;
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_generated_salary_slip';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_project where id= ".$id);
		return $result;
	}
	public function hrmgt_get_generated_slip_by_user_id($id)
	{
	   // var_dump($id);die;
		global $wpdb;
		$table_hrmgt_generated_salary_slip = $wpdb->prefix. 'hrmgt_generated_salary_slip';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_generated_salary_slip where employee_id=$id");
		
		return $result;
	}
}
?>