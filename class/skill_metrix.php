<?php
class hrmgtSkillMetrix{

public function hrmgt_add_skill_metrix($data){
	$activity_category=hrmgt_get_all_category('training_skill_cat');	
	foreach($activity_category as $key=>$skill_ids){
		$skill_id[] = $skill_ids->ID;
	}
	$skill=array();
	

	
	
	 foreach($data['training_subject'] as $key=>$value){
		 $skill[$value]= $data['point'][$key];
	 }
	
	
	
	global $wpdb;
	$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
	
	$recorddata['employee_id']=$data['employee_id'];
	$recorddata['skill_start']=date("m/d/Y",strtotime($data['skill_start']));
	$recorddata['skill_end']=date("m/d/Y",strtotime($data['skill_end']));
	$recorddata['skill']=$skill = json_encode($skill);
	
	if(isset($data['action']) && $data['action']=="edit"){
		$whereid['id']=$data['id'];
		$result = $wpdb->update($hrmgt_skill_metrix_table,$recorddata,$whereid);
	}else{
		$result = $wpdb->insert($hrmgt_skill_metrix_table,$recorddata);
	}
	
	
	
	
	
	
	
	
	return $result;	 
}


	
	function check_skill($empid,$subid){
		global $wpdb;
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql="SELECT * FROM $hrmgt_skill_metrix_table WHERE employee_id=".$empid." AND subject_id=".$subid."";		
		$result = $wpdb->get_row($sql);	
		return $result;
	}	
	
	
	function get_group_employee(){
		global $wpdb;
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql ="SELECT * FROM $hrmgt_skill_metrix_table";
		$result = $wpdb->get_results($sql);
		return $result;
	}
	function get_single_employee_skill($id){
		global $wpdb;
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql ="SELECT * FROM $hrmgt_skill_metrix_table WHERE employee_id=$id ";
		$result = $wpdb->get_results($sql);
		return $result;
	}
	
	
	function get_employee_single_matrix($id,$start_date,$end_date){
		global $wpdb;		
		$new_start_date = date("m/d/Y", strtotime($start_date));
		$new_end_date = date("m/d/Y", strtotime($end_date));
		
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql ="SELECT * FROM $hrmgt_skill_metrix_table WHERE employee_id=$id AND (skill_start >= '$new_start_date' AND skill_end <= '$new_end_date')";
	
		$result = $wpdb->get_results($sql);
		return $result;
	}
	
	
	function hrmgt_get_all_skill_point($subid,$empid){
		global $wpdb;		
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql ="SELECT * FROM $hrmgt_skill_metrix_table WHERE subject_id=".$subid." AND employee_id=".$empid."";
		$data = $wpdb->get_results($sql);
		if(!empty($data)){
		foreach($data as $key=>$value){
			$result = $value->point;			
			}
		}
		else{
			$result='0';
		}
		return $result;
		
		
	}
	
	public function hrmgt_get_single_skill($id){
		global $wpdb;
		$hrmgt_skill_metrix_table = $wpdb->prefix .'hrmgt_skill_metrix';
		$sql ="SELECT * FROM $hrmgt_skill_metrix_table WHERE  id=".$id."";		
		$data = $wpdb->get_row($sql);
		return $data;
		
	}

}

 ?>