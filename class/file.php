<?php
class HrmgtFile
{	
	public function hrmgt_add_file($data,$filename){
				
		global $wpdb;
		$table_hrmgt_file= $wpdb->prefix. 'hrmgt_file';
		$table_hrmgt_file_meta= $wpdb->prefix. 'hrmgt_file_meta';		
		$filedata['title']=$data['title'];
		$filedata['added_date']=$data['added_date'];
		$filedata['description']=$data['description'];
		$filedata['file']=$filename;	
		
		$filedata['created_by']=get_current_user_id();
		
		if($data['action']=='edit'){
			$whereid['id']=$data['file_id'];
			$file_id=$data['file_id'];
			$succes=$wpdb->update( $table_hrmgt_file, $filedata ,$whereid);
			if($succes){
				$old_result  = $this->hrmgt_get_single_file_data($data['file_id']);				
				foreach($old_result as $old_key=>$old_val){
					$old_arr[] = $old_val->doc_for;
				}
				$new_arr = $data['doc_for'];
				$different_delete = array_diff($old_arr,$new_arr);					
				$different_insert = array_diff($new_arr,$old_arr);		
				if(!empty($different_insert)){
					 $file_meta['file_id'] = $data['file_id'];
					 foreach($different_insert as $insert_key=>$insert_val){						
						$file_meta['doc_for'] = $insert_val;
						$result =$wpdb->insert($table_hrmgt_file_meta,$file_meta);
					 }				
				}else if(!empty($different_delete)){
					foreach($different_delete as $del_key=>$del_val){						
						$result = $wpdb->query("DELETE FROM $table_hrmgt_file_meta where file_id=$file_id AND doc_for='$del_val'");
					}
				}else{
					$result=$succes;
				}
				
				
			}	
			
			return $result;
		}
		else
		{
			$insert=$wpdb->insert( $table_hrmgt_file, $filedata );
			if($insert){
				
				$filemetadata['file_id'] = $wpdb->insert_id;
				foreach($_POST['doc_for'] as $key=>$doc_val){
					$filemetadata['doc_for']=$doc_val;
					$result=$wpdb->insert( $table_hrmgt_file_meta, $filemetadata );
				}
			}
	
			return $result;
		}
	
	}
	public function get_all_files(){
		global $wpdb;
		$table_hrmgt_file = $wpdb->prefix. 'hrmgt_file';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_file");
		return $result;
	
	}
	
	
	public function get_role_wise_all_files($role){
		global $wpdb;
		$table_hrmgt_file_meta = $wpdb->prefix. 'hrmgt_file_meta';
		$sql="SELECT * FROM $table_hrmgt_file_meta  WHERE doc_for='$role'";
		$result = $wpdb->get_results($sql);
		return $result;
	
	}
	
	
	public function hrmgt_get_single_file($id){
		global $wpdb;
		$table_hrmgt_file = $wpdb->prefix. 'hrmgt_file';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_file where id=".$id);
		return $result;
	}
	
	public function hrmgt_get_single_file_data($id){
		global $wpdb;
			$table_hrmgt_file = $wpdb->prefix. 'hrmgt_file_meta';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_file where file_id=".$id);
		return $result;
	}
	public function hrmgt_delete_file($id){
		
		global $wpdb;
		$table_hrmgt_file = $wpdb->prefix. 'hrmgt_file';
		$table_hrmgt_file_meta = $wpdb->prefix. 'hrmgt_file_meta';
		$delete = $wpdb->query("DELETE FROM $table_hrmgt_file where id=".$id);
		
		if($delete){
			$result = $wpdb->query("DELETE FROM $table_hrmgt_file_meta where file_id= ".$id);
		}else{
			$result = $delete;
		}
		
		return $result;
	}

}
?>