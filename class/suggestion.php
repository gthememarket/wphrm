<?php
class HrmgtSuggestion
{	
	
	
	public function hrmgt_add_suggestion($data)
	{
		global $wpdb;
		
		$table_hrmgt_suggestion = $wpdb->prefix. 'hrmgt_suggestion';
		$suggestiondata['suggetion_title']=$data['suggetion_title'];
		$suggestiondata['employee_id']=$data['employee_id'];
		$suggestiondata['suggestion_date']=$data['suggestion_date'];
		$suggestiondata['suggestion']=$data['suggestion'];
		$suggestiondata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{
			$whereid['id']=$data['suggestion_id'];
			$result=$wpdb->update( $table_hrmgt_suggestion, $suggestiondata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_suggestion, $suggestiondata );
			return $result;
		}
	
	}
	public function get_all_suggestion()
	{
		global $wpdb;
		$table_hrmgt_suggestion = $wpdb->prefix. 'hrmgt_suggestion';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_suggestion");
		return $result;
	
	}
	
	public function get_user_suggestion($id)
	{
		global $wpdb;
		$table_hrmgt_suggestion = $wpdb->prefix. 'hrmgt_suggestion';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_suggestion WHERE employee_id=$id");
		return $result;
	
	}
	
	
	public function hrmgt_get_single_suggestion($id)
	{
		global $wpdb;
		$table_hrmgt_suggestion = $wpdb->prefix. 'hrmgt_suggestion';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_suggestion where id=".$id);
		return $result;
	}
	public function hrmgt_delete_suggestion($id)
	{
		global $wpdb;
		$table_hrmgt_suggestion = $wpdb->prefix. 'hrmgt_suggestion';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_suggestion where id= ".$id);
		return $result;
	}

}
?>