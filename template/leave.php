<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'leave_list';
$obj_leave = new HrmgtLeave();
$role=hrmgt_get_user_role(get_current_user_id() );

if(isset($_POST['save_leave']))		
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{	
		$result=$obj_leave->hrmgt_add_leave($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=leave&tab=leave_list&message=2');
		}
	}
	else
	{
		$result=$obj_leave->hrmgt_add_leave($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=leave&tab=leave_list&message=1');
		}
	}
}
if(isset($_POST['approve_comment'])&& $_POST['approve_comment']=='Submit')
{	
	$result=$obj_leave->hrmgt_approve_leave($_POST);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=leave&tab=leave_list&message=4');
	}
}

if(isset($_POST['reject_leave'])&& $_POST['reject_leave']=='Submit')
{	
	$result=$obj_leave->hrmgt_reject_leave($_POST);		
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=leave&tab=leave_list&message=5');
	}
}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_leave->hrmgt_delete_leave($_REQUEST['leave_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=leave&tab=leave_list&message=3');
	}
} 

if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2  msg ">
			<p><?php _e('Leave inserted successfully','hr_mgt');?></p>
		</div>
	<?php 
	}
	
	elseif($message == 2)
	{ ?> 
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e("Leave updated successfully.",'hr_mgt');?></p>
		</div>
	<?php 
	}
	elseif($message == 3) { ?>
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e('Leave deleted successfully','hr_mgt');?></div></p>
	<?php				
	}
	elseif($message == 4) { ?>
		<div id="message" class="updated below-h2 msg">
		<p><?php _e('Leave Approved successfully','hr_mgt'); ?></div></p>
	<?php
	}
	elseif($message == 5) { ?>
		<div id="message" class="updated below-h2 msg">
		<p><?php _e('Leave Reject successfully','hr_mgt'); ?></div></p>
	<?php
	}
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#leave_list').DataTable({
		"responsive": true,
		"order": [[ 0, "desc" ]],
		  "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
		],  
		"aoColumns":[
			{"bSortable": true},
			{"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": false}]
	});
	
	$('#leave_form').validationEngine();
	$(".duration").trigger("change");
} );
</script>
 <div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div> 
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	 <li class="<?php if($active_tab=='leave_list'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=leave&tab=leave_list" class="tab <?php echo $active_tab == 'leave_list' ? 'active' : ''; ?>">
            <i class="fa fa-align-justify"></i> <?php _e('Leave List', 'hr_mgt'); ?></a>
        </a>
	</li>
		
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
	<li class="<?php if($active_tab=='add_leave'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=leave&tab=add_leave" class="tab <?php echo $active_tab == 'add_leave' ? 'active' : ''; ?>"><?php _e('Edit Leave', 'hr_mgt'); ?></a>
      
	</li>
	<?php } else { ?>
		<li class="<?php if($active_tab=='add_leave'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=leave&tab=add_leave" class="tab <?php echo $active_tab == 'add_leave' ? 'active' : ''; ?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Leave', 'hr_mgt'); ?>
			 </a>          
		</li>
			
		<?php } ?>
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'leave_list')
		{ ?>
		<div class="panel-body">
	<?php if($role=="manager"){ ?> 
    <form name="leave_filter" action="" class="form-inline" method="post">
		<div class="form-group">
			<label for="email"><?php _e('Select Employee','hr_mgt')?></label>
		</div>
		<select class="form-control" name="employee_id">
		<option value=""><?php _e('Select Employee','hr_mgt');?></option>
		<?php
			$emp_id=0;
			if(isset($_POST['employee_id'])){
				$emp_id = $_POST['employee_id'];
			}
			foreach(hrmgt_get_working_user('employee') as $employee)
			{ ?>	
			<option value="<?php print $employee->ID ?>" <?php selected($employee->ID,$emp_id) ?>><?php  print hrmgt_get_display_name($employee->ID); ?></option>
		<?php } ?>
		</select>
		<input type="submit" name="get_leave" value="Get Leave" class="btn btn-info">
	</form> 
	<?php } ?>	
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="leave_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Leave ID', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Leave Type', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Leave Duration', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Leave Start Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Leave End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Reason', 'hr_mgt' ) ;?></th>
              <th>
			  	<?php if($role=="manager"){ _e( 'Action', 'hr_mgt' ); }?>
			  </th>			 
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Leave ID', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Leave Type', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Leave Duration', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Leave Start Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Leave End Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Reason', 'hr_mgt' ) ;?></th>	
				<th><?php if($role=="manager"){ _e( 'Action', 'hr_mgt' ); }?> </th>
            </tr>           
        </tfoot> 
        <tbody>
         <?php 
			if($role=="manager")
			{
				if(isset($_POST['get_leave']) && isset($_POST['employee_id']))
				{
					$attendancedata=$obj_leave->get_single_user_leaves($_POST['employee_id']);
				}
				else
				{
					$attendancedata=$obj_leave->get_all_leaves();
				}
				
			}
			else{
				$id = get_current_user_id();
				$attendancedata=$obj_leave->get_single_user_leaves($id);	
			}
		 if(!empty($attendancedata))
		 {				
		 	foreach ($attendancedata as $retrieved_data){				
					
			?>
            <tr>
			<td class="Employee"><?php print  $retrieved_data->id;?></td>
			<?php if($role=="manager"){ ?>
					<td class="Employee"><a href="?hr-dashboard=user&page=leave&tab=add_leave&action=edit&leave_id=<?php echo $retrieved_data->id?>" ><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></a></td>
			<?php } else{ ?> 
					<td class="Employee"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
			<?php } ?>			
				<td class="leave type"><?php echo get_the_title($retrieved_data->leave_type);?></td>
				<td class="leave duration"><?php echo hrmgt_leave_duration_label($retrieved_data->leave_duration);?></td>
				<td class="start date"><?php echo hrmgt_change_dateformat($retrieved_data->start_date);?></td>
				<td class="end date">
					<?php 					
						if(!empty($retrieved_data->end_date)){						
							print hrmgt_change_dateformat($retrieved_data->end_date);
						}											
					?>
				</td>
				<td class="reason"><?php echo $retrieved_data->status;?></td>
				<td class="reason"><?php echo wp_trim_words($retrieved_data->reason,3,'...');?></td>
				<td>
				<?php
				if($role=="manager"){ ?> 
				<?php if(($retrieved_data->status!='Approved') AND ($retrieved_data->status!='Rejected')){ ?>
              	<a href="#" leave_id="<?php echo $retrieved_data->id ?>" class="btn btn-default leave-approve"> <?php _e('Approve', 'hr_mgt' ) ;?></a>
				<?php if(($retrieved_data->status!='Approved') AND ($retrieved_data->status!='Rejected')){ ?>
						<a href="#" leave_id="<?php echo $retrieved_data->id?>" class="btn btn-default leave-reject"> <?php _e('Reject', 'hr_mgt' ) ;?></a>
					<?php } ?>
				<?php } ?>
				<a href="?hr-dashboard=user&page=leave&tab=add_leave&action=edit&leave_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
				<a href="?hr-dashboard=user&page=leave&tab=leave_list&action=delete&leave_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php }?>
				</td>
             </tr>
            <?php } } ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php 
if($active_tab=='add_leave')
{
	$leave_id=0;
	if(isset($_REQUEST['leave_id']))
		$leave_id=$_REQUEST['leave_id'];
		$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$result = $obj_leave->hrmgt_get_single_leave($leave_id);
	}
?>
		<div class="panel-body">
        <form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="leave_id" value="<?php echo $leave_id;?>"  />
		<input type="hidden" name="status" value="<?php echo "Not Approved";?>"  />
		
		<?php 
		if($role=="manager"){ ?> 
			<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$result->employee_id;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";
				
					$employeedata = hrmgt_get_working_user('employee');
					
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
		</div>	
		<?php } else{ ?>
			<input value="<?php print get_current_user_id(); ?>" name="employee_id" type="hidden" />			
		<?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Leave Type','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="leave_type" id="leave_type_cat">
				<option value=""><?php _e('Select Leave Type','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->leave_type;
				elseif(isset($_REQUEST['leave_type']))
					$category =$_REQUEST['leave_type'];  
				else 
					$category = "";
				
				$activity_category=hrmgt_get_all_category('leave_type_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="leave_type_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="reason"><?php _e('Leave Duration','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $durationval = ""; if($edit){ $durationval=$result->leave_duration; }elseif(isset($_POST['duration'])) {$durationval=$_POST['duration'];}?>
				<label class="radio-inline">
					<input id="half_day" type="radio" value="half_day" class="tog duration" name="leave_duration" idset ="<?php if($edit) print $result->id; ?>"  <?php  checked( 'half_day', $durationval);  ?>/><?php _e('Half Day','hr_mgt');?>
			    </label>
			    <label class="radio-inline">
					<input id="full_day" type="radio" value="full_day" class="tog duration" idset ="<?php if($edit) print $result->id; ?>"  name="leave_duration"  <?php  checked( 'full_day', $durationval);  ?> checked /><?php _e('Full Day','hr_mgt');?> 
			    </label>
				 <label class="radio-inline">
					<input id="more_then_day" type="radio" idset ="<?php if($edit) print $result->id; ?>" value="more_then_day" class="tog duration" name="leave_duration"  <?php  checked( 'more_then_day', $durationval);  ?>/><?php _e('More Than One Day','hr_mgt');?> 
			    </label>
			</div>
		</div>		
		<div id="leave_date"></div>	
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Reason','hospital_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea id="reason" class="form-control validate[required]" name="reason"><?php if($edit){echo $result->reason; }elseif(isset($_POST['reason'])) echo $_POST['reason']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Leave','hr_mgt');}?>" name="save_leave" class="btn btn-success"/>
        </div>
		</form>
</div>	
<?php } ?>
	</div>
</div>