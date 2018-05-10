<script type="text/javascript">
$(document).ready(function() {
	$('#perfomance_form').validationEngine();
	$('#employee').multiselect({
		includeSelectAllOption: true,		
	}); 
	
	$('#start_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
		yearRange: "-10:+10",
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
		yearRange: "-10:+10",
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
	        yearRange: "-10:+10",
	    onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    }
    });
});
</script>
<?php 	                                 
	$project_id=0;
	if(isset($_REQUEST['project_id']))
		$project_id=$_REQUEST['project_id'];
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$result = $obj_project->hrmgt_get_single_project($project_id);
		$employee_project = $obj_project->hrmgt_get_project_employee($project_id);
		$employees_id = array();
		foreach($employee_project as $key=>$value)
		{
			$employees_id[] = $value->employee_id;
		}						
	}
	?>
<div class="panel-body">
    <form name="perfomance_form" action="" method="post" class="form-horizontal" id="perfomance_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="project_id" value="<?php echo $project_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">			
				<select class="form-control validate[required]" id="employee" name="employee_id[]" Multiple required="required">				
				<?php			
					$employee = "";							
					$employeedata=hrmgt_get_working_user('employee');
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
			<label class="col-sm-2 control-label" for="description"><?php _e('Remark','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="remark"><?php if($edit){echo $result->remark; }elseif(isset($_POST['remark'])) echo $_POST['remark']; ?> </textarea>
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