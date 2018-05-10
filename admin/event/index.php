<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'event_list';?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
	</div>
<?php 
	if(isset($_POST['save_event']))		
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			
			$args = array(
			  'ID'           => $_REQUEST['event_id'],
			  'post_type' => 'hrmgt_events',
			  'post_title' => $_REQUEST['event_title'],
			  'post_content' => $_REQUEST['description'],
						
			);
			$result1=wp_update_post( $args );
			$result2=update_post_meta($_REQUEST['event_id'], 'event_place', $_REQUEST['event_place']);
			$result3=update_post_meta($_REQUEST['event_id'], 'event_start_date',$_REQUEST['start_date']);
			$result4=update_post_meta($_REQUEST['event_id'], 'event_end_date',$_REQUEST['end_date']);
		
			if($result1 || $result2 || $result3 || $result4){					
				wp_redirect ( admin_url().'admin.php?page=hrmgt-event&tab=event_list&message=2');
			}
		}
		else
		{			
			$post_id = wp_insert_post( array(
				'post_status' => 'publish',
				'post_type' => 'hrmgt_events',
				'post_title' => $_REQUEST['event_title'],
				'post_content' => $_REQUEST['description']
			) );
				
				$result=add_post_meta($post_id, 'event_place',$_POST['event_place']);
				$result=add_post_meta($post_id, 'event_start_date',$_POST['start_date']);				
				$result=add_post_meta($post_id, 'event_end_date',$_POST['end_date']);
				if($result){
					$message = get_option('event_email_template');
					$arr = array();
					$arr['{{event_place}}'] = $_POST['event_place'];
					$arr['{{event_start_date}}'] = hrmgt_change_dateformat($_POST['start_date']);
					$arr['{{event_end_date}}'] = hrmgt_change_dateformat($_POST['end_date']);
					$arr['{{system_name}}'] = get_option('hrmgt_system_name');
					$message = get_option('event_email_template');
					$message_replace = hrmgt_string_replacemnet($arr,$message);
					if($message_replace){
						$emails = get_all_plugin_users_email();
						foreach($emails as $email)
						{							
							$usrdata = get_user_by('email',$email);
							if(hrmgt_get_user_role($usrdata->ID)=='employee')
							{
								if(get_user_meta($usrdata->ID,'working_status',true)=="Working")
								{
									$to[]=$usrdata->user_email;
								}
							}
							else
							{
								$to[]=$usrdata->user_email;
							}
						}
						
						$emails = get_option('event_emails');
						$emails = explode(",",$emails);
						foreach($emails as $email)
						{
							$to[]=$email;
						}
						
						$subject = get_option('event_subject');
						hmgt_send_mail($to,$subject,$message_replace);
					}
						wp_redirect ( admin_url().'admin.php?page=hrmgt-event&tab=event_list&message=1');
				}
		}
	}
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=wp_delete_post($_REQUEST['event_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-event&tab=event_list&message=3');
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Event inserted successfully','hr_mgt');
					?></p></div>
					<?php 
			
			}
			elseif($message == 2)
			{ ?><div id="message" class="updated below-h2 "><p><?php
						_e("Event updated successfully.",'hr_mgt');?></p>
						</div>
					<?php 
				
			}
			elseif($message == 3) 
			{ ?>
			<div id="message" class="updated below-h2"><p>
			<?php 
				_e('Event deleted successfully','hr_mgt');
			?></div></p><?php
					
			}
	}
	?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-event&tab=event_list" class="nav-tab <?php echo $active_tab == 'event_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Event List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-event&tab=add_event&action=edit&event_id=<?php echo $_REQUEST['event_id'];?>" class="nav-tab <?php echo $active_tab == 'add_event' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Event', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-event&tab=add_event" class="nav-tab <?php echo $active_tab == 'add_event' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Event', 'hr_mgt'); ?></a>
		<?php  } ?>
    </h2>
     <?php 	
	if($active_tab == 'event_list')
	{ ?>	
    <script type="text/javascript">
$(document).ready(function() {
	jQuery('#event_list').DataTable({
		"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_events_ajax_to_load',
		 "bDeferRender": true,
		});
} );
</script>
   
   <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="event_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th><?php _e( 'Event Title', 'hr_mgt' ) ;?></th>
				<th><?php _e('Start Date','hospital_mgt');?></th>
				<th><?php _e('End Date','hospital_mgt');?></th>
				<th><?php _e( 'Event Place', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Event Title', 'hr_mgt' ) ;?></th>
				<th><?php _e('Start Date','hospital_mgt');?></th>
				<th><?php _e('End Date','hospital_mgt');?></th>
				<th><?php _e( 'Event Place', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
 </table>
        </div>
        </div>
</form>
     <?php 
	 }
	else
	{
		if(isset($active_tab))
		 {
			require_once HRMS_PLUGIN_DIR.'/admin/event/'.$active_tab.'.php';
		 }
	} ?>
</div>			
	</div>
	</div>
</div>
