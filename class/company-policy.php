<?php
class HrmgtCompanyPolicy
{	
	public function hrmgt_add_policy($data)
	{
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$policydata['policy_type_id']=$data['policy_type_id'];
		$policydata['policy_title']=$data['policy_title'];
		$policydata['description']=$data['description'];
		$policydata['status']=$data['status'];
		$policydata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{
			$whereid['id']=$data['policy_id'];
			$result=$wpdb->update( $table_hrmgt_policy, $policydata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_policy, $policydata );
			return $result;
		}
	
	}
	public function get_all_polices()
	{
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_policy");
		return $result;
	}

	
	public function get_limited_polices()
	{
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_policy WHERE status='1' LIMIT 5");
		return $result;
	}


	public function hrmgt_get_single_police($id)
	{		
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_policy where id=".$id);
		return $result;
	}
	public function hrmgt_get_active_polices()
	{
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_policy where status=1");
		return $result;
	}
	public function hrmgt_delete_police($id)
	{
		global $wpdb;
		$table_hrmgt_policy = $wpdb->prefix. 'hrmgt_policy';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_policy where id= ".$id);
		return $result;
	}
	public function hrmgt_add_FAQ($data)
	{
		global $wpdb;
		$table_hrmgt_faq = $wpdb->prefix. 'hrmgt_faq';
		$FAQdata['title']=$data['title'];
		$FAQdata['description']=$data['description'];
		$FAQdata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{  
			$whereid['id']=$data['FAQ_id'];
			$result=$wpdb->update( $table_hrmgt_faq, $FAQdata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_faq, $FAQdata );
			return $result;
		}
	
	}
	public function get_all_faq()
	{
		global $wpdb;
		$table_hrmgt_faq = $wpdb->prefix. 'hrmgt_faq';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_faq");
		return $result;
	}
	public function hrmgt_get_single_faq($id)
	{
		global $wpdb;
		$table_hrmgt_faq = $wpdb->prefix. 'hrmgt_faq';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_faq where id=".$id);
		return $result;
	}
	public function hrmgt_delete_faq($id)
	{
		global $wpdb;
		$table_hrmgt_faq = $wpdb->prefix. 'hrmgt_faq';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_faq where id= ".$id);
		return $result;
	}
}
?>