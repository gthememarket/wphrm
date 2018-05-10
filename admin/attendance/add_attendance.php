<script type="text/javascript">
$(document).ready(function() {
	$('#attendance_form').validationEngine();
	$('#attendance_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+65',
			maxDate: 0,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
	  $('.timepicker').timepicker();
} );
</script>
     <?php 	
			$attendance_id=0;
			if(isset($_REQUEST['attendance_id']))
				$attendance_id=$_REQUEST['attendance_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_attendance->hrmgt_get_single_attendance($attendance_id);
					
				} ?>
	<div class="panel-body">
        <form name="attendance_form" action="" method="post" class="form-horizontal" id="attendance_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="attendance_id" value="<?php echo $attendance_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required] " name="employee_id">
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
			<label class="col-sm-2 control-label" for="attendance_date"><?php _e('Attendance Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="attendance_date" class="form-control validate[required]" type="text"  name="attendance_date" 
				value="<?php if($edit){ echo $result->attendance_date;}elseif(isset($_POST['attendance_date'])) echo $_POST['attendance_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="signin_time"><?php _e('Sign In Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="signin_time" class="form-control validate[required] timepicker" type="text" 
				value="<?php if($edit){ echo $result->signin_time;}elseif(isset($_POST['signin_time'])) echo $_POST['signin_time'];?>" 
				name="signin_time" placeholder="Time"  data-minute-step="15" data-show-meridian="false" 
				data-default-time="9:00:00" data-show-seconds="true" data-template="dropdown">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="signout_time"><?php _e('Sign Out Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="signout_time" class="form-control validate[required] timepicker" type="text" 
				value="<?php if($edit){ echo $result->signout_time;}elseif(isset($_POST['signout_time'])) echo $_POST['signout_time'];?>" 
				name="signout_time" placeholder="Time"  data-minute-step="15" data-show-meridian="false" 
				data-default-time="18:15:00" data-show-seconds="true" data-template="dropdown">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="lunch_start_time"><?php _e('Lunch Start Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="lunch_start_time" class="form-control validate[required] timepicker" type="text" 
				value="<?php if($edit){ echo $result->lunch_start_time;}elseif(isset($_POST['lunch_start_time'])) echo $_POST['lunch_start_time'];?>" 
				name="lunch_start_time" placeholder="Time"  data-minute-step="10" data-show-meridian="false" 
				data-default-time="12:15:00" data-show-seconds="true" data-template="dropdown">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="lunch_end_time"><?php _e('Lunch End Time','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="lunch_end_time" class="form-control validate[required] timepicker" type="text" 
				value="<?php if($edit){ echo $result->lunch_end_time;}elseif(isset($_POST['lunch_end_time'])) echo $_POST['lunch_end_time'];?>" 
				name="lunch_end_time" placeholder="Time"  data-minute-step="10" data-show-meridian="false" 
				data-default-time="12:30:00" data-show-seconds="true" data-template="dropdown">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Note','hospital_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="note" class="form-control" name="note"><?php if($edit){echo $result->note; }elseif(isset($_POST['note'])) echo $_POST['note']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Attendance','hr_mgt');}?>" name="save_attendance" class="btn btn-success"/>
        </div>
		</form>
    </div>