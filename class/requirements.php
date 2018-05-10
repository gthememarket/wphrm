<?php
class HrmgtRequirements
{	
	
	public function hrmgt_add_job($data)
	{
		global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$jobdata['job_title']=$data['job_title'];
		$jobdata['department_id']=$data['department_id'];
		$jobdata['designation']=$data['designation'];
		$jobdata['positions']=$data['positions'];
		$jobdata['closing_date']=date("m/d/Y",strtotime($data['closing_date']));
		$jobdata['description']=$data['description'];
		$jobdata['status']=$data['status'];	
		$jobdata['criere_entry']=json_encode($data['criere_entry']);		 	
		
		$jobdata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{
			$whereid['id']=$data['job_id'];
			
			$result=$wpdb->update( $table_hrmgt_posted_job, $jobdata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_posted_job, $jobdata );
			return $result;
		}
	
	}
	public function get_all_posted_job()
	{
		global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_posted_job WHERE archive_status=1");
		return $result;
	
	}

	//Get Limited record
	public function get_limited_posted_job()
	{
		global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_posted_job WHERE status='1' LIMIT 5");
		return $result;
	
	}


	public function hrmgt_get_single_posted_job($id)
	{
		global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_posted_job where id=".$id);
		return $result;
	}
	public function hrmgt_delete_posted_job($id)
	{
		global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$updatedata['archive_status']=0;
		$whereid['id'] =$id;
		$result = $wpdb->update($table_hrmgt_posted_job,$updatedata,$whereid);
		return $result;
	}
	public function hrmgt_apply_candidates($data,$upload_docs)
	{
		
	
		global $wpdb;
		$table_hrmgt_apply_candidates = $wpdb->prefix. 'hrmgt_apply_candidates';
		$candidatedata['job_id']=$data['job_id'];
		$candidatedata['crierearea']=$data['crierearea'];
		
		$candidatedata['first_name']=$data['first_name'];
		$candidatedata['middle_name']=$data['middle_name'];
		$candidatedata['last_name']=$data['last_name'];
		$candidatedata['gender']=$data['gender'];
		$candidatedata['birth_date']=$data['birth_date'];
		$candidatedata['address']=$data['address'];
		$candidatedata['city_name']=$data['city_name'];
		$candidatedata['state_name']=$data['state_name'];
		$candidatedata['country_name']=$data['country_name'];
		$candidatedata['zip_code']=$data['zip_code'];
		$candidatedata['email']=$data['email'];
		$candidatedata['mobile']=$data['mobile'];
		$candidatedata['phone']=$data['phone'];
		$candidatedata['interests']=$data['interests'];
		$candidatedata['achievements']=$data['achievements'];
		$candidatedata['notes']=$data['notes'];
		$candidatedata['bio_data']=$upload_docs;
		$candidatedata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{
			$whereid['id']=$data['candidate_id'];
			
			$result=$wpdb->update( $table_hrmgt_apply_candidates, $candidatedata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_apply_candidates, $candidatedata );
			return $result;
		}
	
	}
	public function get_all_candidates()
	{
		global $wpdb;
		$table_hrmgt_apply_candidates = $wpdb->prefix. 'hrmgt_apply_candidates';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_apply_candidates");
		return $result;
	
	}
	public function hrmgt_get_single_candidates($id)
	{
		global $wpdb;
		$table_hrmgt_apply_candidates = $wpdb->prefix. 'hrmgt_apply_candidates';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_apply_candidates where id=".$id);
		return $result;
	}
	public function hrmgt_delete_candidates($id)
	{
		global $wpdb;
		$table_hrmgt_apply_candidates = $wpdb->prefix. 'hrmgt_apply_candidates';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_apply_candidates where id= ".$id);
		return $result;
	}
	
	
	public function hrmgt_get_single_job($id)
	{
		 global $wpdb;
		$table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_posted_job where id=".$id);
		return $result;
		
	}
	public function hrmgt_crierearea_condidate($data){
		
		$job_id = $data['sub_id'];
		$crierearea = "'".$data['crierearea']."'";
		global $wpdb;
		$hrmgt_apply_candidates = $wpdb->prefix. 'hrmgt_apply_candidates';
		$sql ="SELECT * FROM $hrmgt_apply_candidates WHERE job_id=".$job_id." AND crierearea=".$crierearea;		
		$result = $wpdb->get_results($sql);	
		return $result;
		
	}
}
?>