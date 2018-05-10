<script type="text/javascript">
$(document).ready(function() {
	$('#leave_form').validationEngine();
});
</script>
<?php 	                                 
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
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
			</select>
			</div>
		</div>
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