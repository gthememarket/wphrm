<?php
class HrmgtProject{	
	public function hrmgt_add_project($data){
		global $wpdb;
	

		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$hrmgt_project_meta = $wpdb->prefix. 'hrmgt_project_meta';	
		$projectdata['project_title']=$data['project_title'];
		$projectdata['client_name']=$data['client_name'];
		$projectdata['start_date']=date("m/d/Y",strtotime($data['start_date']));
		$projectdata['end_date']=date("m/d/Y",strtotime($data['end_date']));
		$projectdata['completion_date']=date("m/d/Y",strtotime($data['completion_date']));
		$projectdata['status']=$data['status'];
		$projectdata['remark']=$data['remark'];
		$projectdata['description']=$data['description'];
		$projectdata['created_by']=get_current_user_id();
		
		if($data['action']=='edit'){			
			$whereid['id']=$data['project_id'];
			$project_id = $data['project_id'];			
			$new_pro = $data['employee_id'];
			
			
			$old_prodata = $this->hrmgt_get_project_employee($data['project_id']);
			foreach($old_prodata as $old_pro_key=>$old_pro_val)
			{
				$old_pro[] = $old_pro_val->employee_id;
			}			
			$different_insert = array_diff($new_pro,$old_pro);
			$different_delete = array_diff($old_pro,$new_pro);			
			
			if(!empty($different_insert))
			{
				 $wpdb->update( $table_hrmgt_project, $projectdata ,$whereid);	
				foreach($different_insert as $key=>$val)
				{
					$project_meta ['project_id'] =$data['project_id'];
					$project_meta ['employee_id'] =$val;
					$result = $wpdb->insert( $hrmgt_project_meta, $project_meta );
					
				}
			}
			
			if(!empty($different_delete))
			{
				$wpdb->update( $table_hrmgt_project, $projectdata ,$whereid);	
				foreach($different_delete as $key=>$val)
				{
					$result = $wpdb->query("DELETE FROM $hrmgt_project_meta where project_id= $project_id AND employee_id=$val");
					
				}
			}
			else
			{
				$result = $wpdb->update( $table_hrmgt_project, $projectdata ,$whereid);	
			}			
			return $result;			
		}
		
		
		
		else{
			$insert_pro = $wpdb->insert( $table_hrmgt_project, $projectdata );
			
			$project_meta ['project_id'] = $wpdb->insert_id;
			if($project_meta ['project_id']){
				foreach($data['employee_id'] as $key=>$val){
					$project_meta ['employee_id'] = $val;
					$result=$wpdb->insert( $hrmgt_project_meta, $project_meta );
				}
			}
			
			return $result;
			
		}
	
	}
	public function get_all_project()
	{
		global $wpdb;
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_project");
		return $result;
	
	}
	
	public function get_user_project($id){
		global $wpdb;
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$table_hrmgt_project_meta = $wpdb->prefix. 'hrmgt_project_meta';		
		$sql = "SELECT * FROM $table_hrmgt_project_meta a INNER JOIN $table_hrmgt_project b ON a.project_id=b.id WHERE a.employee_id=$id";
		$result = $wpdb->get_results($sql);
		return $result;	
	}
	
	
	
	public function get_user_project_for_report($employee_id,$start_date,$end_date){
		global $wpdb;		
		$newstart = date("m/d/Y", strtotime($start_date));
		$newend = date("m/d/Y", strtotime($end_date));			
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$table_hrmgt_project_meta = $wpdb->prefix. 'hrmgt_project_meta';
		$sql = "SELECT * FROM $table_hrmgt_project_meta a INNER JOIN $table_hrmgt_project b ON a.project_id=b.id WHERE a.employee_id=$employee_id AND (b.start_date >= '$newstart' AND b.end_date <= '$newend')";
		$result = $wpdb->get_results($sql);
		return $result;	
	}
	
	
	public function hrmgt_get_single_project($id)
	{
		global $wpdb;
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_project where id=".$id);
		return $result;
	}
	public function hrmgt_delete_project($id)
	{
		global $wpdb;
		$table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_project where id= ".$id);
		return $result;
	}
	public function hrmgt_get_project_employee($project_id){			
		global $wpdb;
		$hrmgt_project_meta = $wpdb->prefix. 'hrmgt_project_meta';				
		$result = $wpdb->get_results("SELECT * FROM $hrmgt_project_meta WHERE project_id= ".$project_id);
		return $result;
	}

}
?>