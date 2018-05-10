<?php
class HrmgtTravel
{	
	
	public function get_travel_destination_entry_records($data)
	{
			$travel_destination_entry=$data['travel_destination_entry'];
			 $travel_mode=$data['travel_mode'];
			 $arrange_type=$data['arrange_type'];
			
			$entry_data=array();
			$i=0;
			foreach($travel_destination_entry as $one_entry)
			{
				$entry_data[]= array('entry'=>$one_entry,
							'mode'=>$travel_mode[$i],
							'arrange_type'=>$arrange_type[$i],);
					$i++;
			}
			return json_encode($entry_data);
	}
	public function hrmgt_add_travel($data){		
		global $wpdb;
		$entrydata=$this->get_travel_destination_entry_records($data);
		$table_hrmgt_travel = $wpdb->prefix. 'hrmgt_travel';
		$traveldata['employee_id']=$data['employee_id'];
		$traveldata['visit_purpose']=$data['visit_purpose'];
		$traveldata['start_date']=date("m/d/Y",strtotime($data['start_date']));
		$traveldata['end_date']=date("m/d/Y",strtotime($data['end_date']));
		$traveldata['expected_budget']=$data['expected_budget'];
		$traveldata['actual_budget']=$data['actual_budget'];
		$traveldata['destination_data']=$entrydata;
		$traveldata['description']=$data['description'];
		$traveldata['status']='Not Approve';
		$traveldata['created_by']=get_current_user_id();
		if($data['action']=='edit'){			
			$whereid['id']=$data['travel_id'];
			$result=$wpdb->update( $table_hrmgt_travel, $traveldata ,$whereid);			
			return $result;
		}
		else{
			$result=$wpdb->insert( $table_hrmgt_travel, $traveldata );
			return $result;
		}	
	}
	public function get_all_travels(){
		global $wpdb;
		$table_hrmgt_travel = $wpdb->prefix. 'hrmgt_travel';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_travel");
		return $result;	
	}
	
	public function get_user_travels($id){
		global $wpdb;
		$table_hrmgt_travel = $wpdb->prefix. 'hrmgt_travel';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_travel WHERE employee_id=$id");
		return $result;	
	}
	
	public function hrmgt_get_single_travel($id){
		global $wpdb;
		$table_hrmgt_travel = $wpdb->prefix. 'hrmgt_travel';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_travel where id=".$id);
		return $result;
	}
	public function hrmgt_delete_travel($id){
		global $wpdb;
		$table_hrmgt_travel = $wpdb->prefix. 'hrmgt_travel';
		$result = $wpdb->query("DELETE FROM $table_hrmgt_travel where id= ".$id);
		return $result;
	}

}
?>