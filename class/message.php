<?php  
class HrmgtMessage
{		
	public function hrmgt_add_message($data)
	{			
		global $wpdb;
		$table_message	=	$wpdb->prefix."hrmgt_message";
		$created_date 	= 	date("Y-m-d H:i:s");
		$subject 		= 	$data['subject'];
		$newsubject 		= 	$data['subject'];
		
		$message_body 	= 	$data['message_body'];
		$role			=	$data['receiver'];	
		
		if($role == 'employee')
		{
			$userdata	=	hrmgt_get_working_user($role);			
			if(!empty($userdata))
			{			
				$mail_id 	= 	array();		
				$UserEmail 	= 	array();		
				foreach($userdata as $user)
				{	
					$UserEmail[] = $user->user_email;				
					$mail_id[]=$user->ID;
				}
				if(isset($data['send_mail']) && $data['send_mail']=="1")
				{
					hmgt_send_mail($UserEmail,$newsubject,$message_body);
				}
				$post_id = wp_insert_post( array(
					'post_status' => 'publish',
					'post_type' => 'hrmgt_message',
					'post_title' => $subject,
					'post_content' =>$message_body		
				) );
				foreach($mail_id as $user_id)
				{
					$reciever_id = $user_id;
					$message_data=array(
						'sender'=>get_current_user_id(),
						'receiver'=>$user_id,
						'msg_subject'=>$subject,
						'message_body'=>$message_body,
						'msg_date'=>$created_date,
						'post_id'=>$post_id,
						'msg_status' =>0
					);					
					$result=$wpdb->insert( $table_message, $message_data );
				}
				$result=add_post_meta($post_id, 'message_for',$role);
				$result = 1;
			}
		}
		else 
		{
			$user_id = $data['receiver'];			
			if(isset($data['send_mail']) && $data['send_mail']=="1")
			{				
				hmgt_send_mail(hrmgt_get_emailid_byuser_id($user_id),$newsubject,$message_body);
				
			}			
			$post_id = wp_insert_post( array(
				'post_status' => 'publish',
				'post_type' => 'hrmgt_message',
				'post_title' => $subject,
				'post_content' =>$message_body			
			) );
			$message_data=array('sender'=>get_current_user_id(),	
				'receiver'=>$user_id,
				'msg_subject'=>$subject,
				'message_body'=>$message_body,
				'post_id'=>$post_id,
				'msg_date'=>$created_date,
				'msg_status' =>0
			);
			$result=$wpdb->insert($table_message, $message_data);			
			$result=add_post_meta($post_id, 'message_for','user');
			$result=add_post_meta($post_id, 'message_for_userid',$user_id);
		}
		return $result;
		
	}
	public function delete_message($mid)
	{
		global $wpdb;
		$table_hmgt_message = $wpdb->prefix. 'hrmgt_message';
		$result = $wpdb->query("DELETE FROM $table_hmgt_message where message_id= ".$mid);
		
		return $result;
	}
	public function hrmgt_count_send_item($user_id)
	{
		global $wpdb;
		$posts = $wpdb->prefix."posts";
		$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'hrmgt_message' AND post_author = $user_id");
		return $total;
	}
	
	public function hrmgt_count_inbox_item($user_id)
	{
		global $wpdb;
		$tbl_name_message = $wpdb->prefix .'hrmgt_message';
				
		$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name_message where receiver = $user_id AND msg_status = 0");
		return $inbox;
	}
	
	public function hrmgt_get_inbox_message($user_id,$p=0,$lpm1=10)
	{
		global $wpdb;
		$tbl_name_message = $wpdb->prefix .'hrmgt_message';
		$tbl_name_message_replies = $wpdb->prefix .'hrmgt_message_replies';
		//echo "SELECT DISTINCT b.message_id, a.* FROM $tbl_name_message a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id)ORDER BY msg_date DESC limit $p , $lpm1";
		//exit;
		$inbox = $wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name_message a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id) group by a.post_id ORDER BY msg_date DESC limit $p , $lpm1");
		
		return $inbox;
	}
	public function hrmgt_pagination($totalposts,$p,$prev,$next,$page)
	{
		
		
		$pagination = "";
		
		
		if($totalposts > 1)
		{
			$pagination .= '<div class="btn-group">';
		
			if ($p > 1)
				$pagination.= "<a href=\"?$page&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
			else
				$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
		
			if ($p < $totalposts)
				$pagination.= " <a href=\"?$page&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
			else
				$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
			$pagination.= "</div>\n";
		}
		
		
		return $pagination;
	}
	public function hrmgt_get_send_message($user_id,$max=10,$offset=0)
	{	
		$args['post_type'] = 'hrmgt_message';
		$args['posts_per_page'] =$max;
		$args['offset'] = $offset;
		$args['post_status'] = 'public';
		$args['author'] = $user_id;			
		$q = new WP_Query();
		$sent_message = $q->query( $args );
		return $sent_message;
	}
	
	public function hrmgt_get_message_by_id($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "hrmgt_message";
		$qry = $wpdb->prepare( "SELECT * FROM $table_name WHERE message_id= %d",$id);
		return $retrieve_subject = $wpdb->get_row( $qry);
	
	}
	public function hrmgt_send_replay_message($data)
	{
		
		global $wpdb;
		$table_name = $wpdb->prefix . "hrmgt_message_replies";
		$messagedata['message_id'] = $data['message_id'];
		$messagedata['sender_id'] = $data['user_id'];
		$messagedata['receiver_id'] = $data['receiver_id'];
		$messagedata['message_comment'] = $data['replay_message_body'];
		$messagedata['created_date'] = date("Y-m-d h:i:s");
		$result=$wpdb->insert( $table_name, $messagedata );
		if($result)	
			return $result;
		
			
	}
	public function get_all_replies($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "hrmgt_message_replies";
		$qry =$wpdb->prepare("SELECT *  FROM $table_name where message_id = %d",$id);
		return $result =$wpdb->get_results($qry);
	}
	
	public function delete_reply($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "hrmgt_message_replies";
		$reply_id['id']=$id;
		return $result=$wpdb->delete( $table_name, $reply_id);
	}
	public function hrmgt_count_reply_item($id)
	{
		global $wpdb;
		$tbl_name = $wpdb->prefix .'hrmgt_message_replies';
		
		$result=$wpdb->get_var("SELECT count(*)  FROM $tbl_name where message_id = $id");
		return $result;
	}
	
}
?>