<?php
class HrmgtCientFeedBack{	
	public function hrmgt_add_client_feedback($data)
	{			
		global $wpdb;		
		$wp_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_client_feedback';
		$hrmgt_client_feedback_meta = $wpdb->prefix. 'hrmgt_client_feedback_meta';		
		
		$feedbackdata['client_name'] = $data['client_name'];
		$feedbackdata['project_id'] = $data['project_id'];
		$feedbackdata['comment'] = $data['comment'];
		$feedbackdata['rate'] = $data['rate'];
		$feedbackdata['created_at'] = date("Y-m-d");
		$feedbackdata['created_by'] =get_current_user_id();

		if($data['action']=='edit')
		{		
			$whereid['id']=$data['cf_id'];
			$project_id = $data['cf_id'];			
			$new_feed = $data['employee_id'];			
			$old_feeddata = $this->hrmgt_get_cf_employee($data['cf_id']);			
			foreach($old_feeddata as $old_feed_key=>$old_feed_val)
			{
				$old_feed[] = $old_feed_val->employee_id;
			}			
			
			$different_insert = array_diff($new_feed,$old_feed);
			$different_delete = array_diff($old_feed,$new_feed);			
			
			if(!empty($different_insert))
			{
				 $wpdb->update( $wp_hrmgt_client_feedback, $feedbackdata ,$whereid);	
				foreach($different_insert as $key=>$val)
				{
					$feedback_meta ['project_id'] =$data['cf_id'];
					$feedback_meta ['employee_id'] =$val;
					$result = $wpdb->insert( $hrmgt_client_feedback_meta, $feedback_meta);					
				}
			}
			
			if(!empty($different_delete))
			{				
				$wpdb->update( $wp_hrmgt_client_feedback, $feedbackdata ,$whereid);			
				foreach($different_delete as $key=>$val)
				{							
					$result = $wpdb->query("DELETE FROM $hrmgt_client_feedback_meta WHERE project_id= $project_id AND employee_id=$val");					
				}
			}
			else
			{
				$result = $wpdb->update( $wp_hrmgt_client_feedback, $feedbackdata ,$whereid);	
			}			
			return $result;			
		}
		else
		{			
			$wpdb->insert( $wp_hrmgt_client_feedback, $feedbackdata );
			$feedback_metadata ['project_id'] = $wpdb->insert_id;
			if(isset($data['employee_id']))
			{
				foreach($data['employee_id'] as $key=>$val)
				{
					$feedback_metadata ['employee_id'] = $val;
					$result=$wpdb->insert( $hrmgt_client_feedback_meta, $feedback_metadata );
				}
				return $result;	
			}
		}
	}
	
	public function get_all_client_feedback(){
		global $wpdb;
		$table_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_client_feedback';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_client_feedback");
		return $result;
	
	}
	
	public function get_user_project($id){
		global $wpdb;
		$wp_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_project';
		$result = $wpdb->get_results("SELECT * FROM $wp_hrmgt_client_feedback WHERE	employee_id=$id");
		return $result;	
	}
	
	
	
	public function hrmgt_get_single_c_feedback($id){
		global $wpdb;
		$table_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_client_feedback';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_client_feedback where id=".$id);
		return $result;
	}
	public function hrmgt_delete_cf($id){
		global $wpdb;
		
		$wp_hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_client_feedback';
		$result = $wpdb->query("DELETE FROM $wp_hrmgt_client_feedback where id= ".$id);
		return $result;
	}
	public function hrmgt_get_cf_employee($project_id){			
		global $wpdb;
		$hrmgt_client_feedback_meta = $wpdb->prefix. 'hrmgt_client_feedback_meta';		
		$result = $wpdb->get_results("SELECT * FROM $hrmgt_client_feedback_meta WHERE project_id= ".$project_id);
		return $result;
	}



	public function hrmgt_get_cf_for_report($employee_id,$start_date,$end_date){			
		global $wpdb;
		$hrmgt_client_feedback_meta = $wpdb->prefix. 'hrmgt_client_feedback_meta';	
		$hrmgt_client_feedback = $wpdb->prefix. 'hrmgt_client_feedback';
		$q="SELECT * FROM $hrmgt_client_feedback_meta a INNER JOIN $hrmgt_client_feedback b ON a.project_id = b.id WHERE a.employee_id =$employee_id  AND  created_at BETWEEN '$start_date' AND '$end_date'";
		return $result =  $wpdb->get_results($q);
	}	
	

}
?>