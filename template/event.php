<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'event_list';
$obj_requirements = new HrmgtRequirements();
$role=hrmgt_get_user_role(get_current_user_id() );
?>

<?php 
if(isset($_POST['save_event']))	{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
			
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
		
			if($result1 || $result2 || $result3 || $result4)
			{
				wp_redirect ('?hr-dashboard=user&page=event&tab=event_list&message=2');
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
					
					wp_redirect ('?hr-dashboard=user&page=event&tab=event_list&message=1');
				}
		}
	}
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=wp_delete_post($_REQUEST['event_id']);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=event&tab=event_list&message=3');
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
				<div id="message" class="updated below-h2 msg "><p>	<?php _e('Event inserted successfully','hr_mgt');?></p></div>
			<?php 			
			}
			elseif($message == 2)
			{ ?>
				<div id="message" class="updated below-h2 msg "><p><?php _e("Event updated successfully.",'hr_mgt');?></p></div>
			<?php 
			}
			elseif($message == 3) 
			{ ?>
				<div id="message" class="updated below-h2 msg "><p>
					<?php _e('Event deleted successfully','hr_mgt');?>
				</div></p>
			<?php					
			}
		}
?>
 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#event_list').DataTable({
		"responsive": true,
	});
} );
</script>
<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
	<div class="category_list"></div>    
	</div> 
</div>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	  	<li class="<?php if($active_tab=='event_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=event&tab=event_list" class="tab <?php echo $active_tab == 'event_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Event List', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php if($role=="manager"){ ?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
		<li class="<?php if($active_tab=='add_event'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=event&tab=add_event" class="tab <?php echo $active_tab == 'add_event' ? 'active' : ''; ?>">
            <?php _e('Edit Event','hr_mgt'); ?></a>
          </a>
		</li>
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_event'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=event&tab=add_event" class="tab <?php echo $active_tab == 'add_event' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Event','hr_mgt'); ?></a>
          </a>
		</li>
			
		<?php }?>
		
		<?php }?>
	 
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'event_list')
		{ ?>
		<div class="">
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
 
        <tbody>
         <?php 
			$eventdata=hrmgt_get_all_category('hrmgt_events');
		 if(!empty($eventdata))
		 {
			 
		 	foreach ($eventdata as $retrieved_data){ ?>
            <tr>
			<?php if($role=="manager"){ ?>
				<td class="title"><a href="?hr-dashboard=user&page=event&tab=add_event&action=edit&event_id=<?php echo $retrieved_data->ID?>"><?php echo $retrieved_data->post_title;?></a></td>
			<?php }else{  ?>
				<td class="title"><?php echo $retrieved_data->post_title;?></td>
			<?php } ?>			
				
				<td class="start"><?php echo hrmgt_change_dateformat($retrieved_data->event_start_date);?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->event_end_date);?></td>
				<td class="place"><?php echo $retrieved_data->event_place;?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->post_content,3,'...');?></td>
				<td class="action">
					<a href="#" class="btn btn-primary view-event" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View','apartment_mgt');?></a>
				<?php if($role=="manager"){ ?>
					<a href="?hr-dashboard=user&page=event&tab=add_event&action=edit&event_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=event&tab=event_list&action=delete&event_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php  } ?>
                </td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php
if($active_tab=="add_event")
{
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#event_Start_date').datepicker({
		dateFormat:'yy-mm-dd',		 
		changeMonth: true,
		changeYear: true,
		onSelect: function(selected) {
			$("#event_end_date").datepicker("option","minDate", selected)
		}
	});
	$('#event_end_date').datepicker({
		dateFormat:'yy-mm-dd',		  
		changeMonth: true,
		changeYear: true,
		onSelect: function(selected) {
			$("#event_Start_date").datepicker("option","maxDate", selected)
		}
	});
});
</script>
<?php 
	$event_id=0;
	if(isset($_REQUEST['event_id']))
		$event_id=$_REQUEST['event_id'];
		$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;					
		$postdata=get_post($event_id);
	}
?>
<div class="panel-body"> 		
	<form name="class_form" action="" method="post" class="form-horizontal" id="notice_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="event_id"   value="<?php if($edit){ echo $event_id;}?>"/> 
		<div class="form-group">
			<label class="col-sm-2 control-label" for="event_title"><?php _e('Event Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="event_title" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $postdata->post_title;}?>" name="event_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_content"><?php _e('Event Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="event_Start_date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($postdata->ID,'event_start_date',true)));}?>" name="start_date">				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_content"><?php _e('Event End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="event_end_date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($postdata->ID,'event_end_date',true)));}?>" name="end_date">				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="event_place"><?php _e('Event Place','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="event_place" class="form-control text-input" type="text" value="<?php if($edit){ echo get_post_meta($postdata->ID,'event_place',true);}?>" name="event_place">				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea name="description" class="form-control" id="description"><?php if($edit){ echo $postdata->post_content;}?></textarea>				
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Event','hr_mgt'); }else{ _e('Add Event','hr_mgt');}?>" name="save_event" class="btn btn-success" />
        </div>
    </form>
</div>
 <?php } ?>
</div>