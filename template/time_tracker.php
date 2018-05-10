<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'time_tracker_list';
$obj_office = new HrmgtOfficeMgt();
$obj_project = new HrmgtProject();
$role=hrmgt_get_user_role(get_current_user_id() );

if(isset($_POST['save_task']))		
	{	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=time_tracker&tab=time_tracker_list&message=2');
			}
		}
		else
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=time_tracker&tab=time_tracker_list&message=1');
			}
		}
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		
		if(isset($_REQUEST['task_id']))
		{
			$result=$obj_office->hrmgt_delete_tasks($_REQUEST['task_id']);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=time_tracker&tab=time_tracker_list&message=3');
			}
		}
	}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{ ?>
			<div id="message" class="updated below-h2 msg ">
				<p><?php _e('Record inserted successfully','hr_mgt');?></p>
			</div>
		<?php 			
		}
		elseif($message == 2)
		{ ?> 
			<div id="message" class="updated below-h2 msg ">
				<p><?php _e("Record updated successfully.",'hr_mgt');?></p>
			</div>
		<?php 
		}
			elseif($message == 3) 
			{?>
			<div id="message" class="updated below-h2 msg "><p>
			<?php 
				_e('Record deleted successfully','hr_mgt');
			?></div></p><?php
					
			}
	}
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"> </div>
		</div>
    </div> 
</div>

<script type="text/javascript">
$(document).ready(function() {
	jQuery('#task_list').DataTable();
} );
</script>
<script type="text/javascript">
$(document).ready(function() {
 $('#start_date').datepicker({dateFormat: "yy-mm-dd"}); 
} );
</script>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	<li class="<?php if($active_tab=='time_tracker_list'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=time_tracker&tab=time_tracker_list" class="tab <?php echo $active_tab == 'time_tracker_list' ? 'active' : ''; ?>">
		 <i class="fa fa-align-justify"></i> <?php _e('Time Tracker List', 'hr_mgt'); ?></a>
	  </a>
	</li>
		
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
	<li class="<?php if($active_tab=='add_time_tracker'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=time_tracker&tab=add_time_tracker" class="tab <?php echo $active_tab == 'add_time_tracker' ? 'active' : ''; ?>">
		<?php _e('Edit Time Tracker', 'hr_mgt'); ?></a>
	  </a>
	</li>
	<?php } else { ?>
	<li class="<?php if($active_tab=='add_time_tracker'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=time_tracker&tab=add_time_tracker" class="tab <?php echo $active_tab == 'add_time_tracker' ? 'active' : ''; ?>">
		 <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Time Tracker', 'hr_mgt'); ?></a>
	  </a>
	</li>			
	<?php }?>	  
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'time_tracker_list')
		{ ?>
		<div class="panel-body">
		<form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="task_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Work Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project Name', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Working Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task Start Time', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task End Time', 'hr_mgt' ) ;?></th>
			  <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php _e( 'Work Title', 'hr_mgt' ) ;?></th>
			 <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project Name ', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Working Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task Start Time', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task End Time', 'hr_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
         </tfoot>
 
        <tbody>
         <?php 
		 if($role=="manager"){ 
			$taskdata=$obj_office->get_all_tasks();
		 }else{
			 $id = get_current_user_id();
			$taskdata=$obj_office->get_user_tasks($id); 
		 }
		
		 if(!empty($taskdata))
		 {
		 	foreach ($taskdata as $retrieved_data){ ?>
            <tr>
				<td class="Employee"><?php echo $retrieved_data->work_title;?></td>
				<td class="working date"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
				<td class="Project Name"><?php echo hrmgt_get_project_title($retrieved_data->task_cat_id);?></td>
				<td class="task cat"><?php echo hrmgt_change_dateformat($retrieved_data->working_date);?></td>
				<td class="working date"><?php echo $retrieved_data->start_time;?></td>
				<td class="start time"><?php echo $retrieved_data->end_time;?></td>
				<td class="action">
              	
                <a href="?hr-dashboard=user&page=time_tracker&tab=time_tracker_list&action=delete&task_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<a href="" class="btn btn-primary view-tasklist" id="<?php print $retrieved_data->id ?>" ><?php _e("View","hr_mgt");?></a>
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
if($active_tab=='add_time_tracker'){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
		$('.timepicker').timepicker();
	$('#task_form').validationEngine();
	$('#working_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
	 
});
</script>
     <?php 	                                 
			$task_id=0;
			if(isset($_REQUEST['task_id']))
				$task_id=$_REQUEST['task_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_office->hrmgt_get_single_tasks($task_id);
					
				} ?>
		<div class="panel-body">
        <form name="task_form" action="" method="post" class="form-horizontal" id="task_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="task_id" value="<?php echo $task_id;?>"  />
		<?php if($role=="manager"){ ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$result->employee_id;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";
					$get_employee = array('role' => 'employee');
					$employeedata=get_users($get_employee);
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
			<input type="hidden" name="employee_id" value="<?php print get_current_user_id(); ?>" />		
		<?php } ?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Project Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="task_cat_id" id="task_cat">
				<option value=""><?php _e('Select Project','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->task_cat_id;
				elseif(isset($_REQUEST['task_cat_id']))
					$category =$_REQUEST['task_cat_id'];  
				else 
					$category = "";
					$projectdata=$obj_project->get_all_project();
				 if(!empty($projectdata))
				 {
					foreach ($projectdata as $retrive_data) 
					{
						echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->project_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<!--<div class="col-sm-2"><button id="addremove" model="task_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>-->
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="work_title"><?php _e('Work Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="work_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->work_title;}elseif(isset($_POST['work_title'])) echo $_POST['work_title'];?>" name="work_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="working_date"><?php _e('working Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="working_date" class="form-control validate[required]" type="text"  name="working_date" 
				value="<?php if($edit){ echo $result->working_date;}elseif(isset($_POST['working_date'])) echo $_POST['working_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Start Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input type="text" class="form-control timepicker validate[required]" name="start_time" value="<?php if($edit){ echo $result->start_time;}elseif(isset($_POST['start_time'])) echo $_POST['start_time'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('End Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input type="text" class="form-control timepicker validate[required]" name="end_time" value="<?php if($edit){ echo $result->end_time;}elseif(isset($_POST['end_time'])) echo $_POST['end_time'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hospital_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Task','hr_mgt');}?>" name="save_task" class="btn btn-success"/>
        </div>
		</form>
</div>
<?php } ?>
	</div>
</div>