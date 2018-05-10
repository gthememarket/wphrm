<?php 
$active_tab 	= 	isset($_REQUEST['tab'])?$_REQUEST['tab']:'project_list';
$obj_project 	= 	new HrmgtProject();
$obj_office 	= 	new HrmgtOfficeMgt();
$role			=	hrmgt_get_user_role(get_current_user_id() );
?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#project_list').DataTable({
		"responsive": true,
	});
} );  
</script>
<?php 
	if(isset($_POST['save_project']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_project->hrmgt_add_project($_POST);
			if($result){
				wp_redirect ('?hr-dashboard=user&page=project&tab=project_list&message=pro_edit');
			}
		}
		else
		{
			$result=$obj_project->hrmgt_add_project($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=project&tab=project_list&message=pro_add');
			}
		}
	}
	
	if(isset($_POST['save_task']))		
	{	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=project&tab=task_list&message=task_edit');
			}
		}
		else
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=project&tab=task_list&message=task_add');
			}
		}
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		if(isset($_REQUEST['project_id']))
		{
			$result=$obj_project->hrmgt_delete_project($_REQUEST['project_id']);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=project&tab=project_list&message=pro_del');
			}
		}
		if(isset($_REQUEST['task_id']))
		{
			$result=$obj_office->hrmgt_delete_tasks($_REQUEST['task_id']);
			if($result){
				wp_redirect ('?hr-dashboard=user&page=project&tab=task_list&message=tesk_del');
			}
		}
	}
	
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
	?> 
	<?php if($message == "pro_add"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Project inserted successfully','hr_mgt');?></p></div>
	<?php } ?>
	<?php if($message == "pro_edit"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Project updated successfully','hr_mgt');?></p></div>
	<?php } ?>
	<?php if($message == "pro_del"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Project deleted successfully','hr_mgt');?></p></div>
	<?php } ?>
	<?php if($message == "task_add"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Task inserted successfully','hr_mgt');?></p></div>
	<?php } ?>
	<?php if($message == "task_edit"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Task updated successfully','hr_mgt');?></p></div>
	<?php } ?>
	<?php if($message == "task_del"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Task deleted successfully','hr_mgt');?></p></div>
	<?php } ?>			
	<?php } ?>
<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
		<div class="category_list"></div>    
	</div> 
</div>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	  	<li class="<?php if($active_tab=='project_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=project_list" class="tab <?php echo $active_tab == 'project_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Project List', 'hr_mgt'); ?></a>        
		</li>
		<?php if($role=="manager"){ ?>
		
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $active_tab=="add_project"){ ?>
		<li class="<?php if($active_tab=='add_project'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=add_project" class="tab <?php echo $active_tab == 'add_project' ? 'active' : ''; ?>">
            <?php _e('Edit Project', 'hr_mgt'); ?></a>          
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_project'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=add_project" class="tab <?php echo $active_tab == 'add_project' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Project', 'hr_mgt'); ?></a>         
		</li>			
		<?php } ?>
		<?php } ?>
		<li class="<?php if($active_tab=='task_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=task_list" class="tab <?php echo $active_tab == 'task_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Task List', 'hr_mgt'); ?></a>         
		</li>
		<?php if($role=="manager"){ ?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $active_tab=="add_task_time"){ ?>
		<li class="<?php if($active_tab=='add_task_time'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=add_task_time" class="tab <?php echo $active_tab == 'add_task_time' ? 'active' : ''; ?>">
              <?php _e('Edit Task Time', 'hr_mgt'); ?></a>         
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_task_time'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=project&tab=add_task_time" class="tab <?php echo $active_tab == 'add_task_time' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Task Time', 'hr_mgt'); ?></a>          
		</li>			
		<?php } ?>		
		<?php } ?>
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'project_list'){ ?>		
		<div class="">
		<form name="activity_form" action="" method="post">
    
        <div class="">
        	<div class="table-responsive">
        <table id="project_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th><?php _e( 'Project Title', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Client Name', 'hr_mgt' ) ;?></th>			 
				<th><?php _e( 'Project Start Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Project End Date', 'hr_mgt' ) ;?></th>	
				<th><?php _e( 'Actual Completion Date', 'hr_mgt' ) ;?></th>			  
				<th><?php  _e( 'Status', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Project Title', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Client Name', 'hr_mgt' ) ;?></th>			  
				<th><?php _e( 'Project Start Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Project End Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Actual Completion Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
         <?php
			if($role=="manager")
			{				
				$projectdata=$obj_project->get_all_project();
			}
			else
			{
				$id = get_current_user_id();
				$projectdata=$obj_project->get_user_project($id);
			}	
			
		 if(!empty($projectdata))
		 {
		 	foreach ($projectdata as $retrieved_data)
			{ ?>
            <tr>
			<?php if($role=="manager"){ ?>
			<td class="title"><a href="?hr-dashboard=user&page=project&tab=add_project&action=edit&project_id=<?php print $retrieved_data->id; ?>"><?php echo $retrieved_data->project_title;?></a></td>
			<?php } else{ ?>	
			<td class="title"><?php echo $retrieved_data->project_title;?></td>
			<?php } ?>
				<td class="purpose"><?php echo $retrieved_data->client_name;?></td>
			
				<td class="start"><?php echo hrmgt_change_dateformat($retrieved_data->start_date);?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->end_date);?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->completion_date);?></td>
				<td class="end"><?php echo $retrieved_data->status;?></td>
				
				<td class="action">
					<a href="" class="btn btn-primary view-project" id="<?php print $retrieved_data->id ?>" ><?php _e("View","hr_mgt");?></a>
					<?php if($role=="manager"){ ?>
						<a href="?hr-dashboard=user&page=project&tab=add_project&action=edit&project_id=<?php print $retrieved_data->id; ?>" class="btn btn-info"> Edit</a>
						<a href="?hr-dashboard=user&page=project&tab=project_list&action=delete&project_id=<?php print $retrieved_data->id; ?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">Delete</a>
					<?php }?>
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
<?php if($active_tab == 'task_list'){ ?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#task_list').DataTable({
		"order": [[ 0, "asc" ]],
		"aoColumns":[	                 
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}]
		});
} );
</script>
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
				<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
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
				<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
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
		 if(!empty($taskdata)) {
		 	foreach ($taskdata as $retrieved_data){ ?>
            <tr>
			<?php if($role=="manager"){ ?> 
				<td class="Employee"><a href="?hr-dashboard=user&page=project&tab=add_task_time&action=edit&task_id=<?php print $retrieved_data->id; ?>"><?php echo $retrieved_data->work_title;?></a></td>
			<?php } else{ ?>
				<td class="Employee"><?php echo $retrieved_data->work_title;?></td>
			<?php } ?>				
				<td class="working date"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
				<td class="Project Name"><?php echo hrmgt_get_project_title($retrieved_data->task_cat_id);?></td>
				<td class="task cat"><?php echo hrmgt_change_dateformat($retrieved_data->working_date);?></td>
				<td class="working date"><?php echo $retrieved_data->start_time;?></td>
				<td class="start time"><?php echo $retrieved_data->end_time;?></td>
				<td style="text-transform:capitalize"><?php echo $retrieved_data->status;?></td>
				<td class="action">
				<a href="#" class="btn btn-primary view-tasklist" id="<?php print $retrieved_data->id; ?>"> View</a>
				<?php if($role=="manager"){ ?> 
					<a href="?hr-dashboard=user&page=project&tab=add_task_time&action=edit&task_id=<?php print $retrieved_data->id; ?>" class="btn btn-info"> Edit</a>
					<a href="?hr-dashboard=user&page=project&tab=task_list&action=delete&task_id=<?php print $retrieved_data->id; ?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">Delete</a>
				<?php } ?>
                </td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
<?php } ?>
<?php if($active_tab=="add_project"){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#employee').multiselect({
		includeSelectAllOption: true,		
	}); 
	
	$('#perfomance_form').validationEngine();
	$('#start_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
	    yearRange:'-65:+65',
	    onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	    },
		onSelect: function(selected) {
			$("#end_date").datepicker("option","minDate", selected)
		}
    }); 
	
	$('#end_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
	    yearRange:'-65:+65',
	    onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    },
		onSelect: function(selected) {
			$("#start_date").datepicker("option","maxDate", selected)
		}
    });  
	  
	$('#completion_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'-65:+65',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		}
	});
	$('#employee').multiselect({
		includeSelectAllOption: true,		
	}); 
	  
});
</script>
     <?php 	                                 
			$project_id=0;
			if(isset($_REQUEST['project_id']))
				$project_id=$_REQUEST['project_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_project->hrmgt_get_single_project($project_id);
					$employee_project = $obj_project->hrmgt_get_project_employee($project_id);
					$employees_id = array();
					foreach($employee_project as $key=>$value){
						$employees_id[] = $value->employee_id;
					}
				} ?>
		<div class="panel-body">
        <form name="perfomance_form" action="" method="post" class="form-horizontal" id="perfomance_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="project_id" value="<?php echo $project_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" id="employee" name="employee_id[]" Multiple>				
				<?php			
					$employee = "";		
					
					$employeedata = hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{						
						foreach ($employeedata as $retrive_data)
						{ ?>
						<option  value="<?php print $retrive_data->ID; ?>"	<?php  if ($edit) { if(in_array($retrive_data->ID,$employees_id)){ print 'selected="selected"'; } } ?>> <?php print $retrive_data->display_name?></option>
					<?php	} 	} ?>
				</select>
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Project Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->project_title;}elseif(isset($_POST['project_title'])) echo $_POST['project_title'];?>" name="project_title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="client_name"><?php _e('Client Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="client_name" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->client_name;}elseif(isset($_POST['client_name'])) echo $_POST['client_name'];?>" name="client_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Project Start Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="start_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->start_date));}elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>" name="start_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Project End Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="end_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->end_date)) ;}elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>" name="end_date">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="completion_date"><?php _e('Actual Completion Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="completion_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->completion_date)) ;}elseif(isset($_POST['completion_date'])) echo $_POST['completion_date'];?>" name="completion_date">
			</div>
		</div>	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="status"><?php _e('Status','hr_mgt');?></label>
			<div class="col-sm-8" >
				<select id="status" name="status" class="form-control">				
					<option value="Delay" <?php	if(isset($result->status)){	if($result->status =='Delay'){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Delay','hr_mgt');?></option>
					<option value="In Progress" <?php	if(isset($result->status)){	if($result->status =='In Progress'){echo 'selected="selected"';}else{echo '';}}?>><?php _e('In Progress','hr_mgt');?></option>
					<option value="Pending" <?php	if(isset($result->status)){	if($result->status =='Pending'){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Pending','hr_mgt');?></option>									
					<option value="Complete" <?php	if(isset($result->status)){	if($result->status =='Complete'){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Complete','hr_mgt');?></option>									
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="remark"><?php _e('Remark','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="remark" class="form-control" name="remark"><?php if($edit){echo $result->remark; }elseif(isset($_POST['remark'])) echo $_POST['remark']; ?> </textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Project','hr_mgt');}?>" name="save_project" class="btn btn-success"/>
        </div>
		</form>
</div>
<?php } ?>
<?php 
if($active_tab=="add_task_time"){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.timepicker').timepicker();
	$('#task_form').validationEngine();
	$('#working_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+65',
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
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_office->hrmgt_get_single_tasks($task_id);					
				}
				?>
	<div class="panel-body">
        <form name="task_form" action="" method="post" class="form-horizontal" id="task_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="task_id" value="<?php echo $task_id;?>"  />
		
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
				value="<?php if($edit){ echo date("Y-m-d",strtotime($result->working_date)) ;}elseif(isset($_POST['working_date'])) echo $_POST['working_date'];?>">
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
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Status','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php if($edit){ $status =  $result->status; } ?>				
				<select name="status" class="form-control">
					<option value="" ><?php _e('Select Status','hr_mgt');?></option>					
					<option value="delay" <?php	if(isset($status)){ if($status == "delay"){ echo 'selected="selected"';}else{echo '';} }?>><?php _e('Delay','hr_mgt');?></option>
					<option value="process" <?php  if(isset($status)){	if($status == "process"){echo 'selected="selected"';}else{echo '';}}?>><?php _e('In process','hr_mgt');?></option>
					<option value="pending" <?php	if(isset($status)){	if($status == "pending"){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Pending','hr_mgt');?></option>
					<option value="complete" <?php	if(isset($status)){	if($status == "complete"){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Complete','hr_mgt');?></option>
				</select>				
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