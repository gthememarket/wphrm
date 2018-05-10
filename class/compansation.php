<?php
class HrmgtCompansation
{	
	public function hrmgt_assign_asset($data)
	{
		global $wpdb;
		
		$table_hrmgt_assets = $wpdb->prefix. 'hrmgt_assets';
		$assetdata['employee_id']=$data['employee_id'];
		$assetdata['asset_id']=$data['asset_id'];
		$assetdata['assign_date']=date("m/d/Y",strtotime($data['assign_date']));
		$assetdata['return_date']=date("m/d/Y",strtotime($data['return_date']));
		$assetdata['description']=$data['description'];
		$assetdata['created_by']=get_current_user_id();
		if($data['action']=='edit')
		{
			$whereid['id']=$data['assign_id'];
			$result=$wpdb->update( $table_hrmgt_assets, $assetdata ,$whereid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_hrmgt_assets, $assetdata );
			return $result;
		}
	
	}
	public function get_all_assets()
	{
		global $wpdb;
		$table_hrmgt_assets = $wpdb->prefix. 'hrmgt_assets';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_assets");
		return $result;
	
	}
	public function get_user_assets($id)
	{
		global $wpdb;
		$table_hrmgt_assets = $wpdb->prefix. 'hrmgt_assets';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_assets WHERE employee_id=$id ");
		return $result;
	
	}
	public function hrmgt_get_single_assets($id)
	{
		global $wpdb;
		$table_hrmgt_assets = $wpdb->prefix. 'hrmgt_assets';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_assets where id=".$id);
		return $result;
	}
	public function hrmgt_delete_assets($id)
	{
		global $wpdb;
		$table_hrmgt_assets = $wpdb->prefix. 'hrmgt_assets';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_assets where id= ".$id);
		return $result;
	}	
}
?>