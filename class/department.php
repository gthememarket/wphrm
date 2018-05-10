<?php
class HrmgtDepartment
{	
	public function hrmgt_add_department($data)
	{
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
		$departmentdata['department_name']=$data['department_name'];
		$departmentdata['parent_department_id']=$data['parent_department_id'];
		$departmentdata['dept_head_id']=$data['dept_head_id'];
		$departmentdata['compassionate_leave']=$data['compassionate_leave'];
		$departmentdata['hospitalisation_leave']=$data['hospitalisation_leave'];
		$departmentdata['marriage_leave']=$data['marriage_leave'];
		$departmentdata['maternity_leave']=$data['maternity_leave'];
		$departmentdata['paternity_leave']=$data['paternity_leave'];
		$departmentdata['sick_leave']=$data['sick_leave'];
		$departmentdata['annual_leaves']=$data['annual_leaves'];
		$departmentdata['created_date']=date('Y-m-d');
		$departmentdata['created_by']=get_current_user_id();
		
		if($data['action']=='edit')
		{
			$whereid['id']=$data['dept_id'];
			$result=$wpdb->update( $table_hrmgt_department, $departmentdata ,$whereid);			
			return $result;
		}
		else
		{
			 $result=$wpdb->insert( $table_hrmgt_department, $departmentdata );
			return $result; 
			
		}
	
	}
	public function get_all_departments()
	{
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';	
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_department");
		return $result;
	
	}
	
	function get_all_parents_departments(){
		
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';	
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_department WHERE parent_department_id=0");
		return $result;		
	}
	
	function get_all_clild_departments($perent_dept_id){
		$perent_dept_id;
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';	
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_department WHERE parent_department_id=$perent_dept_id");
		return $result;		 
	}
	

	
	public function hrmgt_get_single_department($id)
	{
		
		global $wpdb;
			$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_department where id=".$id);
		return $result;
	}
	public function hrmgt_delete_department($service_id)
	{
			
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_department where id= ".$service_id);
		return $result;
	}
	
	function get_all_child_departments(){
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';	
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_department WHERE parent_department_id !=0");		
		return $result;
	}
	
	
	 function get_parent_department($parent_dept_id){
		global $wpdb;
		$table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_department where id=".$parent_dept_id);	
		return $result->department_name;
		
	} 

}
?>