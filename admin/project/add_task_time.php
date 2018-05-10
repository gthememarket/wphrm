<script type="text/javascript">
$(document).ready(function() {
	$('.timepicker').timepicker();
	$('#task_form').validationEngine();
	$('#working_date').datepicker({
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
				$employeedata=hrmgt_get_working_user('employee');
				if(!empty($employeedata))
				{
					foreach ($employeedata as $retrive_data)
					{ 
						echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				}
		?>
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
			<label class="col-sm-2 control-label" for="work_title"><?php _e('Task Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="work_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->work_title;}elseif(isset($_POST['work_title'])) echo $_POST['work_title'];?>" name="work_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="working_date"><?php _e('Working Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="working_date" class="form-control validate[required]" type="text"  name="working_date" 
				value="<?php if($edit){ echo date("Y-m-d",strtotime($result->working_date)); } elseif(isset($_POST['working_date'])) echo $_POST['working_date'];?>">
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