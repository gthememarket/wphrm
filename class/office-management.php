<?php
class HrmgtOfficeMgt{	
	public function hrmgt_add_task($data){
		global $wpdb;
		$table_hrmgt_task_tracker = $wpdb->prefix. 'hrmgt_task_tracker';
		$taskdata['employee_id']=$data['employee_id'];
		$taskdata['task_cat_id']=$data['task_cat_id'];
		$taskdata['work_title']=$data['work_title'];
		$taskdata['working_date']=date("m/d/y",strtotime($data['working_date']));
		$taskdata['start_time']=$data['start_time'];
		$taskdata['end_time']=$data['end_time'];
		$taskdata['description']=$data['description'];
		$taskdata['status']=$data['status'];
		$taskdata['created_by']=get_current_user_id();
		
		if($data['action']=='edit'){
			$whereid['id']=$data['task_id'];
			$result=$wpdb->update( $table_hrmgt_task_tracker, $taskdata ,$whereid);
			return $result;
		}
		else{
			$result=$wpdb->insert( $table_hrmgt_task_tracker, $taskdata );
			return $result;
		}
	
	}
	public function get_all_tasks(){
		global $wpdb;
		$table_hrmgt_task_tracker = $wpdb->prefix. 'hrmgt_task_tracker';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_task_tracker");
		return $result;	
	}
	
	
	
	public function get_user_tasks($id){		
		global $wpdb;
		$table_hrmgt_task_tracker = $wpdb->prefix. 'hrmgt_task_tracker';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_task_tracker WHERE employee_id=$id");
		return $result;	
	}
	
	public function hrmgt_get_single_tasks($id){
		global $wpdb;
		$table_hrmgt_task_tracker = $wpdb->prefix. 'hrmgt_task_tracker';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_task_tracker where id=".$id);
		return $result;
	}
	
	public function hrmgt_delete_tasks($id){
		global $wpdb;
		$table_hrmgt_task_tracker = $wpdb->prefix. 'hrmgt_task_tracker';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_task_tracker where id= ".$id);
		return $result;
	}

}
?>