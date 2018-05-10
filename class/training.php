<?php
class HrmgtTraining
{	
	public function hrmgt_add_training($data){
		
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training';
		$table_hrmgt_training_emp = $wpdb->prefix. 'hrmgt_training_emp';
		
		$trainingdata['training_type']=$data['training_type'];
		$trainingdata['training_title']=$data['training_title'];
		$trainingdata['training_subject']=$data['training_subject'];
		$trainingdata['traininer']=$data['traininer'];
		$trainingdata['training_location']=$data['training_location'];
		$trainingdata['start_date']=date("m/d/y",strtotime($data['start_date']));
		$trainingdata['end_date']=date("m/d/y",strtotime($data['end_date']));
		
		$trainingdata['description']=$data['description'];
		$trainingdata['created_by']=get_current_user_id();
	
		if($data['action']=='edit')
		{
			$whereid['id']=$data['training_id'];
			
			$result=$wpdb->update( $table_hrmgt_training, $trainingdata ,$whereid);
			$old_employee=$this->check_training_emp($data['training_id']);
			$new_employee=$data['employee'];
			if(!empty($old_employee)){
				$different_insert = array_diff($new_employee,$old_employee);
				$different_delete = array_diff($old_employee,$new_employee);	
				if(!empty($different_insert))	
				{
					foreach($different_insert as $emp_id)
					{
						$emptrainingdata['training_id']=$data['training_id'];
						$emptrainingdata['employee_id']=$emp_id;
						$result=$wpdb->insert( $table_hrmgt_training_emp, $emptrainingdata );
					}
				}
				if(!empty($different_delete))
				{
					foreach($different_delete as $emp_id)
					{	
						$result = $wpdb->query("DELETE FROM $table_hrmgt_training_emp where employee_id=$emp_id AND training_id=".$data['training_id']);
					}
				}	
			}
			else
			{
				if(!empty($data['employee']))	
				{
					foreach($data['employee'] as $emp)
					{
						$emptrainingdata['training_id']=$data['training_id'];
						$emptrainingdata['employee_id']=$emp;
						$result=$wpdb->insert( $table_hrmgt_training_emp, $emptrainingdata );
					}
				}
			}
			
			return $result;
		}
		else
		{
			$arr = array();			
			$arr['{{training_type}}']=get_the_title($_POST['training_type']);
			$arr['{{training_subject}}']=get_the_title($_POST['training_subject']);
			$arr['{{training_title}}']= $_POST['training_title'];
			$arr['{{traininer_name}}']=hrmgt_get_display_name($_POST['traininer']);
			$arr['{{training_location}}']=isset($_POST['training_location'])? $_POST['training_location']:'';
			$arr['{{traininig_start_date}}']=hrmgt_change_dateformat($_POST['start_date']);
			$arr['{{traininig_end_date}}']=hrmgt_change_dateformat($_POST['end_date']);
			$arr['{{description}}']=isset ($_POST['description'])?$_POST['description']:'';			
			$arr['{{system_name}}']=get_option('hrmgt_system_name');			
			$message = get_option('traning_email_template');			
			$replace_message = hrmgt_string_replacemnet($arr,$message);
			if($replace_message){
				foreach($_POST['employee'] as $emp_id_key=>$emp_id_val){					
					$to[] = hrmgt_get_emailid_byuser_id ($emp_id_val);
				}
				$to[]=hrmgt_get_emailid_byuser_id($_POST['traininer']);
				
				$emails= get_option('traning_emails');
				$emails = explode(",",$emails);
				foreach($emails as $email)
				{
					$to[]=$email;
				}
					
				$subject = get_option('traning_subject');
				hmgt_send_mail($to,$subject,$replace_message);
			}
			
			$result=$wpdb->insert( $table_hrmgt_training, $trainingdata );
			$trainingid=$wpdb->insert_id;
			foreach($data['employee'] as $emp)
			{
				$emptrainingdata['training_id']=$trainingid;
				$emptrainingdata['employee_id']=$emp;
				$result=$wpdb->insert( $table_hrmgt_training_emp, $emptrainingdata );
			}
			return $result;
		}
	
	}
	public function check_training_emp($tid)
	{
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training_emp';
		$result = $wpdb->get_results("SELECT employee_id FROM $table_hrmgt_training where training_id=$tid");
		$employee_array=array();
		foreach($result as $val)
		{
			$employee_array[]=$val->employee_id;
		}
		return $employee_array;
	}
	
	public function get_all_trainings(){
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_training");
		return $result;	
	}
	
	
	public function get_all_trainer_trainig($id){
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_training WHERE traininer=$id");
		return $result;	
	}
	
	
	public function get_all_current_employee_training($employee_id){
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training_emp';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_training WHERE  employee_id=$employee_id");
		return $result;	
	}
	
	

	
	public function hrmgt_get_single_training($id)
	{
		global $wpdb;
			$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_training where id=".$id);
		return $result;
	}
	
	public function hrmgt_delete_training($id)
	{
		global $wpdb;
		$table_hrmgt_training = $wpdb->prefix. 'hrmgt_training';
		$table_hrmgt_training_emp = $wpdb->prefix. 'hrmgt_training_emp';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_training where id= ".$id);
		$result = $wpdb->query("DELETE FROM $table_hrmgt_training_emp where training_id=".$id);
		return $result;
	}

}
?>