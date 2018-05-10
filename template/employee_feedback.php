<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'complaint_list';
$role=hrmgt_get_user_role(get_current_user_id() );

$obj_suggestion = new HrmgtSuggestion();
?>
 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#complaint_list').DataTable({
		"responsive": true,
	});
} );
</script>
<script type="text/javascript">
$(document).ready(function() {
 $('#start_date').datepicker({dateFormat: "yy-mm-dd"}); 
} );


</script>
<?php 
if(isset($_POST['save_complaint'])){
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){			
		$args = array(
			  'ID'           => $_REQUEST['complaint_id'],
			  'post_type' => 'hrmgt_complaint',
			  'post_title' => $_REQUEST['complaint_title'],
			  'post_content' => $_REQUEST['compalint'],						
			);
			$result1=wp_update_post( $args );
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_date',$_REQUEST['complaint_date']);
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_from',$_REQUEST['employee_id']);
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_status',$_REQUEST['complaint_status']);
		
		
			if($result1 || $result2){
				wp_redirect ('?hr-dashboard=user&page=employee_feedback&tab=complaint_list&message=com_edit');				
			}
		}
		else
		{		
			$post_id = wp_insert_post( array(
				'post_status' => 'publish',
				'post_type' => 'hrmgt_complaint',
				'post_title' => $_REQUEST['complaint_title'],
				'post_content' => $_REQUEST['compalint']
			) );
				
			$result=add_post_meta($post_id, 'complaint_date',$_POST['complaint_date']);
			$result=add_post_meta($post_id, 'complaint_from',$_POST['employee_id']);
			$result=add_post_meta($post_id, 'complaint_status',$_POST['complaint_status']);				
			 if($result){
				wp_redirect ('?hr-dashboard=user&page=employee_feedback&tab=complaint_list&message=com_add');					
			} 
		}
	}
	
if(isset($_POST['save_suggestion']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_suggestion->hrmgt_add_suggestion($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=employee_feedback&tab=suggection_list&message=sug_edit');				
			}
	}
	else
	{			
		$result=$obj_suggestion->hrmgt_add_suggestion($_POST);
		if($result)	
		{
			wp_redirect ('?hr-dashboard=user&page=employee_feedback&tab=suggection_list&message=sug_add');
		}
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=wp_delete_post($_REQUEST['complaint_id']);
	if($result){
		wp_redirect ( '?hr-dashboard=user&page=employee_feedback&tab=complaint_list&message=com_del');			
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_suggestion->hrmgt_delete_suggestion($_REQUEST['suggestion_id']);
	if($result)
	{		
		wp_redirect ('?hr-dashboard=user&page=employee_feedback&tab=suggection_list&message=sug_del');
	}
}
	

if(isset($_REQUEST['message']))	
{
	
	$message =$_REQUEST['message'];
	if($message =="com_add"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Complaint inserted successfully','hr_mgt');?></p></div>
	<?php } if($message == "com_edit"){ ?>
		<div id="message" class="updated below-h2 msg"><p><?php _e("Complaint updated successfully.",'hr_mgt');?></p></div>
	<?php }	if($message == "com_del"){ ?>
			<div id="message" class="updated below-h2 msg"><p><?php _e('Complaint deleted successfully','hr_mgt');?></div></p>
	<?php } if($message=="sug_add"){ ?> 
			<div id="message" class="updated below-h2 msg"><p><?php _e('suggestion inserted successfully','hr_mgt');?></p></div>
	<?php  } if($message=="sug_edit"){ ?>
		<div id="message" class="updated below-h2 msg"><p><?php _e("suggestion updated successfully.",'hr_mgt');?></p>	</div>
	<?php } if($message=="sug_del"){ ?> 
		<div id="message" class="updated below-h2 msg"><p><?php _e("suggestion deleted successfully.",'hr_mgt');?></p>	</div>
	<?php } } ?>

<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
	<div class="category_list"></div>    
	</div> 
</div>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
 
	  	<li class="<?php if($active_tab=='complaint_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=complaint_list" class="tab <?php echo $active_tab == 'complaint_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Complaint List', 'hr_mgt'); ?></a>
          </a>
		</li>
		
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $active_tab=="add_complaint"){ ?>
		<li class="<?php if($active_tab=='add_complaint'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=add_complaint" class="tab <?php echo $active_tab == 'add_complaint' ? 'active' : ''; ?>">
              <?php _e('Edit Complaint', 'hr_mgt'); ?></a>
          </a>
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_complaint'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=add_complaint" class="tab <?php echo $active_tab == 'add_complaint' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Complaint', 'hr_mgt'); ?></a>
          </a>
		</li>			
		<?php }?>	


		<li class="<?php if($active_tab=='suggection_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=suggection_list" class="tab <?php echo $active_tab == 'suggection_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('suggestion List', 'hr_mgt'); ?></a>
          </a>
		</li>
		
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $active_tab=="add_suggection" ){ ?>
		<li class="<?php if($active_tab=='add_suggection'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=add_suggection" class="tab <?php echo $active_tab == 'add_suggection' ? 'active' : ''; ?>">
              <?php _e('Edit suggestion', 'hr_mgt'); ?></a>
          </a>
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_suggection'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=employee_feedback&tab=add_suggection" class="tab <?php echo $active_tab == 'add_suggection' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add suggestion', 'hr_mgt'); ?></a>
          </a>
		</li>			
		<?php } ?>	
 
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'complaint_list')
		{ ?>
		<div class="panel-body">
		<form name="activity_form" action="" method="post">
    
        <div class="">
        	<div class="table-responsive">
        <table id="complaint_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Complaint Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Complaint Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
         </tfoot>
		<tbody>
        <?php 
		if($role=="manager"){
			$complaintdata=hrmgt_get_all_category('hrmgt_complaint');
		}else{
			$complaintdata=hrmgt_get_user_category();
		}
		 
		 if(!empty($complaintdata)) {
		 	foreach ($complaintdata as $retrieved_data){ ?>			
            <tr>
				<td class="title"><a href="?hr-dashboard=user&page=employee_feedback&tab=add_complaint&action=edit&complaint_id=<?php echo $retrieved_data->ID?>"><?php echo $retrieved_data->post_title;?></a></td>
				<td class="emp"><?php echo  hrmgt_get_display_name($retrieved_data->complaint_from);?></td>
				<td class="date"><?php echo hrmgt_change_dateformat($retrieved_data->complaint_date);?></td>
				<td class="status"><?php echo $retrieved_data->complaint_status;?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->post_content,3,'...');?></td>
				<td class="action">
				<a href="#" class="btn btn-primary view-complaint" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View','apartment_mgt');?></a>	
				<a href="?hr-dashboard=user&page=employee_feedback&tab=add_complaint&action=edit&complaint_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?hr-dashboard=user&page=employee_feedback&tab=complaint_list&action=delete&complaint_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>	
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
if($active_tab=='add_complaint'){

	$complaint_id=0;
			if(isset($_REQUEST['complaint_id']))
				$complaint_id=$_REQUEST['complaint_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$postdata=get_post($complaint_id);
				}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#complaint_form').validationEngine();
	 $('#complaint_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
	 
});
</script>
<form name="complaint_form" action="" method="post" class="form-horizontal" id="complaint_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="complaint_id" value="<?php echo $complaint_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Complaint Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="complaint_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $postdata->post_title;}elseif(isset($_POST['complaint_title'])) echo $_POST['complaint_title'];?>" name="complaint_title">
			</div>
		</div>
		<?php if($role=="manager"){ ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$postdata->complaint_from;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";
				
				
					$employeedata = hrmgt_get_working_user('employee');			
					if(!empty($employeedata)){
						foreach ($employeedata as $retrive_data){ 
						echo '<option value="'.$retrive_data->ID.'" '.selected($retrive_data->ID,$employee).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
		</div>	
		<?php }  else{ ?>
				<input type="hidden" name="employee_id" value="<?php print get_current_user_id(); ?>">		
		<?php } ?>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Complaint Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="complaint_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($postdata->complaint_date)); }elseif(isset($_POST['complaint_date'])) echo $_POST['complaint_date'];?>" name="complaint_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="complaint_status"><?php _e('Complaint Status','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="complaint_status">
				<option value=""><?php _e('Select Status','hr_mgt');?></option>
				<?php 
				if($edit)
					$statusres =$postdata->complaint_status;
				elseif(isset($_REQUEST['complaint_status']))
					$statusres =$_REQUEST['complaint_status'];  
				else 
					$statusres = "";
				foreach(hrmgt_complaint_status() as $status){ ?>
						<option value="<?php echo $status;?>" <?php selected($status,$statusres);?>><?php echo $status;?></option>
				<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Complaint','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="compalint" class="form-control" name="compalint"><?php if($edit){echo $postdata->post_content; }elseif(isset($_POST['compalint'])) echo $_POST['compalint']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Complaint','hr_mgt');}?>" name="save_complaint" class="btn btn-success"/>
        </div>
		</form>		
<?php 	}  
if($active_tab=="suggection_list"){
	require_once HRMS_PLUGIN_DIR. '/template/employee_feedback/suggestion_list.php';
} 
if($active_tab=="add_suggection"){
	require_once HRMS_PLUGIN_DIR. '/template/employee_feedback/add_suggestion.php';
} 
?>
</div>