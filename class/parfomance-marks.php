<?php
class HrmgtParfomanceMark
{	
	public function hrmgt_add_parfomance_marks($data){			
		global $wpdb;		
		$table_hrmgt_parfomance_marks_meta 	= 	$wpdb->prefix. 'hrmgt_parfomance_marks_meta';
		$table_hrmgt_parfomance_marks 	= 	$wpdb->prefix. 'hrmgt_parfomance_marks';		
		
		$parfomance_marksdata['project_id']=$data['project_id'];
		$parfomance_marksdata['title']=$data['title'];
		$parfomance_marksdata['mark']=$data['mark'];
		$parfomance_marksdata['period_start']=$data['period_start'];
		$parfomance_marksdata['period_end']=$data['period_end'];
		$parfomance_marksdata['description']=$data['description'];
		$parfomance_marksdata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{					
			$whereid['id']=$data['parfomance_id'];
			$performance_id = $data['parfomance_id'];			
			$new_performace = $data['employee_id'];				
			$old_performace_data = $this->hrmgt_get_performace_employee($data['parfomance_id']);
			
			foreach($old_performace_data as $old_performance_key=>$old_performance_val)
			{
				$old_performance[] = $old_performance_val->employee_id;
			} 
					
			$different_insert = array_diff($new_performace,$old_performance);
			$different_delete = array_diff($old_performance,$new_performace);
			
			
			if(!empty($different_insert))
			{			
				$wpdb->update( $table_hrmgt_parfomance_marks, $parfomance_marksdata ,$whereid);	
				foreach($different_insert as $key=>$val)
				{
					$performance_meta ['performance_id'] =$data['parfomance_id'];
					$performance_meta ['employee_id'] =$val;					
					$result = $wpdb->insert( $table_hrmgt_parfomance_marks_meta, $performance_meta );					
				}
				
			} 
			
				
			if(!empty($different_delete))
			{				
				$wpdb->update( $table_hrmgt_parfomance_marks, $parfomance_marksdata ,$whereid);			
				foreach($different_delete as $key=>$val)
				{								
					$result = $wpdb->query("DELETE FROM $table_hrmgt_parfomance_marks_meta WHERE performance_id=$performance_id AND employee_id=$val");					
				}
				
			}
			else
			{
				$result = $wpdb->update( $table_hrmgt_parfomance_marks, $parfomance_marksdata ,$whereid);	
			} 		
			return $result;		
			$result=$wpdb->update( $table_hrmgt_parfomance_marks, $parfomance_marksdata ,$whereid);
			return $result;
		}
		else
		{			
			$insert = $wpdb->insert( $table_hrmgt_parfomance_marks, $parfomance_marksdata );
			
			$parfomance_marks_metadata ['performance_id'] = $wpdb->insert_id;			
			foreach($data['employee_id'] as $key=>$val)
			{
				$parfomance_marks_metadata ['employee_id'] = $val;
				$result=$wpdb->insert( $table_hrmgt_parfomance_marks_meta, $parfomance_marks_metadata );
			}			
			return $result;		
		}
	
	}
	public function get_all_parfomance_marks()
	{
		global $wpdb;
		$table_hrmgt_parfomance_marks = $wpdb->prefix. 'hrmgt_parfomance_marks';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_parfomance_marks");
		return $result;
	
	}
	
	
	public function get_all_parfomance_marks_of_user($id){
		global $wpdb;
		$table_hrmgt_parfomance_marks = $wpdb->prefix. 'hrmgt_parfomance_marks';
		$table_hrmgt_parfomance_marks_meta = $wpdb->prefix. 'hrmgt_parfomance_marks_meta';
		$q="SELECT * FROM $table_hrmgt_parfomance_marks_meta a INNER JOIN $table_hrmgt_parfomance_marks b ON a.performance_id = b.id WHERE a.employee_id =$id";
		$result = $wpdb->get_results($q);
		return $result;
	}
	
	
	
	public function get_all_parfomance_marks_of_user_for_report($employee_id,$start_date,$end_date){
		global $wpdb;				
		$table_hrmgt_parfomance_marks = $wpdb->prefix. 'hrmgt_parfomance_marks';
		$table_hrmgt_parfomance_marks_meta = $wpdb->prefix. 'hrmgt_parfomance_marks_meta';
		$q="SELECT * FROM $table_hrmgt_parfomance_marks_meta a INNER JOIN $table_hrmgt_parfomance_marks b ON a.performance_id = b.id WHERE a.employee_id =$employee_id  AND (b.period_start >= '$start_date' AND b.period_end <= '$end_date')";
		return $performace = $wpdb->get_results($q);			
	}
		
	public function hrmgt_get_single_parfomance_marks($id)
	{
		global $wpdb;
			$table_hrmgt_parfomance_marks = $wpdb->prefix. 'hrmgt_parfomance_marks';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_parfomance_marks where id=".$id);
		return $result;
	}
	public function hrmgt_delete_parfomance_marks($id)
	{
		global $wpdb;
		$table_hrmgt_parfomance_marks = $wpdb->prefix. 'hrmgt_parfomance_marks';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_parfomance_marks where id= ".$id);
		return $result;
	}
	
	
	public function hrmgt_get_performace_employee($performace_id){
		global $wpdb;
		$table_hrmgt_parfomance_marks_meta = $wpdb->prefix. 'hrmgt_parfomance_marks_meta';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_parfomance_marks_meta WHERE performance_id=$performace_id");
		return $result;
		
	}

}
?>